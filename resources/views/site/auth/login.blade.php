@extends('site.layouts.master')

@section('title', 'Login')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <h2 class="text-center mb-4">Login</h2>

                <form method="POST" action="{{ route('site.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control"autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>

                </form>

                <div class="text-center mt-3">
                    <small>Don't have an account? <a href="{{ route('site.register') }}">Register here</a></small>
                    <br>
                    <small>Forgot your password? <a href="{{ route('site.password.forgot') }}">Click Here</a></small>
                </div>

            </div>
        </div>
    </div>
@endsection
