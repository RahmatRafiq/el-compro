@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Data Mata Kuliah</h5>
            <div>
                <a href="{{ route('courses.create') }}" class="btn btn-success">Tambah Mata Kuliah</a>
            </div>
        </div>

        <div class="mb-3 mt-3 d-flex justify-content-end">
            <label for="filter" class="form-label me-2">Filter Mata Kuliah</label>
            <select id="filter" class="form-select w-auto">
                <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Mata Kuliah Aktif</option>
                <option value="trashed" {{ $filter == 'trashed' ? 'selected' : '' }}>Mata Kuliah Terhapus</option>
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua Mata Kuliah</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table styled-table" id="courses">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>SKS</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->course_code }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->credits }}</td>
                            <td>
                                @if ($course->deleted_at)
                                    <span class="badge bg-danger">Terhapus</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if ($course->deleted_at)
                                    <form action="{{ route('courses.restore', $course->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Pulihkan</button>
                                    </form>
                                    <form action="{{ route('courses.forceDelete', $course->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus permanen?')">Hapus Permanen</button>
                                    </form>
                                @else
                                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary btn-sm">Ubah</a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteCourse({{ $course->id }})">Hapus</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/DataTables/datatables.min.css') }}">
<link href="{{ asset('assets/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('javascript')
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#courses').DataTable({
            "searching": true,  // Enable search feature
            "paging": true,     // Enable pagination
            "ordering": true,   // Enable sorting
        });

        // Initialize Select2 for the filter
        $('#filter').select2({
            placeholder: "Pilih Filter",
            allowClear: true
        });

        // Change filter value and reload page
        $('#filter').change(function() {
            let filter = $(this).val();
            window.location.href = `{{ route('courses.index') }}?filter=${filter}`;
        });
    });

    // Delete course function with confirmation
    function deleteCourse(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Mata kuliah ini akan dipindahkan ke tempat sampah!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('courses.destroy', ':id') }}`.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        window.location.reload();
                        Swal.fire('Berhasil!', 'Mata kuliah telah dipindahkan ke tempat sampah.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', 'Gagal menghapus mata kuliah.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
