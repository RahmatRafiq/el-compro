@extends('layouts.app')

@section('content')
<div class="row gx-3">
    <div class="col-xxl-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Edit Lecturer</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('lecturers.update', $lecturer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Lecturer Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $lecturer->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Lecturer Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted">Leave blank if you don't want to change the image.</small>
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $lecturer->image) }}" width="100" class="rounded">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="courses" class="form-label">Assign Courses</label>
                        <select id="courses-select" name="courses[]" class="form-select" multiple="multiple">
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" 
                                    {{ $lecturer->courses->contains($course->id) ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('assets/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('javascript')
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#courses-select').select2({
            placeholder: "Select Courses",
            allowClear: true
        });
    });
</script>
@endpush
