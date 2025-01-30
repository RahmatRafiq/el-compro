@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Add Virtual Content</div>
    <div class="card-body">
        <form action="{{ route('virtuals.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="url_embed" class="form-label">Embed URL</label>
                <input type="url" class="form-control" name="url_embed" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('virtuals.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
