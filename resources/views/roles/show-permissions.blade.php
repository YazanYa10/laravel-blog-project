@extends('layouts.master')
@section('title')
    show Permissions
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ $role->name }} — Assigned Permissions</h4>
            </div>
            <div class="card-body">
                @if ($permissions->isEmpty())
                    <div class="alert alert-warning">No permissions assigned to this role.</div>
                @else
                    <ul class="list-group">
                        @foreach ($permissions as $permission)
                            <li class="list-group-item">
                                <i class="fas fa-check text-success"></i> {{ $permission->name }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-center mt-4">
                        {!! $permissions->links() !!}
                    </div>
                @endif
                <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
@endsection
