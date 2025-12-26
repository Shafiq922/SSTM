<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttachmentsTableSeeder extends Seeder
{
    public function run()
    {
        // Lookup Ticket IDs dynamically to handle auto-increment changes
        $ticket1 = DB::table('tickets')->where('ticket_number', 'INC-001')->first();
        $ticket2 = DB::table('tickets')->where('ticket_number', 'SR-001')->first();

        // Also valid to lookup Users, but assuming ID 1 & 2 exist from UsersTableSeeder
        // (Assuming Users are seeded first and IDs are somewhat stable, or lookup by email is better)
        // For now, let's fix the immediate crash which is ticketID.

        $attachments = [];

        if ($ticket1) {
            $attachments[] = [
                'file_path' => '/uploads/error_screenshot.png',
                'userID' => 1,
                'ticketID' => $ticket1->ticketID,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($ticket2) {
            $attachments[] = [
                'file_path' => '/uploads/request_doc.pdf',
                'userID' => 2,
                'ticketID' => $ticket2->ticketID,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (count($attachments) > 0) {
            // Using insertOrIgnore to skip duplicates if any unique constraints exist,
            // otherwise it just inserts. Since we fetched valid IDs, FK error is solved.
            // Note: Since attachments table likely has no unique constraint on content,
            // this will just insert. If you want true idempotency for attachments without unique keys,
            // you'd need to check existence manually or add a unique constraint.
            // For now, this fixes the foreign key crash.
            DB::table('attachments')->insertOrIgnore($attachments);
        }
    }
}
