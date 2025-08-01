@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Ubah Kategori</h5>
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <select name="type" class="form-control">
                    <option value="virtual_tours" {{ old('type', $category->type) == 'virtual_tours' ? 'selected' : '' }}>Virtual Tour</option>
                    <option value="general_information" {{ old('type', $category->type) == 'general_information' ? 'selected' : '' }}>Informasi Umum</option>
                    <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>Artikel</option>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Ubah</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
