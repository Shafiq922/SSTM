<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return $this->renderProfile($user, true); // True = is owner
    }

    public function viewProfile($id)
    {
        if ($id == Auth::id()) {
            return redirect()->route('user.profile.show');
        }

        $user = \App\Models\User::with('department')->findOrFail($id);
        return $this->renderProfile($user, false); // False = public view
    }

    private function renderProfile($user, $isOwner)
    {
        $itStaff = \App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'IT Staff');
        })->get();

        $ratingsGiven = $user->ratingsGiven()->with('ratee')->latest()->get();
        // For public profile of IT Staff, we might want to show ratings RECEIVED
        $ratingsReceived = $user->ratingsReceived()->with('rater')->latest()->get();

        // Tickets & Activities (Only for Owner or Admin viewing)
        $tickets = null;
        $activities = collect();

        if ($isOwner || Auth::user()->role->name === 'System Administrator') {
            // Conditional Ticket Fetching
            if ($user->role->name === 'IT Staff' || $user->role->name === 'System Administrator') {
                $tickets = $user->assignedTickets()->with('user')->latest()->paginate(10); // Show Requester
            } else {
                $tickets = $user->tickets()->with('assignee')->latest()->paginate(10); // Show Assignee
            }
            $activities = $user->ticketLogs()->with('ticket')->latest()->take(20)->get();
        }

        $view = $isOwner ? 'user.profile' : 'user.public-profile';
        return view($view, compact('user', 'itStaff', 'ratingsGiven', 'ratingsReceived', 'tickets', 'activities', 'isOwner'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->userID . ',userID',
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_phone = $request->phone; // Form input name="phone" maps to user_phone column
        //$user->department = $request->department; // Disabled as not requested and potentially incorrect column
        $user->save();

        return redirect()->route('user.profile.show')->with('success', 'Profile updated successfully!');
    }

    public function storeRating(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,userID',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        \App\Models\ServiceRating::create([
            'rater_userID' => Auth::id(),
            'ratee_userID' => $request->admin_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
}
