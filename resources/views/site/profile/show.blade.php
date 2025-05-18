@extends('site.layouts.master')

@section('title', 'Profile')

@section('content')
    <div class="container">
        <h1>Your Profile</h1>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control"
                    required>
            </div>
            <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <label for="current_password" class="form-label">Current Password (required to confirm changes)</label>
                <input type="password" name="current_password" id="current_password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
        </form>

    </div>
@endsection
