 <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-teal-500 border-b border-teal-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-3">

            <!-- Logo -->
            <a href="#" class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="self-center text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    MyTicket+
                </span>
            </a>

            <!-- Mobile Menu Button -->
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-900 rounded-lg md:hidden hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-300 dark:hover:bg-teal-700"
                aria-controls="navbar-default" aria-expanded="false">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <!-- Nav Links -->
            <div class="hidden w-full md:flex md:w-auto md:items-center" id="navbar-default">
                <ul class="flex flex-col md:flex-row md:space-x-8 font-medium text-gray-900 dark:text-white">
                    <li><a href="{{ route('dashboard') }}" class="block py-2 px-3 hover:underline">Dashboard</a></li>
                    <li><a href="#" class="block py-2 px-3 hover:underline">Console</a></li>
                     <!-- More Dropdown -->
                    <li>
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                            class="flex items-center justify-between w-full py-2 px-3 hover:underline md:w-auto">
                            Create New
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdownNavbar"
                            class="z-10 hidden font-medium bg-[#4B4141] text-white rounded-md shadow w-48">
                            <ul class="py-2 text-sm" aria-labelledby="dropdownNavbarLink">

                                <!-- Incident -->
                                <li>
                                    <a href="{{ route('user.ticket.incident.create') }}" 
                                        class="flex items-center gap-2 px-4 py-2 hover:bg-[#5A4D4D] transition-colors duration-150">
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z" />
                                        </svg>
                                        Incident
                                    </a>
                                </li>

                                <!-- Work Order -->
                                <li>
                                    <a href="#"
                                        class="flex items-center gap-2 px-4 py-2 hover:bg-[#5A4D4D] transition-colors duration-150">
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m-6-8h6M4 6h16M4 18h16" />
                                        </svg>
                                        Work Order
                                    </a>
                                </li>

                            </ul>
                        </div>

                    </li>

                    <li><a href="#" class="block py-2 px-3 hover:underline">More</a></li>

                   
                </ul>
            </div>

            <!-- Right Icons -->
            <div class="flex items-center space-x-5 rtl:space-x-reverse">
                <!-- Search Icon -->
                <button type="button" class="text-gray-800 dark:text-white hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z" />
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div class="relative">
                    <button id="userMenuButton" data-dropdown-toggle="userDropdown"
                        class="flex text-sm bg-transparent rounded-full focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
                        type="button">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1118.879 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="userDropdown"
                        class="hidden z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white">Jane Doe</span>
                            <span
                                class="block text-sm text-gray-500 truncate dark:text-gray-400">jane.doe@example.com</span>
                        </div>
                        <ul class="py-2" aria-labelledby="userMenuButton">
                            <li><a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                            </li>
                            <li><a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                            </li>
                            <li>
                                <!-- Logout Form -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.2/flowbite.min.js"></script>