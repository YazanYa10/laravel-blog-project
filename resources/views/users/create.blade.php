@extends('layouts.master')
@section('title')
    Add New User
@endsection
@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3>Add New User</h3>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Validation Errors:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            </div>

                            <div class="form-group mt-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>

                            <div class="form-group mt-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group mt-3">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#rolesCollapse">
                                            Show / Hide Roles
                                        </button>
                                    </h5>
                                </div>

                                <div id="rolesCollapse" class="collapse">
                                    <div class="card-body">
                                        @foreach ($roles as $role)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="roles[]"
                                                    value="{{ $role->name }}">
                                                <label class="form-check-label">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="form-group mt-4 d-flex justify-content-between">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-success">Create User</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
