@extends('layouts.master')
@section('title')
    Edit User
@endsection
@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3>Edit User</h3>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="form-control" required>
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
                                                    value="{{ $role->name }}"
                                                    {{ $user->roles->contains('name', $role->name) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="form-group mt-4 d-flex justify-content-between">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
