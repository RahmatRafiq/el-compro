@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ubah Informasi Umum</h5>

            <form action="{{ route('general_information.update', $generalInformation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="type" class="form-label">Tipe</label>
                    <select id="type" name="category_id" class="form-select" required>
                        <option value="">-- Pilih Tipe --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') ? (old('category_id') == $category->id ? 'selected' : '') : ($generalInformation->type == $category->name ? 'selected' : '') }}>
                                {{ $category->name }}
                            </option>

                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $generalInformation->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description"
                        rows="3">{{ old('description', $generalInformation->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Ubah</button>
                <a href="{{ route('general_information.index') }}" class="btn btn-secondary">Batal</a>
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