@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Ubah Capaian Pembelajaran Lulusan</h5>
        <form action="{{ route('graduate_learning_outcomes.update', $graduateLearningOutcome->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="concentration" class="form-label">Konsentrasi</label>
                <select class="form-select" id="concentration" name="concentration" required>
                    <option value="">-- Pilih Konsentrasi --</option>
                    <option value="teknik_tenaga_listrik" {{ (old('concentration', $graduateLearningOutcome->concentration) == 'teknik_tenaga_listrik') ? 'selected' : '' }}>TEKNIK TENAGA LISTRIK</option>
                    <option value="teknik_telekomunikasi" {{ (old('concentration', $graduateLearningOutcome->concentration) == 'teknik_telekomunikasi') ? 'selected' : '' }}>TEKNIK TELEKOMUNIKASI</option>
                  
                </select>
                @error('concentration')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $graduateLearningOutcome->category) }}" required>
                @error('category')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $graduateLearningOutcome->description) }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Ubah</button>
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
