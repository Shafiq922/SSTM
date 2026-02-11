@extends('layouts.app')



@section('content')
    <style>
        /* Force checkbox hover styles to override default plugin/browser behavior */
        .filter-checkbox:hover {
            border-color: #9ca3af !important;
            /* gray-400 */
        }

        .filter-checkbox:checked:hover {
            background-color: #0f766e !important;
            /* teal-700 */
            border-color: transparent !important;
        }

        /* Override Flowbite/Default Accordion Active Background */
        button[aria-expanded="true"] {
            background-color: transparent !important;
            color: #374151 !important;
            /* gray-700 */
        }

        button[aria-expanded="true"]:hover {
            background-color: #f9fafb !important;
            /* gray-50 */
        }
    </style>
    <div class="px-3 sm:px-4 lg:px-6 py-6 mt-20">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif
        <div class="sticky top-16 z-30 bg-gray-100/95 backdrop-blur-sm border-b shadow-sm">
            <!-- Tickets Toolbar -->
            <section class="flex flex-wrap items-center justify-between gap-3 px-3 sm:px-6 py-3">

                <!-- Left side: Title + dropdown -->
                <div class="flex items-center space-x-4">
                    <h2 class="text-lg font-semibold text-gray-900">Tickets</h2>



                    <!-- Dropdown menu -->
                    <div id="dropdownStatus"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownStatusButton">
                            <li><a href="{{ route('dashboard', ['filter' => 'all']) }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">All
                                    tickets</a></li>
                            <li><a href="{{ route('dashboard', ['filter' => 'open']) }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Open
                                    tickets</a></li>
                            <li><a href="{{ route('dashboard', ['filter' => 'closed']) }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Closed
                                    tickets</a></li>
                        </ul>
                    </div>

                    <!-- Priority Filter Badges -->
                    <div class="flex flex-wrap items-center gap-2 mt-2 sm:mt-0 sm:ml-6">
                        <span class="text-sm font-semibold text-gray-700 flex items-center gap-1">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 8v5l-4 2v-7L3 6V4z"></path>
                            </svg>
                            Filter Priority:
                        </span>

                        <a href="{{ route('admin.tickets', ['priority' => 'Critical']) }}" class="px-3 py-1 rounded-full text-xs font-semibold border transition-colors 
                                                                                                                                    {{ request('priority') == 'Critical'
        ? 'bg-red-100 text-red-800 border-red-300 ring-2 ring-red-200'
        : 'bg-white text-gray-600 border-gray-200 hover:bg-red-50 hover:text-red-700 hover:border-red-200' }}">
                            Critical
                        </a>

                        <a href="{{ route('admin.tickets', ['priority' => 'High']) }}"
                            class="px-3 py-1 rounded-full text-xs font-semibold border transition-colors 
                                                                                                                                    {{ request('priority') == 'High'
        ? 'bg-orange-100 text-orange-800 border-orange-300 ring-2 ring-orange-200'
        : 'bg-white text-gray-600 border-gray-200 hover:bg-orange-50 hover:text-orange-700 hover:border-orange-200' }}">
                            High
                        </a>

                        <a href="{{ route('admin.tickets', ['priority' => 'Moderate']) }}"
                            class="px-3 py-1 rounded-full text-xs font-semibold border transition-colors 
                                                                                                                                    {{ request('priority') == 'Moderate'
        ? 'bg-yellow-100 text-yellow-800 border-yellow-300 ring-2 ring-yellow-200'
        : 'bg-white text-gray-600 border-gray-200 hover:bg-yellow-50 hover:text-yellow-700 hover:border-yellow-200' }}">
                            Moderate
                        </a>

                        <a href="{{ route('admin.tickets', ['priority' => 'Low']) }}" class="px-3 py-1 rounded-full text-xs font-semibold border transition-colors 
                                                                                                                                    {{ request('priority') == 'Low'
        ? 'bg-green-100 text-green-800 border-green-300 ring-2 ring-green-200'
        : 'bg-white text-gray-600 border-gray-200 hover:bg-green-50 hover:text-green-700 hover:border-green-200' }}">
                            Low
                        </a>

                        @if(request('priority'))
                            <a href="{{ route('admin.tickets') }}"
                                class="text-xs text-gray-500 underline hover:text-gray-800 ml-2">Clear
                                Filter</a>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 sm:gap-4 ml-auto justify-end">

                    <!-- Filter button -->
                    <button id="dropdownFilterButton" data-dropdown-toggle="dropdownFilter"
                        data-dropdown-placement="bottom-start"
                        class="flex items-center text-teal-600 text-sm font-medium hover:text-teal-700">
                        <svg class="w-4 h-4 me-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 8v5l-4 2v-7L3 6V4z" />
                        </svg>
                        Filter
                        <svg class="w-3 h-3 ms-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Selected count -->
                    <span id="selectedCount" class="text-sm text-gray-500 whitespace-nowrap">
                        0 of {{ $tickets->count() }} selected
                    </span>

                    <!-- Delete Selected Button -->
                    <form id="bulkDeleteForm" action="{{ route('admin.tickets.bulk-delete') }}" method="POST"
                        onsubmit="return confirmBulkDelete();" style="display: none;" class="ml-2">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ticket_ids" id="ticketIdsInput">
                        <button type="submit"
                            class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Delete Selected
                        </button>
                    </form>

                    <!-- Search -->
                    <form class="relative w-full sm:w-auto">
                        <input type="text"
                            class="block w-full sm:w-64 p-2 ps-3 text-sm border border-gray-300 rounded-md bg-white focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Search">
                        <button type="submit" class="absolute right-2.5 top-2.5 text-gray-500">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0 0A7 7 0 1 0 3 3a7 7 0 0 0 12 12z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- FILTER DROPDOWN -->
                <div id="dropdownFilter"
                    class="z-50 hidden w-[calc(100vw-2rem)] sm:w-96 rounded-lg border border-gray-200 bg-white shadow-lg">

                    <!-- Selected filters -->
                    <div class="border-b p-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-700">Selected filters</h3>
                            <button id="clearFilters" class="text-xs text-teal-600 hover:underline">Clear</button>
                        </div>

                        <div id="selectedFilters" class="mt-2 flex flex-wrap gap-2"></div>
                    </div>

                    <!-- Accordion -->
                    <div id="filterAccordion" data-accordion="collapse" class="max-h-80 overflow-y-auto p-4">

                        <!-- All Tickets Filter -->
                        <h2>
                            <button type="button"
                                class="flex w-full items-center justify-between py-2 px-2 text-sm font-medium !text-gray-700 bg-transparent hover:bg-gray-50 rounded-lg transition-colors focus:ring-0"
                                data-accordion-target="#filter-1" aria-expanded="true">
                                All Tickets
                                <svg class="w-4 h-4 rotate-180 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </h2>

                        <div id="filter-1" class="hidden pb-3 px-2">
                            <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input type="checkbox"
                                    class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:!border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:!border-transparent"
                                    data-group="All Tickets" data-value="Open Tickets">
                                Open Tickets
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input type="checkbox"
                                    class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:!border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:!border-transparent"
                                    data-group="All Tickets" data-value="Closed Tickets">
                                Closed Tickets
                            </label>
                        </div>

                        <!-- Department -->
                        <h2>
                            <button type="button"
                                class="flex w-full items-center justify-between py-2 px-2 text-sm font-medium !text-gray-700 bg-transparent hover:bg-gray-50 rounded-lg transition-colors focus:ring-0"
                                data-accordion-target="#filter-2" aria-expanded="false">
                                Department
                                <svg class="w-4 h-4 rotate-180 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </h2>

                        <div id="filter-2" class="hidden pb-3 px-2">
                            <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input type="checkbox"
                                    class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:!border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:!border-transparent"
                                    data-group="Department" data-value="HR">
                                Human Resource (HR)
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input type="checkbox"
                                    class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:!border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:!border-transparent"
                                    data-group="Department" data-value="Finance">
                                Finance (FIN)
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input type="checkbox"
                                    class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:!border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:!border-transparent"
                                    data-group="Department" data-value="Supply Chain">
                                Supply Chain (SUPP)
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input type="checkbox"
                                    class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:!border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:!border-transparent"
                                    data-group="Department" data-value="Procurement">
                                Procurement (PROC)
                            </label>
                        </div>

                        <!-- Assignee -->
                        <h2>
                            <button type="button"
                                class="flex w-full items-center justify-between py-2 px-2 text-sm font-medium !text-gray-700 bg-transparent hover:bg-gray-50 rounded-lg transition-colors focus:ring-0"
                                data-accordion-target="#filter-3" aria-expanded="false">
                                Assignee
                                <svg class="w-4 h-4 rotate-180 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </h2>

                        <div id="filter-3" class="hidden pb-3 px-2">
                            <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input type="checkbox"
                                    class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:!border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:!border-transparent"
                                    data-group="Assignee" data-value="Me">
                                Me
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                                <input type="checkbox"
                                    class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:!border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:!border-transparent"
                                    data-group="Assignee" data-value="Unassigned">
                                Unassigned
                            </label>
                        </div>
                    </div>

                    <!-- Apply / Reset -->
                    <div class="sticky bottom-0 bg-white border-t p-3 flex gap-2">
                        <button id="resetFilters"
                            class="w-full rounded-md border border-gray-300 py-2 text-sm hover:bg-gray-100">
                            Reset
                        </button>
                        <button id="applyFilters"
                            class="w-full rounded-md bg-teal-600 py-2 text-sm text-white hover:bg-teal-700">
                            Apply
                        </button>
                    </div>
                </div>
            </section>



            <!-- Queuing Indicators -->
            <section class="px-6 py-4">
                <!-- Dashboard Metrics Container -->
                <div class="bg-teal-50 border border-teal-100 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        Queueing Indicators
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Card 1: Total Queue (Lq) -->
                        <div
                            class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                            <span class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total tickets in queue
                                (Lq)</span>
                            <span class="text-3xl font-bold text-gray-800 mt-2">{{ $totalTicketsInQueue }}</span>
                        </div>

                        <!-- Card 2: Avg Waiting Time (Wq) -->
                        <div
                            class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                            <span class="text-xs text-gray-500 font-medium uppercase tracking-wide">Average waiting time
                                (Wq)</span>
                            <span class="text-3xl font-bold text-gray-800 mt-2">{{ $avgWaitingTime }}</span>
                        </div>

                        <!-- Card 3: Active IT Staff (C) -->
                        <div
                            class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                            <span class="text-xs text-gray-500 font-medium uppercase tracking-wide">Number of active IT
                                staff
                                (C)</span>
                            <span class="text-3xl font-bold text-gray-800 mt-2">{{ $activeITStaff }}</span>
                        </div>

                        <!-- Card 4: Nearing SLA Breach -->
                        <div
                            class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                            <span class="text-xs text-gray-500 font-medium uppercase tracking-wide">Tickets nearing SLA
                                breach</span>
                            <span class="text-3xl font-bold text-red-600 mt-2">{{ $ticketsNearingSLA }}</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Tickets Table -->
        <div class="relative overflow-x-auto bg-white border-x border-b">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-50 text-gray-600">
                    <tr>
                        <th scope="col" class="p-3">
                            <input type="checkbox" id="checkbox-all"
                                class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500">
                        </th>
                        <th scope="col" class="px-4 py-3">Display id</th>
                        <th scope="col" class="px-4 py-3">Priority</th>
                        <th scope="col" class="px-4 py-3">Estimated Waiting Time to be Serve</th>
                        <th scope="col" class="px-4 py-3">Customer Full Name</th>
                        <th scope="col" class="px-4 py-3">Assignee Name</th>
                        <th scope="col" class="px-4 py-3">Summary</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3">Last Modified Date</th>
                        <th scope="col" class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="border-b hover:bg-teal-50/30 transition-colors duration-200" x-data="{ checked: false }">
                            <td class="p-3">
                                <input type="checkbox" x-model="checked" data-ticket-id="{{ $ticket->ticketID }}"
                                    class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 checkbox-item">
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.ticket.details', $ticket->ticketID) }}"
                                    class="font-medium text-teal-600 hover:underline">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                @php
                                    $priorityClasses = match ($ticket->priority) {
                                        'Critical' => 'bg-red-100 text-red-800',
                                        'High' => 'bg-orange-100 text-orange-800',
                                        'Moderate' => 'bg-yellow-100 text-yellow-800',
                                        'Low' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span
                                    class="{{ $priorityClasses }} w-20 inline-flex justify-center text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $ticket->priority }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @php
                                    $isCompleted = in_array($ticket->status, ['Resolved', 'Closed', 'Cancelled']);
                                    $responseDue = $ticket->response_due;
                                @endphp

                                @if($isCompleted)
                                    <span class="text-gray-400 text-xs">Completed</span>
                                @elseif($responseDue)
                                    @php
                                        $now = now();
                                        $remainingMinutes = (int) $now->diffInMinutes($responseDue, false);
                                        $totalMinutes = $ticket->sla->response_time_minutes ?? 1;

                                        if ($remainingMinutes <= 0) {
                                            $countdownColor = 'text-red-600 font-bold';
                                            $displayText = '0 minutes';
                                        } elseif ($remainingMinutes <= ($totalMinutes * 0.25)) {
                                            $countdownColor = 'text-orange-600 font-semibold';
                                            if ($remainingMinutes >= 60) {
                                                $hours = floor($remainingMinutes / 60);
                                                $mins = $remainingMinutes % 60;
                                                $displayText = $hours . 'h ' . $mins . 'm';
                                            } else {
                                                $displayText = $remainingMinutes . ' minutes';
                                            }
                                        } else {
                                            $countdownColor = 'text-green-600 font-medium';
                                            if ($remainingMinutes >= 60) {
                                                $hours = floor($remainingMinutes / 60);
                                                $mins = $remainingMinutes % 60;
                                                $displayText = $hours . 'h ' . $mins . 'm';
                                            } else {
                                                $displayText = $remainingMinutes . ' minutes';
                                            }
                                        }
                                    @endphp
                                    <span class="countdown-timer {{ $countdownColor }}"
                                        data-response-due="{{ $responseDue->toIso8601String() }}"
                                        data-total-minutes="{{ $totalMinutes }}">
                                        {{ $displayText }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">
                                        N/A
                                        <!-- DEBUG INFO -->
                                        (SLA ID: {{ $ticket->slaID ?? 'Null' }},
                                        Due: {{ $ticket->response_due ? 'Yes' : 'No' }})
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($ticket->user)
                                    <a href="{{ route('user.profile.view', $ticket->user->userID) }}"
                                        class="text-teal-600 hover:underline">
                                        {{ $ticket->user->name }}
                                    </a>
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($ticket->assignee)
                                    <a href="{{ route('user.profile.view', $ticket->assignee->userID) }}"
                                        class="text-teal-600 hover:underline">
                                        {{ $ticket->assignee->name }}
                                    </a>
                                @else
                                    Unassigned
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ Str::limit($ticket->summary, 50) }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $statusColor = match ($ticket->status) {
                                        'Open' => 'text-blue-600',
                                        'In Progress' => 'text-yellow-600',
                                        'Closed' => 'text-green-600',
                                        'Pending' => 'text-orange-600',
                                        'Resolved' => 'text-green-600',
                                        'Cancelled' => 'text-red-600',
                                        default => 'text-gray-600',
                                    };
                                @endphp
                                <span class="{{ $statusColor }} font-medium">{{ $ticket->status }}</span>
                            </td>
                            <td class="px-4 py-2">{{ $ticket->updated_at?->format('M d, Y, h:i A') ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-center">
                                <form x-show="checked" x-cloak action="{{ route('admin.ticket.delete', $ticket->ticketID) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete ticket {{ $ticket->ticket_number }}? This action cannot be undone.');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors"
                                        title="Delete ticket">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-4 text-center text-gray-500">
                                No tickets found for: {{ $filterLabel }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxAll = document.getElementById('checkbox-all');
                const checkboxItems = document.querySelectorAll('.checkbox-item');
                const selectedCount = document.getElementById('selectedCount');
                const totalItems = {{ $tickets->count() }};

                function updateSelectionCount() {
                    const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
                    if (selectedCount) {
                        selectedCount.textContent = `${checkedCount} of ${totalItems} selected`;
                    }
                }

                if (checkboxAll) {
                    checkboxAll.addEventListener('change', function () {
                        const isChecked = this.checked;
                        checkboxItems.forEach(checkbox => {
                            checkbox.checked = isChecked;
                            // Trigger Alpine.js state update
                            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                        });
                        updateSelectionCount();
                        updateBulkDeleteButton();
                    });

                    checkboxItems.forEach(checkbox => {
                        checkbox.addEventListener('change', function () {
                            if (!this.checked) {
                                checkboxAll.checked = false;
                            } else {
                                const allChecked = Array.from(checkboxItems).every(c => c.checked);
                                checkboxAll.checked = allChecked;
                            }
                            updateSelectionCount();
                            updateBulkDeleteButton();
                        });
                    });
                }

                // Update bulk delete button visibility
                function updateBulkDeleteButton() {
                    const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
                    const bulkDeleteForm = document.getElementById('bulkDeleteForm');

                    if (checkedCount > 0) {
                        bulkDeleteForm.style.display = 'block';
                        // Collect ticket IDs
                        const ticketIds = Array.from(document.querySelectorAll('.checkbox-item:checked'))
                            .map(cb => cb.dataset.ticketId);
                        document.getElementById('ticketIdsInput').value = ticketIds.join(',');
                    } else {
                        bulkDeleteForm.style.display = 'none';
                    }
                }

                // Confirm bulk delete
                function confirmBulkDelete() {
                    const count = document.querySelectorAll('.checkbox-item:checked').length;
                    return confirm(`Are you sure you want to delete ${count} ticket(s)? This action cannot be undone.`);
                }
            });

            document.addEventListener('DOMContentLoaded', () => {
                //FILTER LOGIC

                const checkboxes = document.querySelectorAll('.filter-checkbox');
                const selectedFilters = document.getElementById('selectedFilters');
                // selectedCount removed from filter logic

                // 1. Pre-check based on URL Params
                const urlParams = new URLSearchParams(window.location.search);
                checkboxes.forEach(cb => {
                    const group = cb.dataset.group;
                    const value = cb.dataset.value;
                    let paramName = '';

                    if (group === 'All Tickets') paramName = 'status[]';
                    else if (group === 'Department') paramName = 'department[]';
                    else if (group === 'Assignee') paramName = 'assignee[]';

                    // Check exact matches or "Open/Closed Tickets" mapping
                    if (urlParams.getAll(paramName).includes(value)) {
                        cb.checked = true;
                    }
                    // Special handling for "Open Tickets" value vs "Open" param
                    if (group === 'All Tickets') {
                        let status = value.replace(' Tickets', '');
                        if (urlParams.getAll('status[]').includes(status)) {
                            cb.checked = true;
                        }
                    }
                });
                updateFilters();

                function updateFilters() {
                    selectedFilters.innerHTML = '';
                    let count = 0;

                    checkboxes.forEach(cb => {
                        if (cb.checked) {
                            count++;
                            const chip = document.createElement('span');
                            chip.className = 'flex items-center gap-1 rounded-md bg-gray-100 border border-gray-200 px-3 py-1 text-xs text-gray-700';

                            chip.innerHTML = `
                                                                                ${cb.dataset.group}: ${cb.dataset.value}
                                                                                <button class="ml-1 text-gray-500">&times;</button>
                                                                            `;

                            chip.querySelector('button').onclick = () => {
                                cb.checked = false;
                                updateFilters();
                            };

                            selectedFilters.appendChild(chip);
                        }
                    });
                    // No longer updating selectedCount here
                }

                checkboxes.forEach(cb => cb.addEventListener('change', updateFilters));

                document.getElementById('resetFilters').onclick = () => {
                    checkboxes.forEach(cb => cb.checked = false);
                    updateFilters();
                    window.location.href = window.location.pathname;
                };

                const clearBtn = document.getElementById('clearFilters');
                if (clearBtn) {
                    clearBtn.onclick = () => {
                        checkboxes.forEach(cb => cb.checked = false);
                        updateFilters();
                        window.location.href = window.location.pathname;
                    };
                }

                document.getElementById('applyFilters').onclick = () => {
                    const params = new URLSearchParams();

                    checkboxes.forEach(cb => {
                        if (cb.checked) {
                            const group = cb.dataset.group;
                            const value = cb.dataset.value;

                            if (group === 'All Tickets') {
                                let status = value.replace(' Tickets', '');
                                params.append('status[]', status);
                            } else if (group === 'Department') {
                                params.append('department[]', value);
                            } else if (group === 'Assignee') {
                                params.append('assignee[]', value);
                            }
                        }
                    });

                    window.location.href = `${window.location.pathname}?${params.toString()}`;
                };

                // LIVE COUNTDOWN TIMER for Estimated Waiting Time
                function updateCountdowns() {
                    const timers = document.querySelectorAll('.countdown-timer');
                    const now = new Date();

                    timers.forEach(timer => {
                        const responseDue = new Date(timer.dataset.responseDue);
                        const totalMinutes = parseInt(timer.dataset.totalMinutes) || 1;
                        const diffMs = responseDue - now;
                        const remainingMinutes = Math.max(0, Math.floor(diffMs / 60000));

                        // Update display text
                        let displayText;
                        if (remainingMinutes <= 0) {
                            displayText = '0 minutes';
                        } else if (remainingMinutes >= 60) {
                            const hours = Math.floor(remainingMinutes / 60);
                            const mins = remainingMinutes % 60;
                            displayText = hours + 'h ' + mins + 'm';
                        } else {
                            displayText = remainingMinutes + ' minutes';
                        }
                        timer.textContent = displayText;

                        // Update color classes
                        timer.classList.remove(
                            'text-red-600', 'font-bold',
                            'text-orange-600', 'font-semibold',
                            'text-green-600', 'font-medium'
                        );

                        if (remainingMinutes <= 0) {
                            timer.classList.add('text-red-600', 'font-bold');
                        } else if (remainingMinutes <= (totalMinutes * 0.25)) {
                            timer.classList.add('text-orange-600', 'font-semibold');
                        } else {
                            timer.classList.add('text-green-600', 'font-medium');
                        }
                    });
                }

                // Update every 60 seconds
                setInterval(updateCountdowns, 60000);
            });
        </script>
@endsection