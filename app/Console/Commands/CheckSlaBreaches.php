<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\TicketLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckSlaBreaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sla:check-breaches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for SLA breaches and automatically update ticket statuses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting SLA Check...');
        Log::info('SLA Check Started at ' . now());
        $updatedCount = 0;

        // Get all active tickets (not resolved, closed, cancelled, or already breached)
        $tickets = Ticket::with('sla')
            ->whereNotIn('status', ['Resolved', 'Closed', 'Cancelled', 'Breached'])
            ->get();

        Log::info('SLA Check: Found ' . $tickets->count() . ' active tickets.');
        $this->info('SLA Check: Found ' . $tickets->count() . ' active tickets.');

        foreach ($tickets as $ticket) {
            /** @var Ticket $ticket */
            $statusChanged = false;
            $oldStatus = $ticket->status;

            // Check Response Time Breach (only for Open tickets)
            if ($ticket->status === 'Open' && $ticket->response_due && $ticket->response_due->isPast()) {
                $ticket->status = 'In Progress';
                $statusChanged = true;
                Log::info("Ticket #{$ticket->ticket_number}: Response time exceeded, changed to In Progress");
            }

            // Debugging Output
            $resDue = $ticket->resolution_due;
            $isPast = $resDue ? ($resDue->isPast() ? 'YES' : 'NO') : 'N/A';
            $now = now();
            $this->info("Checking Ticket #{$ticket->ticket_number} (Status: {$ticket->status})");
            $this->info(" - SLA ID: " . ($ticket->slaID ?? 'None'));
            $this->info(" - Created At: " . $ticket->created_at);
            $this->info(" - Resolution Due: " . ($resDue ?? 'None'));
            $this->info(" - Now: $now");
            $this->info(" - Is Past?: $isPast");

            // Check Resolution Time Breach (for non-resolved tickets)
            if (
                !in_array($ticket->status, ['Resolved', 'Closed', 'Cancelled', 'Breached'])
                && $ticket->resolution_due
                && $ticket->resolution_due->isPast()
            ) {
                $ticket->status = 'Breached';
                $statusChanged = true;
                Log::warning("Ticket #{$ticket->ticket_number}: Resolution time exceeded, marked as Breached");
                $this->error(" -> MARKED AS BREACHED");
            }

            if ($statusChanged) {
                $ticket->save();

                // Log the status change
                TicketLog::create([
                    'ticketID' => $ticket->ticketID,
                    'userID' => null, // System action
                    'action' => 'Status Updated (Automated)',
                    'description' => "Status automatically changed from '{$oldStatus}' to '{$ticket->status}' due to SLA breach",
                ]);

                $updatedCount++;
            }
        }

        $this->info("SLA breach check completed. {$updatedCount} ticket(s) updated.");
        return 0;
    }
}
