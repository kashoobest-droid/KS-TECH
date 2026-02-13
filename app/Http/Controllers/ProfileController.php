<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            if ($file->isValid()) {
                // Delete old avatar if exists
                if ($user->avatar && file_exists(public_path($user->avatar))) {
                    @unlink(public_path($user->avatar));
                }

                $avatarDir = 'upload/avatars';
                if (!is_dir(public_path($avatarDir))) {
                    mkdir(public_path($avatarDir), 0755, true);
                }

                $filename = 'avatar_' . $user->id . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($avatarDir), $filename);
                $validated['avatar'] = $avatarDir . '/' . $filename;
            }
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
