<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SummaryTemplate;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\Attachment;
use App\Models\Sla;
use Illuminate\Support\Facades\DB;

class IncidentController extends Controller
{
    // Show the form
    public function create()
    {
        // Filter categories: Only 'Incident%' and 'IT Infrastructure'
        $categories = Category::with('subCategories')
            ->where(function ($q) {
                $q->where('name', 'LIKE', 'Incident%')
                    ->orWhere('name', 'IT Infrastructure');
            })
            ->get();

        $summaryTemplates = SummaryTemplate::where('is_active', true)->get();

        return view('user.ticket.incident', compact('categories', 'summaryTemplates'));
    }

    // Handle form submission
    public function store(Request $request)
    {
        // 1. Validate data
        $request->validate([
            'summary' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,categoryID',
            'sub_category_id' => 'required|exists:sub_categories,subCategoryID',
            'impact' => 'required',
            'urgency' => 'required',
            'priority' => 'required',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        // 2. Start a Database Transaction (Safety Mechanism)
        // This ensures that if the attachment fails, the ticket isn't created.
        DB::beginTransaction();

        try {
            // A. Generate Professional Ticket Number (INC-YYYYMMDD-####)
            $dateStr = now()->format('Ymd');
            $latestTicket = Ticket::where('ticket_number', 'LIKE', "INC-{$dateStr}-%")->latest()->first();
            $sequence = 1;

            if ($latestTicket) {
                // Extract the last 4 digits and add 1
                $parts = explode('-', $latestTicket->ticket_number);
                $sequence = intval(end($parts)) + 1;
            }
            $ticketCode = "INC-{$dateStr}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);


            // B. Find Correct SLA based on Priority
            $sla = Sla::where('priority', $request->priority)->first();
            // Fallback: If no SLA matches the priority, grab the first one to prevent crash
            $slaID = $sla ? $sla->slaID : Sla::first()->slaID;


            // C. Create Ticket
            $ticket = Ticket::create([
                'ticket_number' => $ticketCode,
                'summary' => $request->summary,
                'description' => $request->description ?? 'No description provided',
                'type' => 'incident',
                'priority' => $request->priority,
                'status' => 'Open', // Default status
                'impact_level' => $request->impact,
                'urgency' => $request->urgency,
                'started_at' => now(),

                // Foreign Keys
                'userID' => auth()->id(),
                'categoryID' => $request->category_id,
                'subCategoryID' => $request->sub_category_id,
                'slaID' => $slaID,
            ]);

            // D. Handle Attachment
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                // Create a clean filename
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());

                $path = $file->storeAs('attachments', $filename, 'public');

                Attachment::create([
                    'file_path' => $path,
                    'status' => 'Active',
                    'ticketID' => $ticket->ticketID,
                    'userID' => auth()->id(),
                ]);
            }

            // E. Create Ticket Log (Audit Trail)
            TicketLog::create([
                'ticketID' => $ticket->ticketID,
                'userID' => auth()->id(),
                'action' => 'Created',
                'description' => 'Incident ticket created by user.',
            ]);

            DB::commit(); // Save everything to database

            return redirect()->route('dashboard') // Or wherever you want to go
                ->with('success', "Incident #{$ticketCode} created successfully!");

        } catch (\Exception $e) {
            DB::rollBack(); // Undo changes if something went wrong
            return back()->with('error', 'Error creating ticket: ' . $e->getMessage())->withInput();
        }
    }
}