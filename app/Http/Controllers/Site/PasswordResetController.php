<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\SiteUser;
class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('site.auth.password.forgot');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:site_users,email']);

        $code = rand(100000, 999999);
        Session::put('password_reset_code', $code);
        Session::put('password_reset_email', $request->email);

        // Send email
        Mail::raw("Your password reset code is: $code", function ($message) use ($request) {
            $message->from('noreply@myblog.com', 'My Blog'); // Force the 'from' address here
            $message->to($request->email)
                ->subject('Password Reset Code');
        });

        session()->flash('success', 'A reset code has been sent to your email.');
        return redirect()->route('site.password.verify-code.form');
    }

    public function showVerifyCodeForm()
    {
        return view('site.auth.password.verify-code');
    }

    public function verifyCode(Request $request )
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        if ($request->code == session('password_reset_code')) {
            return redirect()->route('site.password.reset.form');
        }

        return back()->withErrors(['code' => 'The code is incorrect.']);
    }

    public function showResetPasswordForm()
    {
        if (!Session::has('password_reset_email')) {
            return redirect()->route('site.password.forgot')->withErrors(['email' => 'Session expired. Please try again.']);
        }

        return view('site.auth.password.reset_password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = Session::get('password_reset_email');
        $user = SiteUser::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('site.password.forgot')->withErrors(['email' => 'User not found.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        // Clean up the session
        Session::forget(['password_reset_code', 'password_reset_email']);
        session()->flash('success', 'Password reset successful. You can now log in.');
        return redirect()->route('site.login');
    }
}
