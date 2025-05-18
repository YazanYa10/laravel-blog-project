@extends('site.layouts.master')

@section('title', 'Change Password')

@section('content')
    <div class="container">
        <h1>Change Your Password</h1>

        <form method="POST" action="{{ route('profile.password.change') }}">
            @csrf
            <div class="form-group">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="form-control">


            </div>
            <div class="form-group mt-3">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group mt-3">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Change Password</button>
        </form>
    </div>
@endsection
