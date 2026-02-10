<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Date ranges for trend calculation
        $thisWeekStart = Carbon::now()->startOfWeek();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        $yesterday = Carbon::yesterday();

        // Top Stats with real trends
        $totalTickets = Ticket::count();
        $totalTicketsLastWeek = Ticket::where('created_at', '<', $thisWeekStart)->count();
        $totalTicketsTrend = $totalTicketsLastWeek > 0
            ? round((($totalTickets - $totalTicketsLastWeek) / $totalTicketsLastWeek) * 100)
            : 0;

        $openTickets = Ticket::where('status', 'Open')->count();
        $openTicketsYesterday = Ticket::where('status', 'Open')
            ->whereDate('created_at', '<=', $yesterday)->count();
        $openTicketsTrend = $openTicketsYesterday > 0
            ? round((($openTickets - $openTicketsYesterday) / $openTicketsYesterday) * 100)
            : 0;

        $resolvedToday = Ticket::whereDate('resolved_at', Carbon::today())->count();
        $resolvedYesterday = Ticket::whereDate('resolved_at', $yesterday)->count();
        $resolvedTodayTrend = $resolvedYesterday > 0
            ? round((($resolvedToday - $resolvedYesterday) / $resolvedYesterday) * 100)
            : 0;

        $pendingTickets = Ticket::where('status', 'Pending')->count();
        $pendingYesterday = Ticket::where('status', 'Pending')
            ->whereDate('updated_at', '<=', $yesterday)->count();
        $pendingTrend = $pendingYesterday > 0
            ? round((($pendingTickets - $pendingYesterday) / $pendingYesterday) * 100)
            : 0;

        // Department Stats with real trends
        $departments = Department::all();
        $departmentStats = [];
        foreach ($departments as $dept) {
            $thisWeekCount = Ticket::whereHas('user', function ($q) use ($dept) {
                $q->where('departmentID', $dept->departmentID);
            })->where('status', 'Resolved')
                ->where('resolved_at', '>=', $thisWeekStart)
                ->count();

            $lastWeekCount = Ticket::whereHas('user', function ($q) use ($dept) {
                $q->where('departmentID', $dept->departmentID);
            })->where('status', 'Resolved')
                ->whereBetween('resolved_at', [$lastWeekStart, $lastWeekEnd])
                ->count();

            $totalCount = Ticket::whereHas('user', function ($q) use ($dept) {
                $q->where('departmentID', $dept->departmentID);
            })->where('status', 'Resolved')->count();

            $trend = $lastWeekCount > 0
                ? round((($thisWeekCount - $lastWeekCount) / $lastWeekCount) * 100)
                : 0;

            $departmentStats[] = [
                'name' => $dept->name,
                'count' => $totalCount,
                'trend' => $trend
            ];
        }
        $departmentStats = array_slice($departmentStats, 0, 4);

        // Priority Stats with real trends
        $priorities = ['Critical', 'High', 'Medium', 'Low'];
        $priorityStats = [];
        foreach ($priorities as $priority) {
            $thisWeekCount = Ticket::where('priority', $priority)
                ->where('status', 'Resolved')
                ->where('resolved_at', '>=', $thisWeekStart)
                ->count();

            $lastWeekCount = Ticket::where('priority', $priority)
                ->where('status', 'Resolved')
                ->whereBetween('resolved_at', [$lastWeekStart, $lastWeekEnd])
                ->count();

            $totalCount = Ticket::where('priority', $priority)
                ->where('status', 'Resolved')
                ->count();

            $trend = $lastWeekCount > 0
                ? round((($thisWeekCount - $lastWeekCount) / $lastWeekCount) * 100)
                : 0;

            $priorityStats[] = [
                'name' => $priority,
                'count' => $totalCount,
                'trend' => $trend
            ];
        }

        // SLA Metrics
        $slaBreached = Ticket::where('status', 'Breached')->count();
        $slaBreachedYesterday = Ticket::where('status', 'Breached')
            ->whereDate('updated_at', '<=', $yesterday)->count();
        $slaBreachedChange = $slaBreached - $slaBreachedYesterday;

        // At Risk: tickets nearing SLA breach
        $atRiskSla = Ticket::whereIn('status', ['Open', 'In Progress'])
            ->whereHas('sla', function ($q) {
                $q->whereRaw('DATE_ADD(tickets.created_at, INTERVAL sla.response_time_minutes MINUTE) <= DATE_ADD(NOW(), INTERVAL 30 MINUTE)')
                    ->whereRaw('DATE_ADD(tickets.created_at, INTERVAL sla.response_time_minutes MINUTE) > NOW()');
            })->count();

        // Within SLA: tickets that haven't breached
        $withinSla = Ticket::whereIn('status', ['Open', 'In Progress', 'Resolved', 'Closed'])
            ->where('status', '!=', 'Breached')
            ->count();

        // SLA Compliance percentage
        $slaCompliance = $totalTickets > 0
            ? round(($withinSla / $totalTickets) * 100)
            : 0;

        // Average Queue Time (in hours)
        $avgQueueTime = Ticket::where('status', 'Open')
            ->whereNull('assigneeID')
            ->avg(DB::raw('TIMESTAMPDIFF(HOUR, created_at, NOW())')) ?? 0;

        // Ticket Trends (Last 7 Days) - count all tickets created/resolved on each day
        $trendLabels = [];
        $trendOpen = [];
        $trendResolved = [];
        $trendPending = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trendLabels[] = $date->format('M d');

            // Count tickets created on this date (regardless of current status)
            $trendOpen[] = Ticket::whereDate('created_at', $date)->count();
            $trendResolved[] = Ticket::whereDate('resolved_at', $date)->count();
            $trendPending[] = Ticket::where('status', 'Pending')
                ->whereDate('created_at', '<=', $date)
                ->whereDate('updated_at', '>=', $date)
                ->count();
        }

        // Status Distribution
        $statusLabels = ['Open', 'Pending', 'Resolved', 'Closed', 'In Progress'];
        $statusData = [];
        foreach ($statusLabels as $status) {
            $statusData[] = Ticket::where('status', $status)->count();
        }

        // Priority Distribution for bar chart
        $priorityChartData = [
            Ticket::where('priority', 'Low')->count(),
            Ticket::where('priority', 'Medium')->count(),
            Ticket::where('priority', 'High')->count(),
            Ticket::where('priority', 'Critical')->count(),
        ];

        // Recent Tickets
        $recentTickets = Ticket::with(['user', 'assignee'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.analytics', compact(
            'totalTickets',
            'totalTicketsTrend',
            'openTickets',
            'openTicketsTrend',
            'resolvedToday',
            'resolvedTodayTrend',
            'pendingTickets',
            'pendingTrend',
            'departmentStats',
            'priorityStats',
            'slaBreached',
            'slaBreachedChange',
            'atRiskSla',
            'withinSla',
            'slaCompliance',
            'avgQueueTime',
            'trendLabels',
            'trendOpen',
            'trendResolved',
            'trendPending',
            'statusLabels',
            'statusData',
            'priorityChartData',
            'recentTickets'
        ));
    }
}
