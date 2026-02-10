@extends('layouts.app')

@section('content')
    <div class="flex h-[calc(100vh-80px)] overflow-hidden mt-20">

        <!-- MAIN CONTENT (LEFT SIDE — 3/4) -->
        <main class="w-3/4 p-6 h-full overflow-y-auto mx-auto">

            <!-- PROFILE HEADER -->
            <div class="bg-white p-6 rounded-lg shadow border">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-xl font-semibold">Public Profile</h1>
                </div>

                <div class="flex items-center gap-6">
                    <div
                        class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 overflow-hidden relative">
                        @if($user->profile_picture)
                            <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile"
                                class="w-full h-full object-cover">
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

                    <div>
                        <p class="text-gray-500">Service Rating</p>
                        <p class="font-medium">
                            @php
                                $avgRating = $user->ratingsReceived()->avg('rating') ?? 0;
                                $ratingCount = $user->ratingsReceived()->count();
                            @endphp
                            @for($i = 0; $i < round($avgRating); $i++)
                                ⭐
                            @endfor
                            ({{ number_format($avgRating, 1) }}) - {{ $ratingCount }} Reviews
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Availability</p>
                        <p class="font-medium">
                            @if($user->is_available)
                                <span class="text-green-600 flex items-center gap-1">
                                    ✅ Available
                                </span>
                            @else
                                <span class="text-red-600 flex items-center gap-1">
                                    🔴 Busy (Assigned)
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- SERVICE RATING SECTION (Only show if viewed user is IT Staff) -->
            @if($user->role->name === 'IT Staff' || $user->role->name === 'System Administrator')
                <div class="bg-white border rounded-lg shadow p-4 mt-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <span>⭐</span> Service Ratings & Feedback
                    </h3>

                    <!-- Rating Form (Only show if Viewer is NOT IT Staff) -->
                    @if(auth()->user()->role->name !== 'IT Staff' && auth()->user()->role->name !== 'System Administrator')
                        <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Rate this Agent</h4>
                            <form action="{{ route('user.profile.rating.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="admin_id" value="{{ $user->userID }}">

                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Rating</label>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="rating-stars flex flex-row-reverse justify-end">
                                            <input type="radio" id="star5" name="rating" value="5" class="hidden peer/5" required />
                                            <label for="star5"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/5:text-yellow-400 hover:text-yellow-400 peer-hover/5:text-yellow-400">★</label>

                                            <input type="radio" id="star4" name="rating" value="4" class="hidden peer/4" required />
                                            <label for="star4"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/4:text-yellow-400 hover:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400">★</label>

                                            <input type="radio" id="star3" name="rating" value="3" class="hidden peer/3" required />
                                            <label for="star3"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/3:text-yellow-400 hover:text-yellow-400 peer-hover/3:text-yellow-400 peer-checked/4:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400">★</label>

                                            <input type="radio" id="star2" name="rating" value="2" class="hidden peer/2" required />
                                            <label for="star2"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/2:text-yellow-400 hover:text-yellow-400 peer-hover/2:text-yellow-400 peer-checked/3:text-yellow-400 peer-hover/3:text-yellow-400 peer-checked/4:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400">★</label>

                                            <input type="radio" id="star1" name="rating" value="1" class="hidden peer/1" required />
                                            <label for="star1"
                                                class="text-2xl text-gray-300 cursor-pointer peer-checked/1:text-yellow-400 hover:text-yellow-400 peer-hover/1:text-yellow-400 peer-checked/2:text-yellow-400 peer-hover/2:text-yellow-400 peer-checked/3:text-yellow-400 peer-hover/3:text-yellow-400 peer-checked/4:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400">★</label>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">(Click a star)</span>
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

                    <!-- Recent Ratings Received -->
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Reviews Received</h4>
                    <div class="space-y-4">
                        @forelse($ratingsReceived as $rating)
                            <div class="border-b pb-4 last:border-0 last:pb-0">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold overflow-hidden">
                                            <!-- Initials -->
                                            {{ substr($rating->rater->name ?? 'User', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm">{{ $rating->rater->name ?? 'Unknown User' }}</p>
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
            @endif

        </main>
    </div>
@endsection