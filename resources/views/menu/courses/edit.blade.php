@extends('layouts.app')

@section('content')
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Edit Course</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('courses.update', $course->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="course_code" class="form-label">Course Code</label>
                            <input type="text" class="form-control" name="course_code" value="{{ $course->course_code }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $course->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="credits" class="form-label">Credits</label>
                            <input type="number" class="form-control" name="credits" value="{{ $course->credits }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="number" class="form-control" name="semester" value="{{ $course->semester }}"
                                min="1" max="8" required>
                        </div>
                        <div class="mb-3">
                            <label for="major_concentration" class="form-label">Major Concentration</label>
                            <select class="form-select" name="major_concentration" required>
                                <option value="teknik_tenaga_listrik" {{ $course->major_concentration == 'teknik_tenaga_listrik' ? 'selected' : '' }}>TEKNIK TENAGA
                                    LISTRIK</option>
                                <option value="teknik_telekomunikasi" {{ $course->major_concentration == 'teknik_telekomunikasi' ? 'selected' : '' }}>TEKNIK
                                    TELEKOMUNIKASI</option>
                                <option value="semua_konsentrasi" {{ $course->major_concentration == 'semua_konsentrasi' ? 'selected' : '' }}>SEMUA KONSENTRASI</option>
                                <option value="mata_kuliah_dasar" {{ $course->major_concentration == 'mata_kuliah_dasar' ? 'selected' : '' }}>MATA KULIAH DASAR</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection