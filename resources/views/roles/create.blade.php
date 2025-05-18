@extends('layouts.master')
@section('title')
    Create Role page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3>Create New Role</h3>
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

                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter role name"
                                    required>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#permissionsCollapse">
                                            Show / Hide Permissions
                                        </button>
                                    </h5>
                                </div>

                                <div id="permissionsCollapse" class="collapse">
                                    <div class="card-body">
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="permissions[]"
                                                    value="{{ $permission->name }}">
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">Create Role</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
