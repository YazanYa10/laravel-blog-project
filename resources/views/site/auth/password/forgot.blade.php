@extends('site.layouts.master')

@section('title', 'Forgot Password')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Forgot Password</h2>

        <form method="POST" action="{{ route('site.password.send-code') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Enter your email:</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Send Reset Code</button>
        </form>
    </div>
@endsection
