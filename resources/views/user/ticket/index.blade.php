@extends('layouts.app')



@section('content')
    <!-- Tickets Toolbar -->
    <section
        class="flex flex-wrap items-center justify-between px-6 py-3 mt-16 bg-white border-b dark:bg-gray-800 dark:border-gray-700">

        <!-- Left side: Title + dropdown -->
        <div class="flex items-center space-x-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tickets</h2>

            <!-- Status dropdown -->
            <button id="dropdownStatusButton" data-dropdown-toggle="dropdownStatus"
                class="text-sm text-gray-600 dark:text-gray-300 font-medium flex items-center hover:text-gray-900 dark:hover:text-white">
                All open tickets
                <svg class="w-3 h-3 ms-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownStatus"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownStatusButton">
                    <li><a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">All
                            tickets</a></li>
                    <li><a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Open
                            tickets</a></li>
                    <li><a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Closed
                            tickets</a></li>
                </ul>
            </div>
        </div>

        <!-- Center group: Filter + count + search -->
        <!-- Center group moved to right -->
        <div class="flex items-center space-x-4 ml-auto justify-end">

            <!-- Filter dropdown -->
            <button id="dropdownFilterButton" data-dropdown-toggle="dropdownFilter"
                class="flex items-center text-teal-600 text-sm font-medium hover:text-teal-700 dark:text-teal-400">
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

            <!-- Filter Dropdown Menu -->
            <div id="dropdownFilter"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownFilterButton">
                    <li><a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Priority:
                            High</a></li>
                    <li><a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Priority:
                            Low</a></li>
                    <li><a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Assigned
                            to me</a></li>
                </ul>
            </div>

            <!-- Count -->
            <span class="text-sm text-gray-500 dark:text-gray-400">0 of 20 selected</span>

            <!-- Search box -->
            <form class="relative">
                <input type="text" id="table-search"
                    class="block w-64 p-2 ps-3 text-sm text-gray-900 border border-gray-300 rounded-md bg-gray-50 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Search">
                <button type="submit"
                    class="absolute right-2.5 top-2.5 text-gray-500 hover:text-gray-700 dark:text-gray-300">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0 0A7 7 0 1 0 3 3a7 7 0 0 0 12 12z" />
                    </svg>
                </button>
            </form>
        </div>

    </section>


    <!-- Tickets Table -->
    <div class="relative overflow-x-auto bg-white border-x border-b">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs uppercase bg-gray-50 text-gray-600">
                <tr>
                    <th scope="col" class="p-3">
                        <input type="checkbox"
                            class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500">
                    </th>
                    <th scope="col" class="px-4 py-3">Priority</th>
                    <th scope="col" class="px-4 py-3">Display id</th>
                    <th scope="col" class="px-4 py-3">Customer Full Name</th>
                    <th scope="col" class="px-4 py-3">Assignee Name</th>
                    <th scope="col" class="px-4 py-3">Summary</th>
                    <th scope="col" class="px-4 py-3">Status</th>
                    <th scope="col" class="px-4 py-3">Last Modified Date</th>
                </tr>
            </thead>

            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3"><input type="checkbox"
                            class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500"></td>
                    <td class="px-4 py-2">S4</td>
                    <td class="px-4 py-2">WO00923453</td>
                    <td class="px-4 py-2">Afiq Ahmad</td>
                    <td class="px-4 py-2">Shafiq Aiman</td>
                    <td class="px-4 py-2">MDM - Master Data Operation - Customer</td>
                    <td class="px-4 py-2"><span class="text-yellow-600 font-medium">Pending</span></td>
                    <td class="px-4 py-2">Jul 7, 2025, 10:09:36 AM</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3"><input type="checkbox"
                            class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500"></td>
                    <td class="px-4 py-2">S4</td>
                    <td class="px-4 py-2">WO00923453</td>
                    <td class="px-4 py-2">Zahira Ismail</td>
                    <td class="px-4 py-2">Shafiq Aiman</td>
                    <td class="px-4 py-2">MDM - Master Data Operation - External Customer</td>
                    <td class="px-4 py-2"><span class="text-yellow-600 font-medium">Pending</span></td>
                    <td class="px-4 py-2">Jul 7, 2025, 10:09:36 AM</td>
                </tr>

            </tbody>
        </table>
    </div>
@endsection
