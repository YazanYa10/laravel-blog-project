@extends('site.layouts.master')

@section('title', 'Reset Password')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Reset Your Password</h2>

        <form method="POST" action="{{ route('site.password.reset') }}">
            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">New Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
@endsection
