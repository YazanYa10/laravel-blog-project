<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SiteUser;

class SiteProfileController extends Controller
{
    // Show the user's profile
    public function show()
    {
        $user = Auth::guard('site')->user();
        return view('site.profile.show', compact('user'));
    }

    // Update profile information (Name and Email)
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:site_users,email,' . Auth::guard('site')->id(),
            'current_password' => 'required',
        ]);
        $user = Auth::guard('site')->user();
        // Check if current password is correct
        if (!Hash::check($request->current_password, auth()->guard('site')->user()->password)) {
            return back()->withErrors(['current_password' => 'The current password you entered is incorrect.']);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        session()->flash('success', 'Profile updated successfully!');
        return redirect()->route('profile.show');
    }

    // Show password change form
    public function showPasswordForm()
    {
        return view('site.profile.change-password');
    }

    // Change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::guard('site')->user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, auth()->guard('site')->user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Password changed successfully!');
        return redirect()->route('profile.show');
    }

}
