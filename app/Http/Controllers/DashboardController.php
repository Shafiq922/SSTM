<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::where('userID', auth()->id())->with(['user', 'assignee', 'sla']);

        // --- QUEUE POSITION LOGIC ---
        // 1. Find User's Top Priority Ticket (Open/In Progress)
        $userTopTicket = Ticket::where('userID', auth()->id())
            ->whereIn('status', ['Open', 'In Progress', 'Pending'])
            ->orderByRaw("
                CASE priority
                    WHEN 'Critical' THEN 1
                    WHEN 'High' THEN 2
                    WHEN 'Moderate' THEN 3
                    WHEN 'Low' THEN 4
                    ELSE 5
                END ASC,
                created_at ASC
            ")
            ->first();

        $positionInQueue = 0;
        $totalTicketsInQueue = 0;

        if ($userTopTicket) {
            // 2. Count how many tickets WITH SAME PRIORITY are ahead of this ticket
            // Ahead means: Same Priority AND Older
            $positionInQueue = Ticket::whereIn('status', ['Open', 'In Progress', 'Pending'])
                ->where('priority', $userTopTicket->priority) // SAME PRIORITY ONLY
                ->where('created_at', '<', $userTopTicket->created_at)
                ->count() + 1; // +1 because if 0 are ahead, I am #1

            // 3. Total Tickets in Queue (for THIS PRIORITY ONLY)
            $totalTicketsInQueue = Ticket::whereIn('status', ['Open', 'In Progress', 'Pending'])
                ->where('priority', $userTopTicket->priority) // SAME PRIORITY ONLY
                ->count();
        }

        // 1. Status Filter
        if ($request->has('status')) {
            $query->whereIn('status', $request->input('status'));
        } else {
            // Default: Show active tickets if no status filter is applied
            if (!$request->hasAny(['department', 'assignee'])) {
                $query->whereIn('status', ['Open', 'In Progress', 'Pending']);
            }
        }

        // 2. Department Filter (Based on Ticket Summary Prefix)
        if ($request->has('department')) {
            $departments = $request->input('department');

            // Map full names to prefixes
            $prefixMap = [
                'HR' => 'HR',
                'Finance' => 'FIN',
                'Supply Chain' => 'SUPP',
                'Procurement' => 'PROC'
            ];

            $query->where(function ($q) use ($departments, $prefixMap) {
                foreach ($departments as $dept) {
                    if (isset($prefixMap[$dept])) {
                        $prefix = $prefixMap[$dept];
                        $q->orWhere('summary', 'LIKE', "$prefix%");
                    }
                }
            });
        }

        // 3. Assignee Filter
        if ($request->has('assignee')) {
            $assignees = $request->input('assignee');
            $query->where(function ($q) use ($assignees) {
                if (in_array('Me', $assignees)) {
                    $q->orWhere('assigneeID', auth()->id());
                }
                if (in_array('Unassigned', $assignees)) {
                    $q->orWhereNull('assigneeID');
                }
                // If specific names were supported, we'd add them here
            });
        }

        // 4. Priority Filter
        if ($request->has('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        // --- Custom Sorting Logic ---
        // 1. Status: Active (Open/In Progress/Pending) assigned higher priority (0) than Checked/Closed (1)
        // 2. Priority: Critical (0), High (1), Moderate (2), Low (3)
        // 3. Created At: Ascending (Oldest First)

        $query->orderByRaw("
            CASE 
                WHEN status IN ('Resolved', 'Closed', 'Cancelled') THEN 1 
                ELSE 0 
            END ASC,
            CASE priority
                WHEN 'Critical' THEN 1
                WHEN 'High' THEN 2
                WHEN 'Moderate' THEN 3
                WHEN 'Low' THEN 4
                ELSE 5
            END ASC,
            created_at ASC
        ");

        // Calculate Active IT Staff (Available - No active tickets)
        $activeITStaff = \App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'IT Staff');
        })->whereDoesntHave('assignedTickets', function ($q) {
            $q->whereNotIn('status', ['Resolved', 'Closed', 'Cancelled']);
        })->count();

        $tickets = $query->get();
        $filterLabel = 'Filtered Tickets';

        return view('user.ticket.index', compact('tickets', 'filterLabel', 'activeITStaff', 'positionInQueue', 'totalTicketsInQueue'));
    }
}
