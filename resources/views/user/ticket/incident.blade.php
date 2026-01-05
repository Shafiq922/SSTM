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
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-semibold">Create Incident</h1>
            <span class="text-sm tracking-wide text-gray-900">New Ticket</span>
        </div>

        <form class="space-y-10" action="{{ route('user.ticket.incident.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="category_id" id="input_category_id">
            <input type="hidden" name="sub_category_id" id="input_sub_category_id">
            <input type="hidden" name="impact" id="input_impact">
            <input type="hidden" name="urgency" id="input_urgency">
            <input type="hidden" name="priority" id="input_priority">


            <div>
                <label class="block mb-1 font-medium">Summary <span class="text-red-600 text-xs">(required)</span></label>
                <input type="text" id="summaryInput" name="summary" class="w-full border border-gray-300 rounded-lg p-2.5"
                    required placeholder="Type system code (e.g. FIN)" autocomplete="off" />
                <div id="summarySuggestions"
                    class="border border-gray-300 rounded-lg bg-white mt-1 hidden max-h-40 overflow-y-auto"></div>
            </div>

            <div class="grid grid-cols-3 gap-6">

                <div class="relative">
                    <label class="block mb-1 font-medium">Category <span
                            class="text-red-600 text-xs">(required)</span></label>
                    <button type="button" id="categoryDropdownButton"
                        class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                        <span id="categoryLabel" class="text-sm text-gray-700">Select category</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="categoryDropdown"
                        class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200 absolute mt-1">
                        <ul class="py-2 text-sm text-gray-700">
                            @foreach($categories as $category)
                                <li>
                                    <button type="button"
                                        class="block w-full px-4 py-2 text-left hover:bg-gray-100 category-option"
                                        data-id="{{ $category->categoryID ?? $category->id }}"
                                        data-name="{{ $category->name }}">
                                        {{ $category->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="relative">
                    <label class="block mb-1 font-medium">Sub-category <span
                            class="text-red-600 text-xs">(required)</span></label>
                    <button type="button" id="subCategoryDropdownButton" disabled
                        class="w-full flex justify-between items-center border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 cursor-not-allowed opacity-60">
                        <span id="subCategoryLabel" class="text-sm text-gray-700">Select category first</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="subCategoryDropdown"
                        class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200 absolute mt-1">
                        <ul id="subCategoryList" class="py-2 text-sm text-gray-700">
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">

                <div class="relative">
                    <label class="block mb-1 font-medium">Impact <span
                            class="text-red-600 text-xs">(required)</span></label>
                    <button type="button" id="impactDropdownButton"
                        class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                        <span id="impactLabel">Select</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="impactDropdown"
                        class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200 absolute">
                        <ul class="py-2 text-sm">
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 impact-option"
                                    data-value="High">High</button></li>
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 impact-option"
                                    data-value="Medium">Medium</button></li>
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 impact-option"
                                    data-value="Low">Low</button></li>
                        </ul>
                    </div>
                </div>

                <div class="relative">
                    <label class="block mb-1 font-medium">Urgency <span
                            class="text-red-600 text-xs">(required)</span></label>
                    <button type="button" id="urgencyDropdownButton"
                        class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                        <span id="urgencyLabel">Select</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="urgencyDropdown"
                        class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200 absolute">
                        <ul class="py-2 text-sm">
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 urgency-option"
                                    data-value="High">High</button></li>
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 urgency-option"
                                    data-value="Medium">Medium</button></li>
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 urgency-option"
                                    data-value="Low">Low</button></li>
                        </ul>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Calculated priority</label>
                    <input type="text" id="calculatedPriority"
                        class="w-full border border-gray-300 bg-gray-50 rounded-lg p-2.5" disabled />
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div class="relative">
                    <label class="block mb-1 font-medium">Status <span
                            class="text-red-600 text-xs">(required)</span></label>
                    <button type="button" id="statusDropdownButton"
                        class="w-full flex justify-between items-center border border-gray-300 bg-gray-100 rounded-lg px-4 py-2.5">
                        <span id="statusLabel">Open</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="statusDropdown"
                        class="hidden z-10 w-full bg-white rounded-lg shadow border border-gray-200 absolute">
                        <ul class="py-2 text-sm">
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 status-option"
                                    data-value="Open">Open</button></li>
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 status-option"
                                    data-value="Closed">Closed</button></li>
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 status-option"
                                    data-value="In Progress">In Progress</button></li>
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 status-option"
                                    data-value="Pending">Pending</button></li>
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 status-option"
                                    data-value="Resolved">Resolved</button></li>
                            <li><button type="button"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 status-option"
                                    data-value="Cancelled">Cancelled</button></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-3 gap-6 mt-6">
                <div>
                    <label class="block mb-1 font-medium">Customer</label>
                    <input type="text" name="customer_name" value="{{ auth()->user()->name }}" readonly
                        class="w-full border border-gray-300 bg-gray-200 text-gray-500 rounded-lg p-2.5 cursor-not-allowed" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Customer phone</label>
                    <input type="text" name="customer_phone" value="{{ auth()->user()->user_phone }}" readonly
                        class="w-full border border-gray-300 bg-gray-200 text-gray-500 rounded-lg p-2.5 cursor-not-allowed" />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Customer email</label>
                    <input type="email" name="customer_email" value="{{ auth()->user()->email }}" readonly
                        class="w-full border border-gray-300 bg-gray-200 text-gray-500 rounded-lg p-2.5 cursor-not-allowed" />
                </div>
            </div>

            <div class="mt-6 relative">
                <label class="block mb-1 font-medium">Description</label>
                <textarea id="descriptionInput" name="description" rows="6"
                    class="w-full border border-gray-300 rounded-lg p-3 pb-8"></textarea>
                <span id="wordCountDisplay" class="absolute bottom-3 left-3 text-xs text-gray-500">0 / 10000 words</span>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <label
                    class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-100">
                    <input type="file" name="attachment" id="fileInput" class="hidden" />
                    <span class="text-sm" id="fileName">📎 Attach Files</span>
                </label>
                <button type="button" id="removeFileBtn" class="hidden text-gray-500 hover:text-red-500"
                    title="Remove file">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex justify-end gap-4 pt-6">
                <button type="button"
                    class="px-6 py-2 border border-gray-400 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
                <button type="submit"
                    class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Save</button>
            </div>

        </form>
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