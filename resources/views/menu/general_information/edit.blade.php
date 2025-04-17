@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit General Information</h5>

            <form action="{{ route('general_information.update', $generalInformation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select id="type" name="category_id" class="form-select" required>
                        <option value="">-- Select Type --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') ? (old('category_id') == $category->id ? 'selected' : '') : ($generalInformation->type == $category->name ? 'selected' : '') }}>
                                {{ $category->name }}
                            </option>

                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $generalInformation->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"
                        rows="3">{{ old('description', $generalInformation->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('general_information.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection