@extends('layouts.master')
@section('title')
    Create Permission Page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Create New Permission</h3>
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

                        <form action="{{ route('permissions.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Permission Name</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Enter permission name" required>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">Create</button>
                                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
