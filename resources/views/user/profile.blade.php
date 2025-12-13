@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen mt-20">

        <!-- MAIN CONTENT (LEFT SIDE — 3/4) -->
        <main class="w-3/4 p-6">

            <!-- PROFILE HEADER -->
            <div class="bg-white p-6 rounded-lg shadow border">
                <h1 class="text-xl font-semibold mb-4">Profile</h1>

                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                        <span class="text-3xl">👤</span>
                    </div>

                    <div>
                        <h2 class="text-lg font-medium">Zahira Ismail (SALIHIN)</h2>
                        <p class="text-sm text-gray-600">Sr Administrator (Master Data Mgt)</p>
                    </div>
                </div>

                <!-- INFO GRID -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 text-sm">
                    <div>
                        <p class="text-gray-500">Company</p>
                        <p class="font-medium">Salihin</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Organization</p>
                        <p class="font-medium">Salihin International Sdn Bhd</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium text-blue-600">zahira.ismail@salihin.com.my</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Enabled</p>
                        <p class="font-medium">Yes</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Alternate ID</p>
                        <p class="font-medium">zahira.ismail</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Corporate ID</p>
                        <p class="font-medium">1332124</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Agent’s Manager</p>
                        <p class="font-medium">Hafizah Bt Samsudin (SALIHIN)</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Available for assignment</p>
                        <p class="font-medium">Yes</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Service Rating</p>
                        <p class="font-medium">⭐⭐⭐⭐⭐ (0)</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Alerts</p>
                        <p class="font-medium">0 Escalations in Last Month</p>
                    </div>
                </div>
            </div>

            <!-- TABS -->
            <div class="bg-white p-4 rounded-lg shadow border mt-6">

                <div class="grid grid-cols-2 border-b w-full">

                    <!-- TICKETS TAB (active) -->
                    <button
                        class="w-full text-center px-4 py-2 text-sm font-medium border-b-2 border-orange-500 text-orange-600">
                        Tickets
                        <span class="ml-1 bg-orange-500 text-white px-2 py-1 rounded text-xs">26</span>
                    </button>

                    <!-- SUPPORT GROUPS TAB -->
                    <button class="w-full text-center px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Support Groups
                        <span class="ml-1 bg-gray-300 px-2 py-1 rounded text-xs">1</span>
                    </button>

                </div>
            </div>

            <!-- FILTER -->
            <div class="flex items-center gap-2 text-sm text-blue-600 cursor-pointer mt-4">
                <span class="text-green-600">🟩</span> Filter
            </div>

            <!-- TABLE -->
            <div class="bg-white border rounded-lg shadow p-4 mt-4">
                <p class="text-xs text-gray-500 mb-3">Records from 1 to 20 of 26</p>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Ticket Type</th>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Assignee</th>
                                <th class="px-4 py-2 text-left">Opened</th>
                                <th class="px-4 py-2 text-left">Modified</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 10; $i++)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2 text-blue-600">REQ000007481029</td>
                                    <td class="px-4 py-2">Service Request</td>
                                    <td class="px-4 py-2">SAP - Escalation</td>
                                    <td class="px-4 py-2">Pending</td>
                                    <td class="px-4 py-2">-</td>
                                    <td class="px-4 py-2">08/15/2025 3:49:41</td>
                                    <td class="px-4 py-2">08/15/2025 3:49:41</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <!-- SIDEBAR (RIGHT SIDE — 1/4) -->
        <aside class="w-1/4 bg-white border-l border-gray-200 p-4 overflow-y-auto">
            <h2 class="text-lg font-semibold mb-4">Activity</h2>

            <form class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Add Note</label>

                <textarea class="w-full h-32 p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"
                    placeholder="Start typing to add a note..."></textarea>

                <button type="submit"
                    class="mt-3 w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">
                    Submit
                </button>
            </form>

            <hr class="my-4">

            <h3 class="text-sm font-medium text-gray-700 mb-2">Records</h3>

            <div class="space-y-3">
                <div class="p-3 bg-gray-50 border rounded-lg">
                    <p class="text-xs text-gray-500">08/15/2025 5:42 PM</p>
                    <p class="text-sm">Assigned to FSD OUTBOUND by IT Team.</p>
                </div>

                <div class="p-3 bg-gray-50 border rounded-lg">
                    <p class="text-xs text-gray-500">08/15/2025 5:41 PM</p>
                    <p class="text-sm">Dear Team, Delete VA has been performed.</p>
                </div>

                <div class="p-3 bg-gray-50 border rounded-lg">
                    <p class="text-xs text-gray-500">08/15/2025 11:57 AM</p>
                    <p class="text-sm">Remedy Application Service added a note.</p>
                </div>
            </div>
        </aside>

    </div>
@endsection
