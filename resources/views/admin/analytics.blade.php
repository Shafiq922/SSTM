@extends('layouts.app')

@section('content')
    <div class="px-3 sm:px-4 lg:px-6 py-6 pt-20 bg-gray-50 min-h-screen">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start gap-2 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Ticket Support Dashboard</h1>
                <p class="text-gray-500 text-sm">Monitor and manage your support tickets</p>
            </div>
            <span class="text-sm text-gray-500">Last updated: {{ now()->format('h:i:s A') }}</span>
        </div>

        <!-- Top Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- Total Tickets -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Tickets</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalTickets }}</p>
                        <p class="text-xs {{ $totalTicketsTrend >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                            {{ $totalTicketsTrend >= 0 ? '+' : '' }}{{ $totalTicketsTrend }}% from last week
                        </p>
                    </div>
                    <div class="text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Open Tickets -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-teal-600 mb-1">Open Tickets</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $openTickets }}</p>
                        <p class="text-xs {{ $openTicketsTrend >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                            {{ $openTicketsTrend >= 0 ? '+' : '' }}{{ $openTicketsTrend }}% from yesterday
                        </p>
                    </div>
                    <div class="text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Resolved Today -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Resolved Today</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $resolvedToday }}</p>
                        <p class="text-xs {{ $resolvedTodayTrend >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                            {{ $resolvedTodayTrend >= 0 ? '+' : '' }}{{ $resolvedTodayTrend }}% from yesterday
                        </p>
                    </div>
                    <div class="text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Pending</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $pendingTickets }}</p>
                        <p class="text-xs {{ $pendingTrend <= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                            {{ $pendingTrend >= 0 ? '+' : '' }}{{ $pendingTrend }}% from yesterday
                        </p>
                    </div>
                    <div class="text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Resolved by Department -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Tickets Resolved by Department</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($departmentStats as $dept)
                    <div class="bg-white rounded-lg border border-gray-200 p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">{{ $dept['name'] }}</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $dept['count'] }}</p>
                                <p class="text-xs {{ $dept['trend'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                                    {{ $dept['trend'] >= 0 ? '+' : '' }}{{ $dept['trend'] }}% from last week
                                </p>
                            </div>
                            <div class="text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tickets Resolved by Priority -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Tickets Resolved by Priority</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($priorityStats as $priority)
                    <div class="bg-white rounded-lg border border-gray-200 p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">{{ $priority['name'] }}</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $priority['count'] }}</p>
                                <p class="text-xs {{ $priority['trend'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                                    {{ $priority['trend'] >= 0 ? '+' : '' }}{{ $priority['trend'] }}% from last week
                                </p>
                            </div>
                            <div class="text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.054 0 1.502-1.32.653-1.919L13.634 4.342a.855.855 0 00-1.268 0L1.489 17.081c-.849.599-.401 1.919.653 1.919z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Queuing Metrics -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Queuing Metrics</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- SLA Breached -->
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">SLA Breached</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $slaBreached }}</p>
                            <p class="text-xs {{ $slaBreachedChange > 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                                {{ $slaBreachedChange >= 0 ? '+' : '' }}{{ $slaBreachedChange }} from yesterday
                            </p>
                        </div>
                        <div class="text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- At Risk of SLA Breach -->
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">At Risk of SLA Breach</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $atRiskSla }}</p>
                            <p class="text-xs text-red-600 mt-1">-5 from yesterday</p>
                        </div>
                        <div class="text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.054 0 1.502-1.32.653-1.919L13.634 4.342a.855.855 0 00-1.268 0L1.489 17.081c-.849.599-.401 1.919.653 1.919z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Within SLA -->
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Within SLA</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $withinSla }}</p>
                            <p class="text-xs text-green-600 mt-1">{{ $slaCompliance }}% compliance</p>
                        </div>
                        <div class="text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Avg Queue Time -->
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Avg Queue Time</p>
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($avgQueueTime, 1) }}h</p>
                            <p class="text-xs text-red-600 mt-1">-15% from yesterday</p>
                        </div>
                        <div class="text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Ticket Trends Chart -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ticket Trends (Last 7 Days)</h3>
                <canvas id="ticketTrendsChart" height="120"></canvas>
                <div class="flex justify-center gap-6 mt-4 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-teal-500"></span>
                        <span class="text-gray-600">Open</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                        <span class="text-gray-600">Resolved</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                        <span class="text-gray-600">Pending</span>
                    </div>
                </div>
            </div>

            <!-- Status Distribution Pie Chart -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Distribution</h3>
                <div style="height: 350px;">
                    <canvas id="statusDistributionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Priority Distribution Bar Chart -->
        <div class="bg-white rounded-lg border border-gray-200 p-5 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Priority Distribution</h3>
            <canvas id="priorityDistributionChart" height="60"></canvas>
        </div>

        <!-- Recent Tickets Table -->
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Tickets</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 border-b">
                        <tr>
                            <th class="px-4 py-3">Ticket ID</th>
                            <th class="px-4 py-3">Subject</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Priority</th>
                            <th class="px-4 py-3">Assignee</th>
                            <th class="px-4 py-3">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTickets as $ticket)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.ticket.details', $ticket->ticketID) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $ticket->ticket_number }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-blue-600">{{ Str::limit($ticket->summary, 30) }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $ticket->user->name ?? 'Unknown' }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'Open' => 'bg-blue-100 text-blue-800',
                                            'In Progress' => 'bg-yellow-100 text-yellow-800',
                                            'Pending' => 'bg-orange-100 text-orange-800',
                                            'Resolved' => 'bg-green-100 text-green-800',
                                            'Closed' => 'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2 py-1 rounded text-xs font-medium {{ $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ strtolower($ticket->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $priorityColors = [
                                            'Critical' => 'text-red-600',
                                            'High' => 'text-orange-600',
                                            'Moderate' => 'text-yellow-600',
                                            'Low' => 'text-green-600',
                                        ];
                                    @endphp
                                    <span class="font-medium {{ $priorityColors[$ticket->priority] ?? 'text-gray-600' }}">
                                        {{ strtolower($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $ticket->assignee->name ?? 'Unassigned' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $ticket->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">No tickets found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ticket Trends Line Chart
            const trendsCtx = document.getElementById('ticketTrendsChart').getContext('2d');
            new Chart(trendsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($trendLabels) !!},
                    datasets: [
                        {
                            label: 'Open',
                            data: {!! json_encode($trendOpen) !!},
                            borderColor: '#14b8a6',
                            backgroundColor: 'rgba(20, 184, 166, 0.1)',
                            tension: 0.3,
                            fill: false
                        },
                        {
                            label: 'Resolved',
                            data: {!! json_encode($trendResolved) !!},
                            borderColor: '#f97316',
                            backgroundColor: 'rgba(249, 115, 22, 0.1)',
                            tension: 0.3,
                            fill: false
                        },
                        {
                            label: 'Pending',
                            data: {!! json_encode($trendPending) !!},
                            borderColor: '#eab308',
                            backgroundColor: 'rgba(234, 179, 8, 0.1)',
                            tension: 0.3,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Status Distribution Pie Chart
            const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($statusLabels) !!},
                    datasets: [{
                        data: {!! json_encode($statusData) !!},
                        backgroundColor: ['#3b82f6', '#f97316', '#22c55e', '#6b7280', '#eab308'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                padding: 10,
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });

            // Priority Distribution Bar Chart
            const priorityCtx = document.getElementById('priorityDistributionChart').getContext('2d');
            new Chart(priorityCtx, {
                type: 'bar',
                data: {
                    labels: ['Low', 'Moderate', 'High', 'Critical'],
                    datasets: [{
                        label: 'Tickets',
                        data: {!! json_encode($priorityChartData) !!},
                        backgroundColor: '#3b82f6',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
@endsection