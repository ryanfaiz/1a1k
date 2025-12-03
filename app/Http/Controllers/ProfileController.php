<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile', [
            'title' => 'Profil'
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:1000'
        ]);

        if ($request->hasFile('avatar')) {
            // delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }

        // Save bio if present (allow empty string to clear)
        if ($request->filled('bio') || $request->input('bio') === '') {
            $user->bio = $request->input('bio');
            $user->save();
        }

        return back()->with('success', 'Profil diperbarui.');
    }
}
