@extends('layouts.app')

@section('content')
    <div class="mt-20 px-10 mb-20 max-w-7xl mx-auto">
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

        <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-8">
            <div class="flex items-center gap-2 mb-1">
                <h1 class="text-xl font-semibold">Create Service Request</h1>
            </div>
            <span class="text-sm tracking-wide text-gray-500 mb-8 block">New Service Request</span>

            <form class="space-y-10" action="{{ route('user.ticket.service_request.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Using hidden type or assuming backend handles it based on route or other logic. 
                                             For now reusing the incident route as requested for view duplication. -->
                <input type="hidden" name="category_id" id="input_category_id">
                <input type="hidden" name="sub_category_id" id="input_sub_category_id">
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
                        required placeholder="Enter a Summary Template (eg:FIN)" autocomplete="off" />
                    <div id="summarySuggestions"
                        class="border border-gray-100 rounded-xl bg-white mt-2 hidden max-h-40 overflow-y-auto shadow-xl z-20">
                    </div>
                </div>

                <!-- Classification Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

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

                    <!-- Priority (Manual) -->
                    <div class="relative">
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Priority <span
                                class="text-red-500">*</span></label>
                        <button type="button" id="priorityDropdownButton"
                            class="w-full flex justify-between items-center bg-gray-50 text-gray-900 text-sm rounded-xl px-4 py-3.5 border-transparent hover:bg-white hover:ring-2 hover:ring-gray-200 focus:bg-white focus:ring-2 focus:ring-teal-500 transition-all duration-200">
                            <span id="priorityLabel" class="text-gray-500">Select priority</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="priorityDropdown"
                            class="hidden z-20 w-full bg-white rounded-xl shadow-xl border border-gray-100 absolute mt-2">
                            <ul class="py-2 text-sm text-gray-700">
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 priority-option transition-colors"
                                        data-value="High">High</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 priority-option transition-colors"
                                        data-value="Medium">Medium</button></li>
                                <li><button type="button"
                                        class="block w-full text-left px-5 py-3 hover:bg-teal-50 hover:text-teal-700 priority-option transition-colors"
                                        data-value="Low">Low</button></li>
                            </ul>
                        </div>
                    </div>

                </div>



                <!-- Description -->
                <div class="relative">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Description</label>
                    <textarea id="descriptionInput" name="description" rows="6"
                        class="w-full bg-gray-50 text-gray-900 text-sm rounded-xl border-transparent focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-200 block w-full p-4 transition-all duration-200 placeholder-gray-400"
                        placeholder="Provide a detailed description of the service request..."></textarea>
                    <span id="wordCountDisplay"
                        class="absolute bottom-3 right-3 text-xs text-gray-400 font-medium bg-white/80 px-2 py-1 rounded-md">0
                        / 10000 words</span>
                </div>

                <!-- File Attachment (Mandatory) -->
                <div class="mt-6">
                    <label class="block mb-2 text-sm font-semibold text-gray-700 flex items-center gap-1">
                        Attachment <span class="text-red-500">*</span>
                        <div class="relative group inline-block">
                            <button type="button" class="text-gray-400 hover:text-teal-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <!-- Tooltip -->
                            <div
                                class="absolute left-full top-1/2 ml-2 -translate-y-1/2 w-64 p-2 bg-gray-800 text-white text-xs rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 font-normal">
                                Service request require approval from requestor manager.
                                <div
                                    class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 w-2 h-2 bg-gray-800 rotate-45">
                                </div>
                            </div>
                        </div>
                    </label>
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
                        <input type="file" name="attachment" id="fileInput" class="hidden" required />
                    </label>
                    <button type="button" id="removeFileBtn" class="hidden text-red-500 text-sm mt-2 hover:underline">Remove
                        selected file</button>
                    <!-- HTML5 required attribute on file input might not work with hidden input perfectly for UI feedback, 
                                                 but standard form submission will catch it if not hidden, or we rely on backend validation.
                                                 Ideally, we should add JS validation for the hidden file input. -->
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <button type="button"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-teal-600 focus:z-10 focus:ring-2 focus:ring-teal-500 transition-all duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-teal-600 rounded-lg hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                        Submit Request
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
            const inputPriority = document.getElementById('input_priority');

            // --- GENERIC DROPDOWN TOGGLER ---
            const setupDropdownToggle = (btnId, menuId) => {
                const btn = document.getElementById(btnId);
                const menu = document.getElementById(menuId);
                if (!btn || !menu) return;

                btn.addEventListener('click', (e) => {
                    e.stopPropagation(); // Prevent immediate closing
                    // Close all other open dropdowns first
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
            setupDropdownToggle('priorityDropdownButton', 'priorityDropdown');

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

            // --- PRIORITY SELECTION LOGIC ---
            document.querySelectorAll('.priority-option').forEach(opt => {
                opt.addEventListener('click', function () {
                    document.getElementById('priorityLabel').textContent = this.textContent;
                    inputPriority.value = this.getAttribute('data-value');
                    document.getElementById('priorityDropdown').classList.add('hidden');
                });
            });

        });

        document.addEventListener('DOMContentLoaded', function () {
            const summaryInput = document.getElementById('summaryInput');
            const suggestionsDiv = document.getElementById('summarySuggestions');
            const templates = @json($summaryTemplates);

            summaryInput.addEventListener('input', function () {
                const query = this.value.toUpperCase();
                suggestionsDiv.innerHTML = '';

                if (query.length === 0) {
                    suggestionsDiv.classList.add('hidden');
                    return;
                }

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
                            'FIN': 'ERP – Finance',
                            'HR': 'ERP – Human Resource (HR)',
                            'PROC': 'ERP – Procurement',
                            'SUPP': 'ERP – Supply Chain'
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
                const words = value ? value.split(/\s+/).filter(w => w.length > 0) : [];
                const count = words.length;

                wordCountDisplay.textContent = `${count} / ${MAX_WORDS} words`;

                if (count > MAX_WORDS) {
                    wordCountDisplay.classList.add('text-red-500');
                    wordCountDisplay.classList.remove('text-gray-500');
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
                // visual feedback for valid file
                this.parentNode.classList.add('border-teal-500', 'bg-teal-50');
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
            fileInput.parentNode.classList.remove('border-teal-500', 'bg-teal-50');
        }
    </script>
@endsection