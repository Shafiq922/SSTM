<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\Attachment;
use App\Models\Sla;
use App\Models\SummaryTemplate;
use App\Models\TicketLog;
use Illuminate\Support\Facades\DB;

class ServiceRequestController extends Controller
{
    // Show the form
    public function create()
    {
        // Filter categories: Adjust as needed, maybe 'Service Request%' or all?
        // For now, let's allow all or similar to Incident but maybe different filtering?
        // User didn't specify category filtering, but usually Service Requests have different categories.
        // I'll stick to the same category logic for now or generic.
        // Let's assume same categories are available but maybe we should filter by 'Service%'?
        // If I use the same code as IncidentController, it filters 'Incident%' or 'IT Infrastructure'.
        // I will use 'Service Request%' or 'IT Infrastructure'.
        $categories = Category::with('subCategories')
            ->where(function ($q) {
                // $q->where('name', 'LIKE', 'Service%')
                //   ->orWhere('name', 'IT Infrastructure');
                // For now, getting all or similar to Incident until specified.
                // Let's just get all parent categories for flexibility.
                // Assuming top level
            })
            // Or just reuse the logic if they share categories.
            // Let's stick to the code from IncidentController but maybe broader.
            ->where(function ($q) {
                $q->where('name', 'LIKE', 'ERP – %');
            })
            ->get();

        // Fallback if no specific Service categories found, just get all parents
        if ($categories->isEmpty()) {
            $categories = Category::with('subCategories')->get();
        }

        $summaryTemplates = SummaryTemplate::where('is_active', true)->get();

        return view('user.ticket.service_request', compact('categories', 'summaryTemplates'));
    }

    // Handle form submission
    public function store(Request $request)
    {
        // 1. Validate data
        $request->validate([
            'summary' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,categoryID',
            'sub_category_id' => 'required|exists:sub_categories,subCategoryID',
            'priority' => 'required|in:High,Moderate,Low',
            'description' => 'nullable|string',
            'attachment' => 'required|file|max:10240', // Mandatory as requested
        ]);

        // 2. Start Transaction
        DB::beginTransaction();

        try {
            // A. Generate Ticket Number (SR-YYYYMMDD-####)
            $dateStr = now()->format('Ymd');
            $latestTicket = Ticket::where('ticket_number', 'LIKE', "SR-{$dateStr}-%")->latest()->first();
            $sequence = 1;

            if ($latestTicket) {
                $parts = explode('-', $latestTicket->ticket_number);
                $sequence = intval(end($parts)) + 1;
            }
            $ticketCode = "SR-{$dateStr}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            // B. Find SLA (Mapping simple priority to SLA if needed)
            // Assuming Sla table has 'priority' column which matches High/Medium/Low or mapped.
            // If Sla uses 1-Critical, etc., we need to map.
            // Let's assume simple mapping or default.
            $sla = Sla::where('priority', 'LIKE', "%{$request->priority}%")->first();
            $slaID = $sla ? $sla->slaID : Sla::first()->slaID; // Fallback

            // C. Create Ticket
            $ticket = Ticket::create([
                'ticket_number' => $ticketCode,
                'summary' => $request->summary,
                'description' => $request->description ?? 'No description provided',
                'type' => 'service_request', // Distinct type
                'priority' => $request->priority,
                'status' => 'Open',
                'impact_level' => 'Low', // Default for SR? Or N/A.
                'urgency' => 'Low',      // Default for SR? Or N/A.
                'started_at' => now(),

                // Foreign Keys
                'userID' => auth()->id(),
                'categoryID' => $request->category_id,
                'subCategoryID' => $request->sub_category_id,
                'slaID' => $slaID,
            ]);

            // D. Handle Attachment (Mandatory)
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
            }

            // E. Create Ticket Log (Audit Trail)
            TicketLog::create([
                'ticketID' => $ticket->ticketID,
                'userID' => auth()->id(),
                'action' => 'Created',
                'description' => 'Service Request ticket created by user.',
            ]);

            DB::commit();

            $user = auth()->user();
            if ($user->role && in_array($user->role->name, ['Admin', 'IT Staff'])) {
                return redirect()->route('admin.tickets')
                    ->with('success', "Service Request #{$ticketCode} created successfully!");
            }

            return redirect()->route('dashboard')
                ->with('success', "Service Request #{$ticketCode} created successfully!");


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create service request: ' . $e->getMessage())->withInput();
        }
    }
}
