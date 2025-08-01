@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambah Capaian Pembelajaran Lulusan</h5>
        <form action="{{ route('graduate_learning_outcomes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="concentration" class="form-label">Konsentrasi</label>
                <select class="form-select" id="concentration" name="concentration" required>
                    <option value="">-- Pilih Konsentrasi --</option>
                    <option value="teknik_tenaga_listrik" {{ old('concentration') == 'teknik_tenaga_listrik' ? 'selected' : '' }}>TEKNIK TENAGA LISTRIK</option>
                    <option value="teknik_telekomunikasi" {{ old('concentration') == 'teknik_telekomunikasi' ? 'selected' : '' }}>TEKNIK TELEKOMUNIKASI</option>
                    <option value="semua_konsentrasi" {{ old('concentration') == 'semua_konsentrasi' ? 'selected' : '' }}>SEMUA KONSENTRASI</option>
                    <option value="mata_kuliah_dasar" {{ old('concentration') == 'mata_kuliah_dasar' ? 'selected' : '' }}>MATA KULIAH DASAR</option>
                </select>
                @error('concentration')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('graduate_learning_outcomes.index') }}" class="btn btn-secondary">Batal</a>
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
