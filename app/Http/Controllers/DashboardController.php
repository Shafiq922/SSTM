<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active'); // Default to 'active'

        $query = Ticket::with(['user', 'assignee'])->latest();

        $filterLabel = 'All open tickets';

        switch ($filter) {
            case 'all':
                $filterLabel = 'All tickets';
                break;
            case 'open':
                $query->where('status', 'Open');
                $filterLabel = 'Open tickets';
                break;
            case 'closed':
                $query->where('status', 'Closed');
                $filterLabel = 'Closed tickets';
                break;
            case 'active':
            default:
                $query->whereIn('status', ['Open', 'In Progress']);
                $filterLabel = 'All open tickets';
                break;
        }

        $tickets = $query->get();

        return view('user.ticket.index', compact('tickets', 'filterLabel'));
    }
}
