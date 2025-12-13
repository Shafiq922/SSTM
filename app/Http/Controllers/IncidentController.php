<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncidentController extends Controller
{
    // Show the form
    public function create()
    {
        return view('user.ticket.incident');
    }


    // Handle form submission
    public function store(Request $request)
    {
        // validate data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        // save to database (example)
        // Incident::create($request->all());

        // redirect back with success message
        return redirect()->route('incident.create')->with('success', 'Incident created successfully!');
    }
}
