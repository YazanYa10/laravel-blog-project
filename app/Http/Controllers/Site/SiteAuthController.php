<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\SiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiteAuthController extends Controller
{


    public function showLoginForm()
    {
        return view('site.auth.login');
    }


    // Handle login
    public function login(Request $request)
    {
        // Step 1: Validate the inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'Please enter the user"s email address',
            'password.required' => 'Password required',
        ]);
        // Step 2: Attempt to log in
        if (Auth::guard('site')->attempt([
        'email' => $request->email,
        'password' => $request->password,
        ], $request->filled('remember'))) {
            session()->flash('success', 'Welcome back, ' . Auth::guard('site')->user()->name . '!');
        // Step 3: If successful, redirect to home or dashboard
        return redirect()->intended('/site');
        }
        // Step 4: If failed, go back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }
    

    // Show register page
    public function showRegisterForm()
    {
        return view('site.auth.register');
    }
    
    // Handle register
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:site_users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ],[
            'name.required' => 'Please enter your username',
            'email.required' => 'Please enter the user"s email address',
            'email.unique' => 'The entered email already exists',
            'password.required' => 'Password required',
            'password.confirmed' => 'Passwords must be match',
            'password.min' => 'Password must be more than six characters long',
        ]);

        $user = SiteUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('site')->login($user);
        session()->flash('success', 'Welcome to this beautiful blog, ' . Auth::guard('site')->user()->name . '!');
        return redirect('/site');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('site')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/site')->with('success', 'You have been logged out.');
    }
}
