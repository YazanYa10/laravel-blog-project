@extends('layouts.master')
@section('title')
    Edit Post Page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3>Edit Post</h3>
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

                        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="title">Post Title</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $post->title) }}">
                            </div>

                            <div class="form-group mt-3">
                                <label for="content">Post Content</label>
                                <textarea name="content" class="form-control" rows="5">{{ old('content', $post->content) }}</textarea>
                            </div>
                            @if ($post->image)
                                <div class="text-center mb-4">
                                    <label class="d-block mb-2">Current Image:</label>
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image"
                                        class="img-thumbnail shadow"
                                        style="width: 180px; height: 130px; object-fit: cover;">
                                </div>
                            @endif


                            <div class="form-group mt-3">
                                <label for="image">Featured Image</label>
                                <input type="file" name="image" class="form-control" id="imageInput">
                            </div>
                            <div class="text-center mt-3">
                                <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail shadow d-none"
                                    style="max-height: 200px;">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">-- Choose Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
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
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                }

                reader.readAsDataURL(file);
            } else {
                imagePreview.src = "#";
                imagePreview.classList.add('d-none');
            }
        });
    </script>
@endsection
