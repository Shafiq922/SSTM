@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:flex-row min-h-screen lg:h-screen pt-16 overflow-auto lg:overflow-hidden">
        <!-- LEFT PANEL: Ticket Details (Scrollable) -->
        <div class="w-full lg:w-2/3 lg:h-full overflow-y-auto bg-white custom-scrollbar">
            <form action="{{ route('user.ticket.update', $ticket->ticketID) }}" method="POST" enctype="multipart/form-data"
                onsubmit="return confirm('Are you sure you want to save changes?');">
                @csrf
                @method('PUT')
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500 font-medium">{{ $ticket->ticket_number }}</span>
                                @php
                                    $priorityColors = [
                                        'Critical' => 'text-red-700 bg-red-100',
                                        'High' => 'text-orange-700 bg-orange-100',
                                        'Moderate' => 'text-yellow-700 bg-yellow-100',
                                        'Low' => 'text-green-700 bg-green-100',
                                    ];
                                    $pColor = $priorityColors[$ticket->priority] ?? 'text-gray-700 bg-gray-100';
                                @endphp
                                <span
                                    class="px-2.5 py-0.5 text-xs font-semibold {{ $pColor }} rounded-full">{{ $ticket->priority }}</span>

                                {{-- SLA Info Tooltip --}}
                                <div class="relative group inline-block">
                                    <svg class="w-4 h-4 text-gray-400 cursor-help" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{-- Tooltip Content --}}
                                    <div
                                        class="absolute left-0 top-6 hidden group-hover:block z-50 w-80 bg-white text-gray-800 text-xs rounded-lg shadow-2xl border-2 border-blue-500 p-4">
                                        <div class="font-semibold mb-2 text-sm text-blue-600">SLA Response & Resolution
                                            Times</div>
                                        <table class="w-full text-left">
                                            <thead>
                                                <tr class="border-b border-blue-200">
                                                    <th class="pb-2 font-medium">Priority</th>
                                                    <th class="pb-2 font-medium text-center">Response Time</th>
                                                    <th class="pb-2 font-medium text-center">Resolution Time</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-xs">
                                                <tr class="border-b border-gray-200">
                                                    <td class="py-2">Critical</td>
                                                    <td class="py-2 text-center">30 minutes</td>
                                                    <td class="py-2 text-center">4 hours</td>
                                                </tr>
                                                <tr class="border-b border-gray-200">
                                                    <td class="py-2">High</td>
                                                    <td class="py-2 text-center">1 hour</td>
                                                    <td class="py-2 text-center">8 hours</td>
                                                </tr>
                                                <tr class="border-b border-gray-200">
                                                    <td class="py-2">Moderate</td>
                                                    <td class="py-2 text-center">4 hours</td>
                                                    <td class="py-2 text-center">2 days</td>
                                                </tr>
                                                <tr class="border-b border-gray-200">
                                                    <td class="py-2">Low</td>
                                                    <td class="py-2 text-center">8 hours</td>
                                                    <td class="py-2 text-center">3 days</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2">Planning</td>
                                                    <td class="py-2 text-center">1 day</td>
                                                    <td class="py-2 text-center">5 days</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 transition-colors shadow-sm">
                                Save Changes
                            </button>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $ticket->summary }}</h1>
                    </div>

                    <!-- Meta Info -->
                    <div class="grid grid-cols-2 gap-x-12 gap-y-4 mb-6 text-sm items-center">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Created</span>
                            <span
                                class="text-gray-900 font-medium">{{ $ticket->created_at->format('m/d/Y h:i:s A') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status:</span>
                            <span class="text-gray-900 font-medium">{{ $ticket->status }}</span>
                        </div>

                        <!-- SLA Response -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Response Due</span>
                            @if($ticket->response_due)
                                @php
                                    $isResponseOverdue = $ticket->response_due->isPast();
                                    $responseColor = $isResponseOverdue ? 'text-red-600 font-bold' : ($ticket->response_due->diffInHours(now()) < 1 ? 'text-orange-600 font-semibold' : 'text-green-600');
                                @endphp
                                <span class="{{ $responseColor }}">
                                    {{ $ticket->response_due->diffForHumans() }}
                                    @if($isResponseOverdue) (Overdue) @endif
                                </span>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </div>

                        <!-- SLA Resolution -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Resolution Due</span>
                            @if($ticket->resolution_due)
                                @php
                                    $isResolutionOverdue = $ticket->resolution_due->isPast();
                                    $isResolved = in_array($ticket->status, ['Resolved', 'Closed', 'Cancelled']);
                                @endphp

                                @if($isResolved)
                                    <span class="text-gray-500">Completed</span>
                                @else
                                    @php
                                        $resolutionColor = $isResolutionOverdue ? 'text-red-600 font-bold' : ($ticket->resolution_due->diffInHours(now()) < 4 ? 'text-orange-600 font-semibold' : 'text-green-600');
                                    @endphp
                                    <span class="{{ $resolutionColor }}">
                                        {{ $ticket->resolution_due->diffForHumans() }}
                                        @if($isResolutionOverdue) (Overdue) @endif
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Updated</span>
                            <span
                                class="text-gray-900 font-medium">{{ $ticket->updated_at->format('m/d/Y h:i:s A') }}</span>
                        </div>
                    </div>

                    <!-- Progress Bar (SLA-Based) -->
                    @php
                        // Determine which SLA phase we're tracking
                        $isResponsePhase = $ticket->status === 'Open';

                        if ($isResponsePhase) {
                            // Track Response Time (Open status)
                            $startTime = $ticket->created_at;
                            $dueTime = $ticket->response_due;
                            $totalMinutes = $ticket->sla->response_time_minutes ?? 1;
                        } else {
                            // Track Resolution Time (In Progress and beyond)
                            $startTime = $ticket->created_at;
                            $dueTime = $ticket->resolution_due;
                            $totalMinutes = $ticket->sla->resolution_time_minutes ?? 1;
                        }

                        // Calculate elapsed time and progress percentage
                        if ($dueTime && $totalMinutes > 0) {
                            $elapsedMinutes = $startTime->diffInMinutes(now());
                            $progressPercentage = min(100, ($elapsedMinutes / $totalMinutes) * 100);
                            $progressWidth = round($progressPercentage) . '%';
                        } else {
                            $progressWidth = '0%';
                        }

                        // Color logic updated for Breached status
                        $progressColor = match ($ticket->status) {
                            'Resolved', 'Closed' => 'bg-green-500',
                            'Cancelled', 'Breached' => 'bg-red-500',
                            'In Progress', 'Pending' => 'bg-orange-500',
                            default => 'bg-blue-500'
                        };
                    @endphp
                    <div class="relative w-full h-2 bg-gray-200 rounded-full mb-6">
                        <div class="absolute top-0 left-0 h-2 bg-gray-900 rounded-full"
                            style="width: {{ $progressWidth }};">
                        </div>
                        <div class="absolute top-1/2 -translate-y-1/2 w-4 h-4 {{ $progressColor }} border-2 border-white rounded-full shadow"
                            style="left: {{ $progressWidth }};"></div>
                    </div>

                    <!-- Category Info -->
                    <div class="mb-8 text-sm text-gray-700 border-b pb-8">
                        Product Category: {{ $ticket->category->name ?? 'N/A' }}
                        @if ($ticket->subCategory)
                            - {{ $ticket->subCategory->name }}
                        @endif
                    </div>

                    <!-- Contacts -->
                    <div class="space-y-6 mb-8 border-b pb-8">
                        <!-- Customer -->
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('user.profile.view', $ticket->user->userID) }}">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center text-white text-xs font-bold hover:ring-2 hover:ring-offset-2 hover:ring-teal-500 transition-all cursor-pointer">
                                        {{ substr($ticket->user->name ?? 'U', 0, 1) }}
                                    </div>
                                </a>
                                <div>
                                    <div class="text-xs text-gray-500">Customer</div>
                                    <a href="{{ route('user.profile.view', $ticket->user->userID) }}"
                                        class="text-sm font-semibold text-gray-900 hover:text-teal-600 transition-colors">
                                        {{ $ticket->user->name ?? 'Unknown' }}
                                    </a>
                                </div>
                            </div>
                            <a href="mailto:{{ $ticket->user->email ?? '#' }}"
                                class="flex items-center text-teal-600 text-sm hover:underline">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $ticket->user->email ?? 'N/A' }}
                            </a>
                        </div>

                        <!-- Contact (Assignee) -->
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr($ticket->assignee->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Contact</div>
                                    <div class="text-sm font-semibold text-gray-900">
                                        @if($ticket->assignee)
                                            <a href="{{ route('user.profile.view', $ticket->assignee->userID) }}"
                                                class="hover:text-teal-600 transition-colors">
                                                {{ $ticket->assignee->name }}
                                            </a>
                                        @else
                                            Unassigned
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($ticket->assignee)
                                <a href="mailto:{{ $ticket->assignee->email }}"
                                    class="flex items-center text-teal-600 text-sm hover:underline">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $ticket->assignee->email }}
                                </a>
                            @else
                                <span class="text-gray-400 text-sm italic">No contact info</span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-semibold text-gray-900">Description</h3>
                        </div>
                        <textarea name="description" rows="5"
                            class="w-full bg-gray-50 rounded-lg p-4 border border-gray-200 text-sm focus:ring-teal-500 focus:border-teal-500">{{ $ticket->description }}</textarea>
                    </div>

                    <!-- Attachments -->
                    <div class="mb-4 border-b pb-8">
                        <h3 class="font-semibold text-gray-900 mb-4">Attachment</h3>
                        <div class="space-y-2 mb-4">
                            @forelse($ticket->attachments as $attachment)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    <a href="{{ Storage::url($attachment->file_path) }}" target="_blank"
                                        class="text-teal-600 hover:underline text-sm mr-2">
                                        {{ basename($attachment->file_path) }}
                                    </a>
                                    <button type="submit" form="delete-attachment-{{ $attachment->attachmentID }}"
                                        class="text-gray-400 hover:text-red-600 transition-colors" title="Delete Attachment">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <span class="text-gray-500 text-sm italic">No attachments</span>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Add New Attachment</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                id="attachment" name="attachment" type="file">
                        </div>
                    </div>

                    <!-- Assignments (Read Only) -->
                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <!-- Assigned To -->
                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-400 flex flex-shrink-0 items-center justify-center text-white text-sm font-bold">
                                A</div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">Assigned to</h3>
                                <div class="text-xs text-gray-500 mb-0.5">Assignee Group</div>
                                <div class="text-sm font-bold text-gray-900">SALIHIN Digital Consultancy</div>
                            </div>
                        </div>

                        <!-- Request Manager (Assignee) -->
                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-400 flex flex-shrink-0 items-center justify-center text-white text-sm font-bold">
                                {{ substr($ticket->assignee->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">Assigned to</h3>
                                <div class="text-xs text-gray-500 mb-0.5">Assignee</div>
                                <div class="text-sm font-bold text-gray-900">
                                    @if($ticket->assignee)
                                        {{ $ticket->assignee->name }}
                                    @else
                                        Unassigned
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filler Content to enable scrolling -->
                    <div class="h-32"></div>
                </div>
            </form>

            <!-- Hidden Delete Forms for Attachments -->
            @foreach($ticket->attachments as $attachment)
                <form id="delete-attachment-{{ $attachment->attachmentID }}"
                    action="{{ route('user.ticket.attachment.delete', $attachment->attachmentID) }}" method="POST"
                    style="display: none;" onsubmit="return confirm('Are you sure you want to delete this attachment?');">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>

        <!-- RIGHT PANEL: Activity (Fixed Container, Internal Scroll) -->
        <div class="w-full lg:w-1/3 lg:h-full flex flex-col border-t lg:border-t-0 lg:border-l border-gray-200 bg-gray-50">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 bg-white">
                <h2 class="font-bold text-gray-900">Activity</h2>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 4l-5-5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                </button>
            </div>

            <!-- Scrollable List Area -->
            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">

                <!-- Note Input (Disabled for User) -->
                <!-- User can only view activity logs -->

                <div class="space-y-3">
                    @forelse($ticket->logs->sortByDesc('created_at') as $log)
                        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm relative pl-10">
                            <div class="absolute left-3 top-4">
                                <div class="bg-gray-100 p-1.5 rounded">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-sm font-bold text-gray-900 mb-0.5">{{ $log->action }}</div>
                            <div class="text-xs text-gray-500 mb-2">{{ $log->created_at->format('m/d/Y h:i:s A') }}</div>
                            <div class="text-xs text-gray-800 mb-2 font-medium">{{ $log->user->name ?? 'System' }}</div>
                            <div class="text-xs text-gray-600 leading-relaxed">
                                {{ $log->description }}
                                @if($log->attachments->count() > 0)
                                    @foreach($log->attachments as $attachment)
                                        <div class="mt-3">
                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-teal-600 hover:text-teal-700 hover:bg-teal-50 hover:border-teal-200 transition-all duration-200 group relative z-10">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span
                                                    class="text-xs font-medium underline group-hover:no-underline">{{ basename($attachment->file_path) }}</span>
                                                <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 text-sm py-8">No activity recorded yet.</div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
@endsection