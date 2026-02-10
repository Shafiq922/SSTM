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
    <div class="p-6 mt-20">
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
        <!-- Tickets Toolbar -->
        <section class="sticky top-16 z-30 flex flex-wrap items-center justify-between px-6 py-3 bg-gray-100 border-b">

            <!-- Left side: Title + dropdown -->
            <div class="flex items-center space-x-4">
                <h2 class="text-lg font-semibold text-gray-900 ">Tickets</h2>

                <!-- Status dropdown -->
                <button id="dropdownStatusButton" data-dropdown-toggle="dropdownStatus"
                    class="text-sm text-gray-700 font-medium flex items-center hover:text-gray-900">
                    {{ $filterLabel }}
                    <svg class="w-3 h-3 ms-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>

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
            </div>

            <div class="flex items-center space-x-4 ml-auto justify-end">

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
                    0 of 20 selected
                </span>

                <!-- Search -->
                <form class="relative">
                    <input type="text"
                        class="block w-64 p-2 ps-3 text-sm border border-gray-300 rounded-md bg-white focus:ring-teal-500 focus:border-teal-500"
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
            <div id="dropdownFilter" class="z-50 hidden w-96 rounded-lg border border-gray-200 bg-white shadow-lg">

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

                    <!-- Active Approval -->
                    <h2>
                        <button type="button"
                            class="flex w-full items-center justify-between py-2 px-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 focus:bg-gray-50 transition-colors"
                            data-accordion-target="#filter-1">
                            All Tickets
                            <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </h2>

                    <div id="filter-1" class="hidden pb-3 px-2">
                        <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                            <input type="checkbox"
                                class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:border-transparent"
                                data-group="All Tickets" data-value="Open Tickets">
                            Open Tickets
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                            <input type="checkbox"
                                class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:border-transparent"
                                data-group="All Tickets" data-value="Closed Tickets">
                            Closed Tickets
                        </label>
                    </div>

                    <!-- Department -->
                    <h2>
                        <button type="button"
                            class="flex w-full items-center justify-between py-2 px-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 focus:bg-gray-50 transition-colors"
                            data-accordion-target="#filter-2">
                            Department
                            <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </h2>

                    <div id="filter-2" class="hidden pb-3 px-2">
                        <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                            <input type="checkbox"
                                class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:border-transparent"
                                data-group="Department" data-value="Human Resource (HR)">
                            Human Resource (HR)
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                            <input type="checkbox"
                                class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:border-transparent"
                                data-group="Department" data-value="Finance (FIN)">
                            Finance (FIN)
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                            <input type="checkbox"
                                class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:border-transparent"
                                data-group="Department" data-value="Supply Chain (SUPP)">
                            Supply Chain (SUPP)
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                            <input type="checkbox"
                                class="filter-checkbox w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 hover:border-gray-400 rounded focus:ring-teal-500 focus:ring-2 focus:ring-offset-0 transition-none checked:hover:bg-teal-700 checked:hover:border-transparent"
                                data-group="Department" data-value="Procurement (PROC)">
                            Procurement (PROC)
                        </label>
                    </div>

                    <!-- Assignee -->
                    <h2>
                        <button type="button"
                            class="flex w-full items-center justify-between py-2 text-sm font-medium text-gray-700"
                            data-accordion-target="#filter-3">
                            Assignee
                            <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </h2>

                    <div id="filter-3" class="hidden pb-3">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" class="filter-checkbox" data-group="Assignee" data-value="Me">
                            Me
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" class="filter-checkbox" data-group="Assignee" data-value="Unassigned">
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


        <!-- Tickets Table -->
        <div class="relative overflow-x-auto bg-white border-x border-b">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-50 text-gray-600">
                    <tr>
                        <th scope="col" class="px-4 py-3">Display id</th>
                        <th scope="col" class="px-4 py-3">Priority</th>
                        <th scope="col" class="px-4 py-3">Estimated Waiting Time</th>
                        <th scope="col" class="px-4 py-3">Customer Full Name</th>
                        <th scope="col" class="px-4 py-3">Assignee Name</th>
                        <th scope="col" class="px-4 py-3">Summary</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3">Last Modified Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">
                                <a href="{{ route('user.ticket.details', $ticket->ticketID) }}"
                                    class="font-medium text-teal-600 hover:underline">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                @php
                                    $priorityClasses = match ($ticket->priority) {
                                        'Critical' => 'bg-red-100 text-red-800',
                                        'High' => 'bg-orange-100 text-orange-800',
                                        'Medium' => 'bg-yellow-100 text-yellow-800',
                                        'Low' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="{{ $priorityClasses }} w-20 inline-flex justify-center text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $ticket->priority }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-gray-500">
                                {{ $ticket->created_at ? $ticket->created_at->diffForHumans(null, true) : 'N/A' }}
                            </td>
                            <td class="px-4 py-2">{{ $ticket->user->name ?? 'Unknown' }}</td>
                            <td class="px-4 py-2">{{ $ticket->assignee->name ?? 'Unassigned' }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">
                                No tickets found for: {{ $filterLabel }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <script>
            <script>

                                                                //FILTER LOGIC

                const checkboxes = document.querySelectorAll('.filter-checkbox');
                const selectedFilters = document.getElementById('selectedFilters');
                const selectedCount = document.getElementById('selectedCount');

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

                selectedCount.textContent = `${count} of 20 selected`;
                                                                }

                                                                checkboxes.forEach(cb => cb.addEventListener('change', updateFilters));

                                                                document.getElementById('resetFilters').onclick = () => {
                    checkboxes.forEach(cb => cb.checked = false);
                updateFilters();
                                                                };

                                                                document.getElementById('clearFilters').onclick = () => {
                    checkboxes.forEach(cb => cb.checked = false);
                updateFilters();
                                                                };

                                                                document.getElementById('applyFilters').onclick = () => {
                    console.log('Filters applied');
                                                                };
        </script>
@endsection