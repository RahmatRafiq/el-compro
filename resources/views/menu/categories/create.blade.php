@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambah Kategori</h5>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <select name="type" class="form-control" required>
                    <option value="virtual_tours" {{ old('type') == 'virtual_tours' ? 'selected' : '' }}>Virtual Tour</option>
                    <option value="general_information" {{ old('type') == 'general_information' ? 'selected' : '' }}>Informasi Umum</option>
                    <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>Artikel</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
