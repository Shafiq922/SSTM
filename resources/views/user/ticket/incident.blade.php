@extends('layouts.app')

@section('content')
    <div class="mt-20 px-10 mb-20" class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-semibold">Create Incident</h1>
            <span class="text-sm tracking-wide text-gray-900">ICT_INC2123352</span>
        </div>

        <!-- Form -->
        <form class="space-y-10">

            <!-- Row: Summary -->
            <div>
                <label class="block mb-1 font-medium">Summary <span class="text-red-600 text-xs">(required)</span></label>
                <input type="text" class="w-full border border-gray-300 rounded-lg p-2.5" />
            </div>

            <!-- Row: Category / Sub-category -->
            <div class="grid grid-cols-3 gap-6">

                <!-- Category -->
                <div class="relative">
                    <label class="block mb-1 font-medium">
                        Category <span class="text-red-600 text-xs">(required)</span>
                    </label>
                    <button type="button" id="categoryDropdownButton" data-dropdown-toggle="categoryDropdown"
                        class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                        <span>Select category</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="categoryDropdown" class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200">
                        <ul class="py-2 text-sm">
                            <li><button type="button"
                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100">Hardware</button></li>
                            <li><button type="button"
                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100">Software</button></li>
                            <li><button type="button"
                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100">Network</button></li>
                        </ul>
                    </div>
                </div>

                <!-- Sub-category -->
                <div class="relative">
                    <label class="block mb-1 font-medium">
                        Sub-category <span class="text-red-600 text-xs">(required)</span>
                    </label>
                    <button type="button" id="subCategoryDropdownButton" data-dropdown-toggle="subCategoryDropdown"
                        class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                        <span class="text-sm">Select sub-category</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="subCategoryDropdown"
                        class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200">
                        <ul class="py-2 text-sm">
                            <li><button type="button"
                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100">Laptop</button></li>
                            <li><button type="button"
                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100">Desktop</button></li>
                            <li><button type="button"
                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100">Printer</button></li>
                        </ul>
                    </div>
                </div>

            </div>


            <!-- Row: Impact / Urgency / Calculated Priority -->
            <div class="grid grid-cols-3 gap-6">

                <div class="relative">
                    <label class="block mb-1 font-medium">Impact <span
                            class="text-red-600 text-xs">(required)</span></label>
                    <button type="button" id="impactDropdownButton" data-dropdown-toggle="impactDropdown"
                        class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                        <span></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="impactDropdown" class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200">
                        <ul class="py-2 text-sm">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">High</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Medium</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Low</a></li>
                        </ul>
                    </div>
                </div>

                <div class="relative">
                    <label class="block mb-1 font-medium">Urgency <span
                            class="text-red-600 text-xs">(required)</span></label>
                    <button type="button" id="urgencyDropdownButton" data-dropdown-toggle="urgencyDropdown"
                        class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                        <span></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="urgencyDropdown" class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200">
                        <ul class="py-2 text-sm">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">High</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Medium</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Low</a></li>
                        </ul>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Calculated priority</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg p-2.5" disabled />
                </div>
            </div>


            <!-- Row: Status -->
            <div class="w-1/3 relative">
                <label class="block mb-1 font-medium">Status <span class="text-red-600 text-xs">(required)</span></label>
                <button type="button" id="statusDropdownButton" data-dropdown-toggle="statusDropdown"
                    class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                    <span></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="statusDropdown" class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200">
                    <ul class="py-2 text-sm">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Open</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Closed</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Pending</a></li>
                    </ul>
                </div>
            </div>

            <!-- Row: Customer -->
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block mb-1 font-medium">Customer <span
                            class="text-red-600 text-xs">(required)</span></label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg p-2.5" />
                </div>

                <div class="flex gap-4">
                    <div class="w-full">
                        <label class="block mb-1 font-medium">Customer phone</label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg p-2.5" />
                    </div>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Customer email</label>
                    <input type="email" class="w-full border border-gray-300 rounded-lg p-2.5" />
                </div>
            </div>

            <!-- Row: Incident Type -->
            <div class="w-1/3 relative">
                <label class="block mb-1 font-medium">Incident Type
                    <span class="text-red-600 text-xs">(required)</span>
                </label>
                <!--Trigger-->
                <button type="button" id="typeDropdownButton" data-dropdown-toggle="typeDropdown"
                    class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                    <span></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="typeDropdown"
                    class="hidden z-10 w-full max-w-full bg-white rounded-lg shadow border border-gray-200">
                    <ul class="py-2 text-sm w-full">
                        <li><button type="button"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">Hardware</button></li>
                        <li><button type="button"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">Software</button></li>
                        <li><button type="button"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">Network</button></li>
                    </ul>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block mb-1 font-medium">Description</label>
                <textarea rows="6" class="w-full border border-gray-300 rounded-lg p-3"></textarea>
            </div>

            <!-- Attach Files -->
            <div>
                <label
                    class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-100">
                    <input type="file" class="hidden" />
                    <span class="text-sm">📎 Attach Files</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 pt-6">
                <button class="px-6 py-2 border border-gray-400 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancel
                </button>
                <button class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                    Save
                </button>
            </div>

        </form>
    </div>
@endsection