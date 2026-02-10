@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:flex-row lg:h-[calc(100vh-80px)] lg:overflow-hidden mt-20">

        <!-- MAIN CONTENT (LEFT SIDE — 3/4) -->
        <main class="w-full lg:w-3/4 p-4 sm:p-6 lg:h-full overflow-y-auto">

            <!-- PROFILE HEADER -->
            <div class="bg-white p-6 rounded-lg shadow border"
                x-data="{ showEditModal: false, showZoomModal: false, photoPreview: null, imgLoadError: false }">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-xl font-semibold">Profile</h1>
                    <button type="button" @click="showEditModal = true"
                        class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700 transition">
                        Edit Profile
                    </button>

                    <!-- EDIT MODAL -->
                    <div x-show="showEditModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                        style="display: none;" x-transition>
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6" @click.away="showEditModal = false">
                            <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Profile</h2>
                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" name="name" value="{{ $user->name }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                                        <input type="email" name="email" value="{{ $user->email }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                        <input type="text" name="phone" value="{{ $user->user_phone }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Profile Picture</label>

                                        <!-- Current / Preview Image -->
                                        <div class="mt-2 mb-3 flex items-center justify-center">
                                            <!-- Current Image -->
                                            <div x-show="!photoPreview"
                                                class="w-24 h-24 rounded-full overflow-hidden border bg-gray-100 flex items-center justify-center relative">
                                                @if($user->profile_picture)
                                                    <img src="{{ Storage::url($user->profile_picture) }}" alt="Current Profile"
                                                        class="w-full h-full object-cover" x-show="!imgLoadError"
                                                        x-on:error="imgLoadError = true">
                                                    <div x-show="imgLoadError"
                                                        class="absolute inset-0 flex items-center justify-center bg-gray-100">
                                                        <span class="text-4xl text-gray-400">👤</span>
                                                    </div>
                                                @else
                                                    <span class="text-4xl text-gray-400">👤</span>
                                                @endif
                                            </div>
                                            <!-- Preview Image -->
                                            <div x-show="photoPreview" style="display: none;"
                                                class="w-24 h-24 rounded-full overflow-hidden border bg-gray-100 bg-cover bg-center"
                                                :style="'background-image: url(\'' + photoPreview + '\');'">
                                            </div>
                                        </div>

                                        <input type="file" name="profile_picture" accept="image/*" @change="
                                                                                        const file = $event.target.files[0];
                                                                                        const reader = new FileReader();
                                                                                        reader.onload = (e) => { photoPreview = e.target.result };
                                                                                        reader.readAsDataURL(file);
                                                                                    "
                                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                                    </div>
                                </div>
                                <div class="flex justify-end gap-3 mt-6">
                                    <button type="button" @click="showEditModal = false"
                                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded hover:bg-gray-200 text-sm font-medium transition">Cancel</button>
                                    <button type="submit"
                                        class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 text-sm font-medium transition">Save
                                        Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 overflow-hidden relative cursor-pointer hover:opacity-90 transition"
                        @click="showZoomModal = true">
                        @if ($user->profile_picture)
                            <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile"
                                class="w-full h-full object-cover" x-show="!imgLoadError" x-on:error="imgLoadError = true">
                            <div x-show="imgLoadError" class="absolute inset-0 flex items-center justify-center bg-gray-200">
                                <span class="text-3xl">👤</span>
                            </div>
                        @else
                            <span class="text-3xl">👤</span>
                        @endif
                    </div>

                    <div>
                        <h2 class="text-lg font-medium">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-600">{{ $user->role->name ?? 'User' }} @if($user->department)
                        ({{ $user->department->name }}) @endif</p>
                    </div>
                </div>

                <!-- INFO GRID -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 text-sm">
                    <div>
                        <p class="text-gray-500">Company</p>
                        <p class="font-medium">
                            {{ optional($user->department)->name === 'External Client' ? 'External' : 'Salihin' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Organization/Department</p>
                        <p class="font-medium">{{ $user->department->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium text-blue-600">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Phone</p>
                        <p class="font-medium">{{ $user->user_phone ?? 'N/A' }}</p>
                    </div>


                </div>
                <!-- PROFLIE PICTURE ZOOM MODAL -->
                <div x-show="showZoomModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80 backdrop-blur-sm"
                    style="display: none;" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95" @click.away="showZoomModal = false">
                    <div class="relative max-w-3xl max-h-[90vh] p-2" @click.away="showZoomModal = false">
                        <button @click="showZoomModal = false"
                            class="absolute -top-10 right-0 text-white hover:text-gray-300 focus:outline-none">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        @if ($user->profile_picture)
                            <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile Full Size"
                                class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain">
                        @else
                            <div class="w-64 h-64 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                                <span class="text-6xl">👤</span>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- TABS & CONTENT -->
            <div x-data="{ activeTab: 'tickets' }">
                <!-- TABS HEADER -->
                @php
                    $isStaff = auth()->user()->role->name === 'IT Staff' || auth()->user()->role->name === 'System Administrator';
                @endphp
                <div class="bg-white p-4 rounded-lg shadow border mt-6">
                    <div class="grid {{ $isStaff ? 'grid-cols-2' : 'grid-cols-1' }} border-b w-full">
                        <!-- TICKETS TAB -->
                        <button @click="activeTab = 'tickets'"
                            :class="activeTab === 'tickets' ? 'border-orange-500 text-orange-600' : 'text-gray-500 hover:text-gray-700 border-transparent'"
                            class="w-full text-center px-4 py-2 text-sm font-medium border-b-2 transition-colors duration-200">
                            Tickets
                            <span
                                class="ml-1 bg-orange-500 text-white px-2 py-1 rounded text-xs">{{ $tickets->total() }}</span>
                        </button>

                        <!-- SUPPORT GROUPS TAB -->
                        @if($isStaff)
                            <button @click="activeTab = 'groups'"
                                :class="activeTab === 'groups' ? 'border-orange-500 text-orange-600' : 'text-gray-500 hover:text-gray-700 border-transparent'"
                                class="w-full text-center px-4 py-2 text-sm font-medium border-b-2 transition-colors duration-200">
                                Support Groups
                                <span class="ml-1 bg-gray-300 px-2 py-1 rounded text-xs">1</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- TICKETS CONTENT -->
                <div x-show="activeTab === 'tickets'">
                    <div class="bg-white border rounded-lg shadow p-4 mt-4">
                        <p class="text-xs text-gray-500 mb-3">
                            Records from {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }} of
                            {{ $tickets->total() }}
                        </p>

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
                                    @forelse ($tickets as $ticket)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-2 text-blue-600">
                                                <a href="{{ route('user.ticket.details', $ticket->ticketID) }}"
                                                    class="hover:underline">
                                                    {{ $ticket->ticket_number ?? 'ID-' . $ticket->ticketID }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-2">{{ $ticket->type ?? $ticket->request_type ?? 'N/A' }}</td>
                                            <td class="px-4 py-2">{{ Str::limit($ticket->summary, 30) }}</td>
                                            <td class="px-4 py-2">
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold
                                                                                                                                                                                {{ $ticket->status === 'Open' ? 'bg-green-100 text-green-800' : '' }}
                                                                                                                                                                                {{ $ticket->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                                                                                                                                                                {{ $ticket->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                                                                                                                                                {{ $ticket->status === 'Resolved' ? 'bg-gray-100 text-gray-800' : '' }}
                                                                                                                                                                                {{ $ticket->status === 'Closed' ? 'bg-gray-200 text-gray-800' : '' }}">
                                                    {{ $ticket->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2">{{ $ticket->assignee->name ?? '-' }}</td>
                                            <td class="px-4 py-2">{{ $ticket->created_at->format('m/d/Y h:i A') }}</td>
                                            <td class="px-4 py-2">{{ $ticket->updated_at->format('m/d/Y h:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                                No tickets found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $tickets->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUPPORT GROUPS CONTENT -->
                <div x-show="activeTab === 'groups'" style="display: none;">
                    <div class="bg-white border rounded-lg shadow p-4 mt-4">
                        <p class="text-sm font-medium text-gray-700">Salihin Digital Consultancy</p>
                    </div>
                </div>
            </div>

            <!-- SERVICE RATING SECTION -->
            <div class="bg-white border rounded-lg shadow p-4 mt-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <span>⭐</span> Service Ratings & Feedback
                </h3>

                <!-- Rating Form -->
                @if(auth()->user()->role->name !== 'IT Staff' && auth()->user()->role->name !== 'System Administrator')
                    <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Rate an Admin/Agent service</h4>
                        <form action="{{ route('user.profile.rating.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Select Admin/Agent</label>
                                    <select name="admin_id"
                                        class="w-full text-sm border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                        required>
                                        <option value="">-- Select Admin --</option>
                                        @foreach($itStaff as $staff)
                                            <option value="{{ $staff->userID }}">{{ $staff->name }}
                                                ({{ $staff->role->name ?? 'Staff' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Rating</label>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="rating-stars flex flex-row-reverse justify-end">
                                            <input type="radio" id="star5" name="rating" value="5" class="hidden peer/5"
                                                required />
                                            <label for="star5"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/5:text-yellow-400 hover:text-yellow-400 peer-hover/5:text-yellow-400">★</label>

                                            <input type="radio" id="star4" name="rating" value="4" class="hidden peer/4"
                                                required />
                                            <label for="star4"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/4:text-yellow-400 hover:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400">★</label>

                                            <input type="radio" id="star3" name="rating" value="3" class="hidden peer/3"
                                                required />
                                            <label for="star3"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/3:text-yellow-400 hover:text-yellow-400 peer-hover/3:text-yellow-400 peer-checked/4:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400">★</label>

                                            <input type="radio" id="star2" name="rating" value="2" class="hidden peer/2"
                                                required />
                                            <label for="star2"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/2:text-yellow-400 hover:text-yellow-400 peer-hover/2:text-yellow-400 peer-checked/3:text-yellow-400 peer-hover/3:text-yellow-400 peer-checked/4:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400">★</label>

                                            <input type="radio" id="star1" name="rating" value="1" class="hidden peer/1"
                                                required />
                                            <label for="star1"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/1:text-yellow-400 hover:text-yellow-400 peer-hover/1:text-yellow-400 peer-checked/2:text-yellow-400 peer-hover/2:text-yellow-400 peer-checked/3:text-yellow-400 peer-hover/3:text-yellow-400 peer-checked/4:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400">★</label>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">(Click a star)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Comments</label>
                                <textarea name="comment" rows="3"
                                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                    placeholder="Share your feedback..."></textarea>
                            </div>
                            <button type="submit"
                                class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors">
                                Submit Rating
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Recent Ratitngs List -->
                <h4 class="text-sm font-medium text-gray-700 mb-3">Recent Ratings Given</h4>
                <div class="space-y-4">
                    @forelse($ratingsGiven as $rating)
                        <div class="border-b pb-4 last:border-0 last:pb-0">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold overflow-hidden">
                                        <!-- Initials -->
                                        {{ substr($rating->ratee->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm">{{ $rating->ratee->name }}</p>
                                        <div class="flex text-yellow-400 text-xs">
                                            @for($i = 0; $i < $rating->rating; $i++) ★ @endfor
                                            @for($i = $rating->rating; $i < 5; $i++) <span class="text-gray-300">★</span>
                                            @endfor
                                            <span class="text-gray-400 ml-2">({{ $rating->rating }}.0)</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $rating->created_at->diffForHumans() }}</span>
                            </div>
                            @if($rating->comment)
                                <p class="text-sm text-gray-600 mt-2 ml-13 pl-13">
                                    {{ $rating->comment }}
                                </p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500 text-sm">
                            No ratings given yet.
                        </div>
                    @endforelse
                </div>

                <!-- Ratings Received Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Ratings Received from Others</h4>
                    <div class="space-y-4">
                        @forelse($ratingsReceived as $rating)
                            <div class="border-b pb-4 last:border-0 last:pb-0">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold overflow-hidden">
                                            <!-- Initials -->
                                            {{ substr($rating->rater->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm">{{ $rating->rater->name }}</p>
                                            <div class="flex text-yellow-400 text-xs">
                                                @for($i = 0; $i < $rating->rating; $i++) ★ @endfor
                                                @for($i = $rating->rating; $i < 5; $i++) <span class="text-gray-300">★</span>
                                                @endfor
                                                <span class="text-gray-400 ml-2">({{ $rating->rating }}.0)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $rating->created_at->diffForHumans() }}</span>
                                </div>
                                @if($rating->comment)
                                    <p class="text-sm text-gray-600 mt-2 ml-13 pl-13">
                                        {{ $rating->comment }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500 text-sm">
                                No ratings received yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </main>

        <!-- SIDEBAR (RIGHT SIDE — 1/4) -->
        <aside
            class="w-full lg:w-1/4 bg-white border-t lg:border-t-0 lg:border-l border-gray-200 p-4 lg:h-full overflow-y-auto">
            <h2 class="text-lg font-semibold mb-4">Activity</h2>

            <hr class="my-4">

            <h3 class="text-sm font-medium text-gray-700 mb-2">Records</h3>

            <div class="space-y-3">
                @forelse($activities as $activity)
                    <div class="p-3 bg-gray-50 border rounded-lg">
                        <div class="flex justify-between items-start mb-1">
                            <p class="text-xs text-gray-500">{{ $activity->created_at->format('m/d/Y h:i A') }}</p>
                            @if($activity->ticket)
                                <a href="{{ route('user.ticket.details', $activity->ticketID) }}"
                                    class="text-xs text-blue-600 hover:underline">
                                    #{{ $activity->ticket->ticket_number ?? $activity->ticketID }}
                                </a>
                            @endif
                        </div>
                        <p class="text-sm font-medium text-gray-800">{{ $activity->action }}</p>
                        @if($activity->note)
                            <p class="text-sm text-gray-600 mt-1 italic">"{{ Str::limit($activity->note, 100) }}"</p>
                        @endif
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500 text-sm">
                        No recent activity found.
                    </div>
                @endforelse
            </div>
        </aside>

    </div>
@endsection