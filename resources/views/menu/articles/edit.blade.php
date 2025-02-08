@extends('layouts.app')

@section('content')
<div class="row gx-3">
    <div class="col-xxl-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Edit Article</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $article->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select id="category-select" name="category_id" class="form-select">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ $article->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" name="content" rows="5" required>{{ $article->content }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">Article Image</label>
                        <div class="dropzone" id="myDropzone"></div>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('assets/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('head')
@vite(['resources/js/dropzoner.js'])
<script src="{{ asset('assets/vendor/toastify/toastify.js') }}"></script>
@endpush

@push('javascript')
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#category-select').select2({
            placeholder: "Select Category",
            allowClear: true
        });
    });
</script>

<script type="module">
    const element = '#myDropzone';
    const key = 'article-image';
    const urlStore = "{!! route('storage.store') !!}";
    const csrf = "{!! csrf_token() !!}";
    const acceptedFiles = 'image/*';
    const maxFiles = 1;
    const files = [];

    @if ($articleImage)
        files.push({
            id: '{{ $articleImage->id }}',
            name: '{{ $articleImage->name }}',
            file_name: '{{ $articleImage->file_name }}',
            size: '{{ $articleImage->size }}',
            type: '{{ $articleImage->mime_type }}',
            url: '{{ $articleImage->getUrl() }}',
            original_url: '{{ $articleImage->getFullUrl() }}',
        });
    @endif

    const dz = Dropzoner(
        element,
        key,
        { urlStore, acceptedFiles, files, maxFiles, csrf }
    );

    dz.on("success", function(file, response) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'images[]';  
        input.value = response.path;
        document.querySelector('form').appendChild(input);
    });
</script>
@endpush
