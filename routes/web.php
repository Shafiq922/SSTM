<?php


use App\Http\Controllers\DashboardController;


use App\Http\Controllers\IncidentController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ServiceRequestController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


/* page redirect view */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');




/* User navbar menu */
//create incident
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
    Route::get('ticket/incident', [IncidentController::class, 'create'])->name('ticket.incident.create');
    Route::post('ticket/incident', [IncidentController::class, 'store'])->name('ticket.incident.store');
    Route::get('ticket/details/{id}', function ($id) {
        $ticket = \App\Models\Ticket::with(['user', 'assignee', 'category', 'subCategory', 'attachments', 'logs.user', 'logs.attachments'])
            ->findOrFail($id);
        return view('user.ticket.ticket-details', compact('ticket'));
    })->name('ticket.details');

    // Service Request
    Route::get('ticket/service-request', [ServiceRequestController::class, 'create'])->name('ticket.service_request.create');
    Route::post('ticket/service-request', [ServiceRequestController::class, 'store'])->name('ticket.service_request.store');

    // Ticket Actions
    Route::post('ticket/note/{id}', [\App\Http\Controllers\UserTicketController::class, 'storeNote'])->name('ticket.note');
});
//user profile
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
    Route::get('profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::post('profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/rating', [UserProfileController::class, 'storeRating'])->name('profile.rating.store');
});

/* Admin routes (Temporary for layout testing) */
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Analytics Dashboard
    Route::get('analytics', [\App\Http\Controllers\AnalyticsController::class, 'index'])->name('analytics');

    // 1. Admin Dashboard / Ticket List
    Route::get('tickets', function (\Illuminate\Http\Request $request) {
        // --- 1. Metrics Calculation ---

        // Determine if priority filter is active
        $priorityFilter = $request->query('priority');

        // Base query for metrics (respects priority filter)
        $metricsQuery = function () use ($priorityFilter) {
            $query = \App\Models\Ticket::query();
            if ($priorityFilter) {
                $query->where('priority', $priorityFilter);
            }
            return $query;
        };

        // Lq: Total tickets in queue (Open, In Progress, Pending)
        $totalTicketsInQueue = $metricsQuery()->whereIn('status', ['Open', 'In Progress', 'Pending'])->count();

        // Wq: Average waiting time (for Unassigned 'Open' tickets) - in minutes
        // We fetch created_at of all open unassigned tickets and avg the diff from now
        $openTickets = $metricsQuery()->where('status', 'Open')->whereNull('assigneeID')->get();
        $avgWaitMinutes = $openTickets->isEmpty() ? 0 : $openTickets->average(function ($t) {
            return $t->created_at ? $t->created_at->diffInMinutes(now()) : 0;
        });

        // Format: if > 60 mins, show hours, else mins
        $avgWaitingTime = $avgWaitMinutes > 60
            ? round($avgWaitMinutes / 60, 1) . ' hours'
            : round($avgWaitMinutes) . ' mins';

        // C: Number of active IT staff (not affected by priority filter)
        $activeITStaff = \App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'IT Staff');
        })->count();

        // Tickets nearing SLA breach (Active tickets older than 24h - placeholder logic)
        // In real app, compare created_at + sla->resolution_time vs now()
        $ticketsNearingSLA = $metricsQuery()->whereIn('status', ['Open', 'In Progress'])
            ->where('created_at', '<', now()->subHours(24))
            ->count();


        // --- 2. Filtering & Data Fetching ---
        $query = \App\Models\Ticket::with(['user', 'assignee'])->latest();

        if ($request->has('priority')) {
            $query->where('priority', $request->query('priority'));
            $filterLabel = 'Filtered: ' . $request->query('priority');
        } else {
            $filterLabel = 'All tickets (Admin View)';
        }

        $tickets = $query->get();

        return view('admin.ticket.index', compact(
            'tickets',
            'filterLabel',
            'totalTicketsInQueue',
            'avgWaitingTime',
            'activeITStaff',
            'ticketsNearingSLA'
        ));
    })->name('tickets');

    // 2. Create Incident
    Route::get('ticket/incident', function () {
        $categories = \App\Models\Category::with('subCategories')
            ->where(function ($q) {
                $q->where('name', 'LIKE', 'Incident%')
                    ->orWhere('name', 'IT Infrastructure');
            })->get();
        $summaryTemplates = \App\Models\SummaryTemplate::where('is_active', true)->get();
        return view('admin.ticket.incident', compact('categories', 'summaryTemplates'));
    })->name('ticket.incident.create');

    // 3. Ticket Details
    Route::get('ticket/details/{id}', [\App\Http\Controllers\AdminTicketController::class, 'show'])->name('ticket.details');
    Route::put('ticket/update/{id}', [\App\Http\Controllers\AdminTicketController::class, 'update'])->name('ticket.update');
    Route::post('ticket/note/{id}', [\App\Http\Controllers\AdminTicketController::class, 'storeNote'])->name('ticket.note');
    Route::delete('ticket/attachment/{id}', [\App\Http\Controllers\AdminTicketController::class, 'deleteAttachment'])->name('ticket.attachment.delete');
    Route::delete('ticket/delete/{id}', [\App\Http\Controllers\AdminTicketController::class, 'destroy'])->name('ticket.delete');
    Route::delete('tickets/bulk-delete', [\App\Http\Controllers\AdminTicketController::class, 'bulkDestroy'])->name('tickets.bulk-delete');

    // 4. Service Request
    Route::get('ticket/service-request', function () {
        $categories = \App\Models\Category::with('subCategories')
            ->where(function ($q) {
                // Match logic in ServiceRequestController
                $q->where('name', 'LIKE', 'ERP – %');
            })->get();
        // If empty fallback
        if ($categories->isEmpty()) {
            $categories = \App\Models\Category::with('subCategories')->get();
        }

        $summaryTemplates = \App\Models\SummaryTemplate::where('is_active', true)->get();

        return view('admin.ticket.service_request', compact('categories', 'summaryTemplates'));
    })->name('ticket.service_request.create');

});



/* laravel default build */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
