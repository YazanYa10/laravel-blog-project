@extends('site.layouts.master')

@section('title', 'Register')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">

            <div class="col-md-6">


                <h2 class="text-center mb-4">Register</h2>

                <form method="POST" action="{{ route('site.register') }}">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>

                </form>

                <div class="text-center mt-3">
                    <small>Already have an account? <a href="{{ route('site.login') }}">Login here</a></small>
                </div>

            </div>
        </div>
    </div>
@endsection
