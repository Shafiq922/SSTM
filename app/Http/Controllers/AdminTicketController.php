<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketLog;
use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminTicketController extends Controller
{
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'assignee', 'category', 'subCategory', 'attachments', 'logs.user', 'logs.attachments', 'sla'])
            ->findOrFail($id);

        // Fetch IT Staff for Assignee Dropdown
        $itStaff = User::whereHas('role', function ($q) {
            $q->where('name', 'IT Staff');
        })->get();

        return view('admin.ticket.ticket-details', compact('ticket', 'itStaff'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
            'description' => 'required|string',
            'assignee_id' => 'nullable|exists:users,userID',
            'attachment' => 'nullable|file|max:10240',
            'impact_level' => 'nullable|string|in:High,Medium,Low',
            'urgency' => 'nullable|string|in:High,Medium,Low',
            'priority' => 'nullable|string|in:Critical,High,Medium,Low',
        ]);

        DB::beginTransaction();

        try {
            // 1. Track Changes for Logging
            $changes = [];

            // Status
            if ($ticket->status !== $request->status) {
                $changes[] = "Status updated from {$ticket->status} to {$request->status}";
                $ticket->status = $request->status;

                if ($request->status === 'Resolved' && !$ticket->resolved_at) {
                    $ticket->resolved_at = now();
                }
            }

            // Description
            if ($ticket->description !== $request->description) {
                $changes[] = "Description updated";
                $ticket->description = $request->description;
            }

            // Assignee
            if ($ticket->assigneeID != $request->assignee_id) {
                $oldAssignee = $ticket->assignee ? $ticket->assignee->name : 'Unassigned';
                $newAssigneeUser = User::find($request->assignee_id);
                $newAssignee = $newAssigneeUser ? $newAssigneeUser->name : 'Unassigned';

                $changes[] = "Assignee changed from {$oldAssignee} to {$newAssignee}";
                $ticket->assigneeID = $request->assignee_id;
            }

            // Handle Incident-specific fields (Impact & Urgency -> Auto-calculate Priority)
            if ($ticket->type === 'incident') {
                if ($request->has('impact_level') && $ticket->impact_level !== $request->impact_level) {
                    $changes[] = "Impact changed from {$ticket->impact_level} to {$request->impact_level}";
                    $ticket->impact_level = $request->impact_level;
                }

                if ($request->has('urgency') && $ticket->urgency !== $request->urgency) {
                    $changes[] = "Urgency changed from {$ticket->urgency} to {$request->urgency}";
                    $ticket->urgency = $request->urgency;
                }

                // Auto-calculate Priority from Impact and Urgency
                $priorityMatrix = [
                    'High' => ['High' => 'Critical', 'Medium' => 'High', 'Low' => 'Medium'],
                    'Medium' => ['High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low'],
                    'Low' => ['High' => 'Medium', 'Medium' => 'Low', 'Low' => 'Low'],
                ];
                $newPriority = $priorityMatrix[$ticket->impact_level][$ticket->urgency] ?? 'Low';
                if ($ticket->priority !== $newPriority) {
                    $changes[] = "Priority auto-calculated from {$ticket->priority} to {$newPriority}";
                    $ticket->priority = $newPriority;
                }
            }

            // Handle Service Request-specific field (Direct Priority)
            if ($ticket->type === 'service_request' && $request->has('priority')) {
                if ($ticket->priority !== $request->priority) {
                    $changes[] = "Priority changed from {$ticket->priority} to {$request->priority}";
                    $ticket->priority = $request->priority;
                }
            }

            $ticket->save();

            // 2. Handle Attachment
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                $path = $file->storeAs('attachments', $filename, 'public');

                Attachment::create([
                    'file_path' => $path,
                    'status' => 'Active',
                    'ticketID' => $ticket->ticketID,
                    'userID' => auth()->id(),
                ]);

                $changes[] = "New attachment added: {$file->getClientOriginalName()}";
            }

            // 3. Log Changes
            if (!empty($changes)) {
                TicketLog::create([
                    'ticketID' => $ticket->ticketID,
                    'userID' => auth()->id(),
                    'action' => 'Updated',
                    'description' => implode('. ', $changes) . '.',
                ]);
            }

            DB::commit();

            return redirect()->route('admin.ticket.details', $ticket->ticketID)
                ->with('success', 'Ticket updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update ticket: ' . $e->getMessage());
        }
    }

    /* Store a new note/comment */
    /* Store a new note/comment */
    public function storeNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
            'note_attachment' => 'nullable|file|max:10240', // 10MB Limit
        ]);

        DB::beginTransaction();

        try {
            $noteText = $request->note;

            // Create ticket log first
            $ticketLog = TicketLog::create([
                'ticketID' => $id,
                'userID' => auth()->id(),
                'action' => 'Note',
                'description' => $noteText,
            ]);

            // Handle Attachment - create as a separate record
            if ($request->hasFile('note_attachment')) {
                $file = $request->file('note_attachment');
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                $path = $file->storeAs('attachments', $filename, 'public');

                Attachment::create([
                    'file_path' => $path,
                    'status' => 'Active',
                    'ticketLogID' => $ticketLog->ticketLogID,
                    'ticketID' => $id,
                    'userID' => auth()->id(),
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Note added successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add note: ' . $e->getMessage());
        }
    }


    /* Delete an attachment */
    public function deleteAttachment($id)
    {
        $attachment = Attachment::findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }

            // Log the action
            TicketLog::create([
                'ticketID' => $attachment->ticketID,
                'userID' => auth()->id(),
                'action' => 'Updated',
                'description' => "Attachment deleted: " . basename($attachment->file_path),
            ]);

            // Delete record
            $attachment->delete();

            DB::commit();
            return back()->with('success', 'Attachment deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete attachment: ' . $e->getMessage());
        }
    }

    /**
     * Delete a ticket
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete all attachments and their files
            $attachments = Attachment::where('ticketID', $id)->get();
            foreach ($attachments as $attachment) {
                /** @var Attachment $attachment */
                if (Storage::disk('public')->exists($attachment->file_path)) {
                    Storage::disk('public')->delete($attachment->file_path);
                }
                $attachment->delete();
            }

            // Delete ticket (logs will cascade delete due to foreign key)
            $ticketNumber = $ticket->ticket_number;
            $ticket->delete();

            DB::commit();
            return redirect()->route('admin.tickets')
                ->with('success', "Ticket {$ticketNumber} deleted successfully");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete ticket: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete tickets
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required|string',
        ]);

        $ticketIds = explode(',', $request->ticket_ids);
        $ticketIds = array_filter($ticketIds); // Remove empty values

        if (empty($ticketIds)) {
            return back()->with('error', 'No tickets selected for deletion');
        }

        DB::beginTransaction();
        try {
            $deletedCount = 0;

            foreach ($ticketIds as $ticketId) {
                $ticket = Ticket::find($ticketId);

                if ($ticket) {
                    // Delete all attachments and their files
                    $attachments = Attachment::where('ticketID', $ticketId)->get();
                    foreach ($attachments as $attachment) {
                        /** @var Attachment $attachment */
                        if (Storage::disk('public')->exists($attachment->file_path)) {
                            Storage::disk('public')->delete($attachment->file_path);
                        }
                        $attachment->delete();
                    }

                    // Delete ticket
                    $ticket->delete();
                    $deletedCount++;
                }
            }

            DB::commit();
            return redirect()->route('admin.tickets')
                ->with('success', "{$deletedCount} ticket(s) deleted successfully");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete tickets: ' . $e->getMessage());
        }
    }
}
