<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserTicketController extends Controller
{
    /**
     * Store a new note/comment for a ticket by the user.
     */
    public function storeNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
            'note_attachment' => 'nullable|file|max:10240', // 10MB Limit
        ]);

        $ticket = Ticket::findOrFail($id);

        // Ensure user owns ticket or is allowed to comment (basic check)
        if ($ticket->userID !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

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

            return back()->with('success', 'Note posted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            // Delete uploaded file if DB fails
            if (isset($attachmentPath) && Storage::disk('public')->exists($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }
            return back()->with('error', 'Failed to post note: ' . $e->getMessage());
        }
    }
    /**
     * Update the ticket (Description only) and add new attachments.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'attachment' => 'nullable|file|max:10240', // 10MB Limit
        ]);

        $ticket = Ticket::findOrFail($id);

        if ($ticket->userID !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        DB::beginTransaction();

        try {
            // 1. Update Description if changed
            if ($ticket->description !== $request->description) {
                // Log the change
                TicketLog::create([
                    'ticketID' => $ticket->ticketID,
                    'userID' => auth()->id(),
                    'action' => 'Updated Ticket',
                    'description' => 'Updated ticket description.',
                ]);

                $ticket->description = $request->description;
                $ticket->save();
            }

            // 2. Handle New Attachment
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                $path = $file->storeAs('attachments', $filename, 'public');

                // Log the upload
                $log = TicketLog::create([
                    'ticketID' => $ticket->ticketID,
                    'userID' => auth()->id(),
                    'action' => 'Uploaded Attachment',
                    'description' => 'Uploaded new attachment: ' . $file->getClientOriginalName(),
                ]);

                Attachment::create([
                    'file_path' => $path,
                    'status' => 'Active',
                    'ticketLogID' => $log->ticketLogID, // Link to the log entry
                    'ticketID' => $ticket->ticketID,
                    'userID' => auth()->id(),
                ]);
            }

            DB::commit();
            return back()->with('success', 'Ticket updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update ticket: ' . $e->getMessage());
        }
    }

    /**
     * Delete an attachment.
     */
    public function deleteAttachment($id)
    {
        $attachment = Attachment::findOrFail($id);

        // Check ownership via Ticket
        $ticket = Ticket::findOrFail($attachment->ticketID);

        if ($ticket->userID !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }

            // Delete record
            $attachment->delete();

            // Log the deletion
            TicketLog::create([
                'ticketID' => $ticket->ticketID,
                'userID' => auth()->id(),
                'action' => 'Deleted Attachment',
                'description' => 'Deleted an attachment.',
            ]);

            return back()->with('success', 'Attachment deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete attachment: ' . $e->getMessage());
        }
    }
}
