@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Access</b> Denied</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body text-center">
                <h3 class="text-danger">403</h3>
                <p>You do not have permission to access this page.</p>
                <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Back</a>
            </div>
        </div>
    </div>
@endsection
