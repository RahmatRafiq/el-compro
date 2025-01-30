@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-header">
            <h5 class="card-title">Edit Virtual Content</h5>
        </div>

        <form action="{{ route('virtuals.update', $virtual->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control select2" name="category_id" required>
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('category_id', $virtual->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $virtual->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="url_embed" class="form-label">URL Embed</label>
                <input type="url" class="form-control" id="url_embed" name="url_embed" value="{{ old('url_embed', $virtual->url_embed) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $virtual->description) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('virtuals.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('assets/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('javascript')

<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for category selection
        $('.select2').select2({
            placeholder: "Select Category",
            allowClear: true
        });

        // Initialize CKEditor for description
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endpush
