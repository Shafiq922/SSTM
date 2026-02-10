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
}
