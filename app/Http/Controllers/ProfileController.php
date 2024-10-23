<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::find(Auth::id()); 

        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture) {
                Storage::disk('s3')->delete($user->profile_picture);
            }

            // Upload foto baru
            $path = $request->file('profile_picture')->store('profile_pictures', 's3');
            
            // Set file sebagai public
            Storage::disk('s3')->setVisibility($path, 'public');

            $user->profile_picture = $path;
            $user->save();
        }

        return redirect()->back()->with('status', 'Profile updated successfully.');
    }
}