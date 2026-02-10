@extends('layouts.app')

@section('content')
    <div class="mt-20 px-10 mb-20 max-w-7xl mx-auto">
        {{-- ADD THIS BLOCK START --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <strong class="font-bold">Whoops!</strong> There were some problems with your input.
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif
        {{-- ADD THIS BLOCK END --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-8">
            <h1 class="text-xl font-semibold mb-1">Create Incident</h1>
            <span class="text-sm tracking-wide text-gray-500 mb-10 block">New Ticket</span>

            <form class="space-y-10" action="{{ route('user.ticket.incident.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="category_id" id="input_category_id">
                <input type="hidden" name="sub_category_id" id="input_sub_category_id">
                <input type="hidden" name="impact" id="input_impact">
                <input type="hidden" name="urgency" id="input_urgency">
                <input type="hidden" name="priority" id="input_priority">


                <!-- Customer Info (Styled Block) -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block mb-2 text-xs font-medium text-gray-500 uppercase">Customer Name</label>
                            <div class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                            <input type="hidden" name="customer_name" value="{{ auth()->user()->name }}">
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-medium text-gray-500 uppercase">Input Phone</label>
                            <div class="text-sm font-semibold text-gray-800">{{ auth()->user()->user_phone }}</div>
                            <input type="hidden" name="customer_phone" value="{{ auth()->user()->user_phone }}">
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-medium text-gray-500 uppercase">Email Address</label>
                            <div class="text-sm font-semibold text-gray-800">{{ auth()->user()->email }}</div>
                            <input type="hidden" name="customer_email" value="{{ auth()->user()->email }}">
                        </div>
                    </div>
                </div>

                <!-- Summary Section -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Summary <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="summaryInput" name="summary"
                        class="w-full bg-gray-50 text-gray-900 text-sm rounded-xl border-transparent focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-200 block w-full p-4 transition-all duration-200 placeholder-gray-400 font-medium"
                        required placeholder="Enter a summary Template (eg: FIN)" autocomplete="off" />
                    <div id="summarySuggestions"
                        class="border border-gray-100 rounded-xl bg-white mt-2 hidden max-h-40 overflow-y-auto shadow-xl z-20">
                    </div>
                </div>

                <!-- Classification Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Category -->
                    <div class="relative">
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Category <span
                                class="text-red-500">*</span></label>
                        <button type="button" id="categoryDropdownButton"
                            class="w-full flex justify-between items-center bg-gray-50 text-gray-900 text-sm rounded-xl px-4 py-3.5 border-transparent hover:bg-white hover:ring-2 hover:ring-gray-200 focus:bg-white focus:ring-2 focus:ring-teal-500 transition-all duration-200">
                            <span id="categoryLabel" class="text-gray-500">Select category</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Dropdown Content -->
                        <div id="categoryDropdown"
                            class="hidden z-20 w-full bg-white rounded-xl shadow-xl border border-gray-100 absolute mt-2 max-h-60 overflow-y-auto">
                            <ul class="py-2 text-sm text-gray-700">
                                @foreach($categories as $category)
                                    <li>
                                        <button type="button"
                                            class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 category-option transition-colors"
                                            data-id="{{ $category->categoryID ?? $category->id }}"
                                            data-name="{{ $category->name }}">
                                            {{ $category->name }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Sub-category -->
                    <div class="relative">
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Sub-category <span
                                class="text-red-500">*</span></label>
                        <button type="button" id="subCategoryDropdownButton" disabled
                            class="w-full flex justify-between items-center bg-gray-50 text-gray-900 text-sm rounded-xl px-4 py-3.5 border-transparent opacity-60 cursor-not-allowed transition-all duration-200">
                            <span id="subCategoryLabel" class="text-gray-400">Select category first</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="subCategoryDropdown"
                            class="hidden z-20 w-full bg-white rounded-xl shadow-xl border border-gray-100 absolute mt-2 max-h-60 overflow-y-auto">
                            <ul class="py-2 text-sm text-gray-700" id="subCategoryList">
                                <!-- Populated by JS -->
                            </ul>
                        </div>
                    </div>

                    <!-- Impact -->
                    <div class="relative">
                        <div class="flex items-center gap-1 mb-2">
                            <label class="block text-sm font-semibold text-gray-700">Impact <span
                                    class="text-red-500">*</span></label>
                            <button data-popover-target="popover-matrix-impact" data-popover-placement="bottom"
                                type="button" class="text-gray-400 hover:text-teal-600 transition-colors">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Show information</span>
                            </button>
                            <div data-popover id="popover-matrix-impact" role="tooltip"
                                class="absolute z-50 invisible inline-block w-72 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xl opacity-0">
                                <div class="px-3 py-2 bg-slate-800 border-b border-gray-200 rounded-t-lg ">
                                    <h3 class="font-semibold text-white">Priority Matrix</h3>
                                </div>
                                <div class="px-3 py-2">
                                    <table class="w-full text-xs text-left text-gray-700 border border-gray-300">
                                        <thead class="text-xs text-gray-900 uppercase bg-gray-50 border-b border-gray-300">
                                            <tr>
                                                <th class="px-2 py-1 border-r border-gray-300 text-center">Impact</th>
                                                <th class="px-2 py-1 border-r border-gray-300 text-center">Urgency</th>
                                                <th class="px-2 py-1 text-center">Priority</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 font-bold text-red-600">1 - Critical</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 font-bold text-orange-500">2 - High</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 font-semibold text-yellow-600">3 - Moderate</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 font-bold text-orange-500">2 - High</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 font-semibold text-yellow-600">3 - Moderate</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 text-green-600">4 - Low</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 font-semibold text-yellow-600">3 - Moderate</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 text-green-600">4 - Low</td>
                                            </tr>
                                            <tr class="bg-white hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 text-blue-600">5 - Planning</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </div>
                        <button type="button" id="impactDropdownButton"
                            class="w-full flex justify-between items-center bg-gray-50 text-gray-900 text-sm rounded-xl px-4 py-3.5 border-transparent hover:bg-white hover:ring-2 hover:ring-gray-200 focus:bg-white focus:ring-2 focus:ring-teal-500 transition-all duration-200">
                            <span id="impactLabel" class="text-gray-500">Select</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="impactDropdown"
                            class="hidden z-20 w-full bg-white rounded-xl shadow-xl border border-gray-100 absolute mt-2">
                            <ul class="py-2 text-sm text-gray-700">
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 impact-option transition-colors"
                                        data-value="High">High</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 impact-option transition-colors"
                                        data-value="Medium">Medium</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 impact-option transition-colors"
                                        data-value="Low">Low</button></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Urgency -->
                    <div class="relative">
                        <div class="flex items-center gap-1 mb-2">
                            <label class="block text-sm font-semibold text-gray-700">Urgency <span
                                    class="text-red-500">*</span></label>
                            <button data-popover-target="popover-matrix-urgency" data-popover-placement="bottom"
                                type="button" class="text-gray-400 hover:text-teal-600 transition-colors">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Show information</span>
                            </button>
                            <div data-popover id="popover-matrix-urgency" role="tooltip"
                                class="absolute z-50 invisible inline-block w-72 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xl opacity-0">
                                <div class="px-3 py-2 bg-slate-800 border-b border-gray-200 rounded-t-lg ">
                                    <h3 class="font-semibold text-white ">Priority Matrix</h3>
                                </div>
                                <div class="px-3 py-2">
                                    <table class="w-full text-xs text-left text-gray-700 border border-gray-300">
                                        <thead class="text-xs text-gray-900 uppercase bg-gray-50 border-b border-gray-300">
                                            <tr>
                                                <th class="px-2 py-1 border-r border-gray-300 text-center">Impact</th>
                                                <th class="px-2 py-1 border-r border-gray-300 text-center">Urgency</th>
                                                <th class="px-2 py-1 text-center">Priority</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 font-bold text-red-600">1 - Critical</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 font-bold text-orange-500">2 - High</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 font-semibold text-yellow-600">3 - Moderate</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 font-bold text-orange-500">2 - High</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 font-semibold text-yellow-600">3 - Moderate</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 text-green-600">4 - Low</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 border-r border-gray-300">1 - High</td>
                                                <td class="px-2 py-1 font-semibold text-yellow-600">3 - Moderate</td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 border-r border-gray-300">2 - Medium</td>
                                                <td class="px-2 py-1 text-green-600">4 - Low</td>
                                            </tr>
                                            <tr class="bg-white hover:bg-gray-50">
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 border-r border-gray-300">3 - Low</td>
                                                <td class="px-2 py-1 text-blue-600">5 - Planning</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </div>
                        <button type="button" id="urgencyDropdownButton"
                            class="w-full flex justify-between items-center bg-gray-50 text-gray-900 text-sm rounded-xl px-4 py-3.5 border-transparent hover:bg-white hover:ring-2 hover:ring-gray-200 focus:bg-white focus:ring-2 focus:ring-teal-500 transition-all duration-200">
                            <span id="urgencyLabel" class="text-gray-500">Select</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="urgencyDropdown"
                            class="hidden z-20 w-full bg-white rounded-xl shadow-xl border border-gray-100 absolute mt-2">
                            <ul class="py-2 text-sm text-gray-700">
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 urgency-option transition-colors"
                                        data-value="High">High</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 urgency-option transition-colors"
                                        data-value="Medium">Medium</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 urgency-option transition-colors"
                                        data-value="Low">Low</button></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Priority (Calculated) -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Calculated Priority</label>
                        <input type="text" id="calculatedPriority"
                            class="w-full bg-gray-100 text-gray-500 text-sm rounded-xl border-transparent cursor-not-allowed block w-full p-3.5 font-medium"
                            disabled value="-" />
                    </div>

                    <!-- Status -->
                    <div class="relative">
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Status <span
                                class="text-red-500">*</span></label>
                        <button type="button" id="statusDropdownButton"
                            class="w-full flex justify-between items-center bg-gray-50 text-gray-900 text-sm rounded-xl px-4 py-3.5 border-transparent hover:bg-white hover:ring-2 hover:ring-gray-200 focus:bg-white focus:ring-2 focus:ring-teal-500 transition-all duration-200">
                            <span id="statusLabel" class="text-gray-900 font-medium">Open</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="statusDropdown"
                            class="hidden z-20 w-full bg-white rounded-xl shadow-xl border border-gray-100 absolute mt-2">
                            <ul class="py-2 text-sm text-gray-700">
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 status-option"
                                        data-value="Open">Open</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 status-option"
                                        data-value="Closed">Closed</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 status-option"
                                        data-value="In Progress">In Progress</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 status-option"
                                        data-value="Pending">Pending</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 status-option"
                                        data-value="Resolved">Resolved</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100 status-option"
                                        data-value="Cancelled">Cancelled</button></li>
                            </ul>
                        </div>
                    </div>

                </div>




                <!-- Description -->
                <div class="relative">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Description</label>
                    <textarea id="descriptionInput" name="description" rows="6"
                        class="w-full bg-gray-50 text-gray-900 text-sm rounded-xl border-transparent focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-200 block w-full p-4 transition-all duration-200 placeholder-gray-400"
                        placeholder="Provide a detailed description of the incident..."></textarea>
                    <span id="wordCountDisplay"
                        class="absolute bottom-3 right-3 text-xs text-gray-400 font-medium bg-white/80 px-2 py-1 rounded-md">0
                        / 10000 words</span>
                </div>

                <!-- File Attachment -->
                <div class="relative">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Attachment <span
                            class="text-gray-400 font-normal">(Optional)</span></label>
                    <label
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all duration-200 group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-3 text-gray-400 group-hover:text-teal-500 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold" id="fileName">Click to attach
                                    file</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG or PDF (MAX. 10MB)</p>
                        </div>
                        <input type="file" name="attachment" id="fileInput" class="hidden" />
                    </label>
                    <button type="button" id="removeFileBtn" class="hidden text-red-500 text-sm mt-2 hover:underline">Remove
                        selected file</button>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <button type="button"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-teal-600 focus:z-10 focus:ring-2 focus:ring-teal-500 transition-all duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-teal-600 rounded-lg hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                        Submit Incident
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // 1. Data passed from Laravel
            const categoriesData = @json($categories);

            // Elements
            const categoryLabel = document.getElementById('categoryLabel');
            const inputCategoryId = document.getElementById('input_category_id');
            const categoryDropdown = document.getElementById('categoryDropdown');
            const subCategoryBtn = document.getElementById('subCategoryDropdownButton');
            const subCategoryLabel = document.getElementById('subCategoryLabel');
            const subCategoryList = document.getElementById('subCategoryList');
            const subCategoryDropdown = document.getElementById('subCategoryDropdown');
            const inputSubCategoryId = document.getElementById('input_sub_category_id');

            // --- GENERIC DROPDOWN TOGGLER ---
            const setupDropdownToggle = (btnId, menuId) => {
                const btn = document.getElementById(btnId);
                const menu = document.getElementById(menuId);
                if (!btn || !menu) return;

                btn.addEventListener('click', (e) => {
                    e.stopPropagation(); // Prevent immediate closing
                    // Close all other open dropdowns first (optional)
                    document.querySelectorAll('[id$="Dropdown"]').forEach(d => {
                        if (d.id !== menuId) d.classList.add('hidden');
                    });

                    if (!btn.disabled) menu.classList.toggle('hidden');
                });

                // Close when clicking outside
                document.addEventListener('click', (e) => {
                    if (!btn.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            };

            // Initialize all toggles
            setupDropdownToggle('categoryDropdownButton', 'categoryDropdown');
            setupDropdownToggle('subCategoryDropdownButton', 'subCategoryDropdown');
            setupDropdownToggle('impactDropdownButton', 'impactDropdown');
            setupDropdownToggle('urgencyDropdownButton', 'urgencyDropdown');
            setupDropdownToggle('statusDropdownButton', 'statusDropdown');
            setupDropdownToggle('typeDropdownButton', 'typeDropdown');

            // --- CATEGORY SELECTION LOGIC ---
            document.querySelectorAll('.category-option').forEach(option => {
                option.addEventListener('click', function () {
                    const selectedId = this.getAttribute('data-id');
                    const selectedName = this.getAttribute('data-name');

                    // Update UI
                    categoryLabel.textContent = selectedName;
                    inputCategoryId.value = selectedId;
                    categoryDropdown.classList.add('hidden'); // Close menu

                    // Reset Sub-category
                    subCategoryLabel.textContent = 'Select sub-category';
                    inputSubCategoryId.value = '';

                    // Populate Sub-categories
                    updateSubCategories(selectedId);
                });
            });

            function updateSubCategories(categoryId) {
                // Find category in JSON (compare as strings just in case)
                const category = categoriesData.find(c => (c.categoryID || c.id) == categoryId);
                subCategoryList.innerHTML = ''; // Clear old list

                if (category && category.sub_categories && category.sub_categories.length > 0) {
                    // Enable Button
                    subCategoryBtn.disabled = false;
                    subCategoryBtn.classList.remove('cursor-not-allowed', 'opacity-60', 'bg-gray-50');
                    subCategoryBtn.classList.add('bg-white');

                    // Add Options
                    category.sub_categories.forEach(sub => {
                        const li = document.createElement('li');
                        li.innerHTML = `
                                                                                                                                                            <button type="button" 
                                                                                                                                                                class="block w-full px-4 py-2 text-left hover:bg-gray-100 sub-category-option" 
                                                                                                                                                                data-id="${sub.subCategoryID || sub.id}"
                                                                                                                                                                data-name="${sub.name}">
                                                                                                                                                                ${sub.name}
                                                                                                                                                            </button>
                                                                                                                                                        `;
                        subCategoryList.appendChild(li);
                    });

                    // Attach listeners to new sub-cat buttons
                    attachSubCategoryListeners();
                } else {
                    // Disable Button
                    subCategoryBtn.disabled = true;
                    subCategoryBtn.classList.add('cursor-not-allowed', 'opacity-60', 'bg-gray-50');
                    subCategoryBtn.classList.remove('bg-white');
                    subCategoryLabel.textContent = 'No sub-categories';
                }
            }

            function attachSubCategoryListeners() {
                document.querySelectorAll('.sub-category-option').forEach(option => {
                    option.addEventListener('click', function () {
                        subCategoryLabel.textContent = this.getAttribute('data-name');
                        inputSubCategoryId.value = this.getAttribute('data-id');
                        subCategoryDropdown.classList.add('hidden');
                    });
                });
            }

            // --- PRIORITY CALCULATION LOGIC ---
            const impactInput = document.getElementById('input_impact');
            const urgencyInput = document.getElementById('input_urgency');
            const priorityInput = document.getElementById('input_priority');
            const calculatedDisplay = document.getElementById('calculatedPriority');

            const matrixValues = { 'High': 1, 'Medium': 2, 'Low': 3 };

            function calculatePriority() {
                const impactTxt = impactInput.value;
                const urgencyTxt = urgencyInput.value;

                if (impactTxt && urgencyTxt) {
                    const score = matrixValues[impactTxt] + matrixValues[urgencyTxt];
                    let priorityResult = '';

                    if (score === 2) priorityResult = 'Critical';
                    else if (score === 3) priorityResult = 'High';
                    else if (score === 4) priorityResult = 'Moderate';
                    else if (score === 5) priorityResult = 'Low';
                    else if (score === 6) priorityResult = 'Planning';

                    priorityInput.value = priorityResult;
                    calculatedDisplay.value = priorityResult;
                }
            }

            // Impact Listeners
            document.querySelectorAll('.impact-option').forEach(opt => {
                opt.addEventListener('click', function () {
                    document.getElementById('impactLabel').textContent = this.textContent;
                    impactInput.value = this.getAttribute('data-value');
                    document.getElementById('impactDropdown').classList.add('hidden');
                    calculatePriority();
                });
            });

            // Urgency Listeners
            document.querySelectorAll('.urgency-option').forEach(opt => {
                opt.addEventListener('click', function () {
                    document.getElementById('urgencyLabel').textContent = this.textContent;
                    urgencyInput.value = this.getAttribute('data-value');
                    document.getElementById('urgencyDropdown').classList.add('hidden');
                    calculatePriority();
                });
            });

            // Status Listeners
            document.querySelectorAll('.status-option').forEach(opt => {
                opt.addEventListener('click', function () {
                    document.getElementById('statusLabel').textContent = this.textContent;
                    document.getElementById('input_status').value = this.getAttribute('data-value');
                    document.getElementById('statusDropdown').classList.add('hidden');
                });
            });

            // Type Listeners
            document.querySelectorAll('.type-option').forEach(opt => {
                opt.addEventListener('click', function () {
                    document.getElementById('typeLabel').textContent = this.textContent;
                    document.getElementById('input_type').value = this.getAttribute('data-value');
                    document.getElementById('typeDropdown').classList.add('hidden');
                });
            });

        });

        document.addEventListener('DOMContentLoaded', function () {
            const summaryInput = document.getElementById('summaryInput');
            const suggestionsDiv = document.getElementById('summarySuggestions');

            // Summary templates passed from backend
            const templates = @json($summaryTemplates);

            summaryInput.addEventListener('input', function () {
                const query = this.value.toUpperCase(); // Convert to uppercase for matching
                suggestionsDiv.innerHTML = '';

                if (query.length === 0) {
                    suggestionsDiv.classList.add('hidden');
                    return;
                }

                // Filter templates by system code
                const matches = templates.filter(t => t.system_code.includes(query));

                if (matches.length === 0) {
                    suggestionsDiv.classList.add('hidden');
                    return;
                }

                matches.forEach(t => {
                    const div = document.createElement('div');
                    div.classList.add('px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
                    div.textContent = `${t.system_code} - ${t.operation_type} - ${t.user_type}`;
                    div.dataset.systemCode = t.system_code;
                    div.dataset.operationType = t.operation_type;
                    div.dataset.userType = t.user_type;

                    div.addEventListener('click', function () {
                        summaryInput.value = `${this.dataset.systemCode} - ${this.dataset.operationType} - ${this.dataset.userType}`;
                        suggestionsDiv.classList.add('hidden');

                        // Map System Code to Category Name
                        const templateCategoryMap = {
                            'FIN': 'Incident – ERP Finance',
                            'HR': 'Incident – ERP Human Resource (HR)',
                            'PROC': 'Incident – ERP Procurement',
                            'SUPP': 'Incident – ERP Supply Chain',
                            'IT': 'IT Infrastructure'
                        };

                        const code = this.dataset.systemCode;
                        if (templateCategoryMap[code]) {
                            const targetName = templateCategoryMap[code];
                            // Find matching category option
                            const option = Array.from(document.querySelectorAll('.category-option'))
                                .find(opt => opt.getAttribute('data-name') === targetName);

                            if (option) {
                                option.click(); // Trigger click to set value and load sub-categories
                            }
                        }
                    });

                    suggestionsDiv.appendChild(div);
                });

                suggestionsDiv.classList.remove('hidden');
            });

            // Close suggestion list if clicked outside
            document.addEventListener('click', function (e) {
                if (!summaryInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                    suggestionsDiv.classList.add('hidden');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const descInput = document.getElementById('descriptionInput');
            const wordCountDisplay = document.getElementById('wordCountDisplay');
            const MAX_WORDS = 10000;

            function updateWordCount() {
                const value = descInput.value.trim();
                // Split by whitespace and filter empty strings
                const words = value ? value.split(/\s+/).filter(w => w.length > 0) : [];
                const count = words.length;

                wordCountDisplay.textContent = `${count} / ${MAX_WORDS} words`;

                if (count > MAX_WORDS) {
                    wordCountDisplay.classList.add('text-red-500');
                    wordCountDisplay.classList.remove('text-gray-500');
                    // Optional: Prevent further input or trim?
                    // For now, just warning.
                } else {
                    wordCountDisplay.classList.remove('text-red-500');
                    wordCountDisplay.classList.add('text-gray-500');
                }
            }

            descInput.addEventListener('input', updateWordCount);
        });

        const fileInput = document.getElementById('fileInput');
        const fileNameDisplay = document.getElementById('fileName');
        const removeFileBtn = document.getElementById('removeFileBtn');

        fileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                fileNameDisplay.textContent = this.files[0].name;
                removeFileBtn.classList.remove('hidden');
            } else {
                resetFile();
            }
        });

        removeFileBtn.addEventListener('click', function () {
            resetFile();
        });

        function resetFile() {
            fileInput.value = '';
            fileNameDisplay.textContent = '📎 Attach Files';
            removeFileBtn.classList.add('hidden');
        }
    </script>
@endsection