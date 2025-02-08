@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Category</h5>
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-control">
                    <option value="virtual_tours" {{ old('type', $category->type) == 'virtual_tours' ? 'selected' : '' }}>Virtual Tours</option>
                    <option value="general_information" {{ old('type', $category->type) == 'general_information' ? 'selected' : '' }}>General Information</option>
                    <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>Article</option>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
