<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class PasswordController extends Controller
{
    public function edit()
    {
        return view('auth.passwords.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('home')->with('success', 'Password updated successfully!');
    }
}
