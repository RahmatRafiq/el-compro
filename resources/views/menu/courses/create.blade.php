@extends('layouts.app')

@section('content')
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Tambah Mata Kuliah</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('courses.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="course_code" class="form-label">Kode Mata Kuliah</label>
                            <input type="text" class="form-control" name="course_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Mata Kuliah</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="credits" class="form-label">SKS</label>
                            <input type="number" class="form-control" name="credits" required>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="number" class="form-control" name="semester" min="1" max="8" required>
                        </div>
                        <div class="mb-3">
                            <label for="major_concentration" class="form-label">Konsentrasi</label>
                            <select class="form-select" name="major_concentration" required>
                                <option value="teknik_tenaga_listrik">TEKNIK TENAGA LISTRIK</option>
                                <option value="teknik_telekomunikasi">TEKNIK TELEKOMUNIKASI</option>
                                <option value="semua_konsentrasi">SEMUA KONSENTRASI</option>
                                <option value="mata_kuliah_dasar">MATA KULIAH DASAR</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection