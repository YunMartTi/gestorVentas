<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('profile.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'cedula'      => 'required|string|max:50|unique:users',
            'telefono'    => 'required|string|max:20',
            'prospeccion' => 'nullable|string|max:255',
            'supervisor'  => 'nullable|string|max:255',
            'email'       => 'required|email|unique:users',
            'password'    => 'required|string|min:4|confirmed',
            'role'        => 'required|in:admin,asesor,activador,calibrador,supervisor',
        ]);

        User::create([
            'name'        => $validated['name'],
            'cedula'      => $validated['cedula'],
            'telefono'    => $validated['telefono'],
            'prospeccion' => $validated['prospeccion'],
            'supervisor'  => $validated['supervisor'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => $validated['role'],
        ]);

        return Redirect::route('profile.create')->with('status', 'Usuario creado exitosamente');
    }

    /**
     * Display the specified user's profile.
     */
    public function show(User $user): View
    {
        return view('profile.show', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
