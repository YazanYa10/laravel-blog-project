@extends('site.layouts.master')

@section('title', 'Verify Reset Code')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Enter Verification Code</h2>
        <form method="POST" action="{{ route('site.password.verify-code') }}">
            @csrf
            <div class="mb-3">
                <label for="code" class="form-label">Enter the 6-digit code:</label>
                <input type="text" class="form-control" name="code" required maxlength="6">
            </div>

            <button type="submit" class="btn btn-primary">Verify Code</button>
        </form>
    </div>
@endsection
