@extends('layouts.master')
@section('title')
    Create a category page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3>Create New Category</h3>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    placeholder="Enter category name">
                            </div>
                            <div class="form-group mt-3">
                                <label for="image">Category Image</label>
                                <input type="file" name="image" class="form-control" id="categoryImageInput">
                            </div>

                            <div class="text-center mt-3">
                                <img id="categoryImagePreview" src="#" alt="Preview"
                                    class="img-thumbnail shadow d-none" style="max-height: 200px;">
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const catInput = document.getElementById('categoryImageInput');
        const catPreview = document.getElementById('categoryImagePreview');

        catInput?.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    catPreview.src = e.target.result;
                    catPreview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                catPreview.src = "#";
                catPreview.classList.add('d-none');
            }
        });
    </script>
@endsection
