<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = \App\Models\Role::all();
        $departments = \App\Models\Department::all();
        return view('auth.register', compact('roles', 'departments'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'user_phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roleID' => ['required', 'exists:roles,roleID'],
            'departmentID' => ['required', 'exists:departments,departmentID'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_phone' => $request->user_phone,
            'password' => Hash::make($request->password),
            'roleID' => $request->roleID,
            'departmentID' => $request->departmentID,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role && in_array($user->role->name, ['Admin', 'IT Staff'])) {
            return redirect(route('admin.tickets', absolute: false));
        }

        return redirect(route('dashboard', absolute: false));
    }
}
