<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'country' => 'nullable|string|max:255',
            'street_name' => 'nullable|string|max:255',
            'building_name' => 'nullable|string|max:255',
            'floor_apartment' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city_area' => 'nullable|string|max:255',
            'is_admin' => 'nullable|boolean',
        ]);

        // Ensure is_admin is stored as 0/1
        $validated['is_admin'] = $request->has('is_admin') ? 1 : 0;

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
