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
                <select id="type" name="type" class="form-select">
                    <option value="konsentrasi" {{ $generalInformation->type == 'konsentrasi' ? 'selected' : '' }}>Konsentrasi</option>
                    <option value="prospek_karir" {{ $generalInformation->type == 'prospek_karir' ? 'selected' : '' }}>Prospek Karir</option>
                    <option value="keunggulan" {{ $generalInformation->type == 'keunggulan' ? 'selected' : '' }}>Keunggulan</option>
                    <option value="capaian_prestasi" {{ $generalInformation->type == 'capaian_prestasi' ? 'selected' : '' }}>Capaian Prestasi</option>
                    <option value="sks_matakuliah" {{ $generalInformation->type == 'sks_matakuliah' ? 'selected' : '' }}>SKS Matakuliah</option>
                    <!-- Add more types as needed -->
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $generalInformation->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required>{{ old('description', $generalInformation->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('general_information.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>

<script>
    // Initialize CKEditor for description field
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
