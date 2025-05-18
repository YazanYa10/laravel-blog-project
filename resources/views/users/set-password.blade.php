@extends('layouts.master')
@section('title')
    Password modification page
@endsection
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>Set Password for: {{ $user->name }}</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.password.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
