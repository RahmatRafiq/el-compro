@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Data Dosen</h5>
            <div>
                <a href="{{ route('lecturers.create') }}" class="btn btn-success">Tambah Dosen</a>
            </div>
        </div>

        <div class="mb-3 mt-3 d-flex justify-content-end">
            <label for="filter" class="form-label me-2">Filter Dosen</label>
            <select id="filter" class="form-select w-auto">
                <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Dosen Aktif</option>
                <option value="trashed" {{ $filter == 'trashed' ? 'selected' : '' }}>Dosen Terhapus</option>
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua Dosen</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table styled-table" id="lecturers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Tentang</th>
                        <th>Mata Kuliah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lecturers as $lecturer)
                        <tr>
                            <td>{{ $lecturer->id }}</td>
                            <td>{{ $lecturer->name }}</td>
                            <td>{{ $lecturer->about }}</td>
                            <td>{{ $lecturer->courses->pluck('name')->join(', ') }}</td>
                            <td>
                                @if ($lecturer->deleted_at)
                                    <span class="badge bg-danger">Terhapus</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if ($lecturer->deleted_at)
                                    <form action="{{ route('lecturers.restore', $lecturer->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Pulihkan</button>
                                    </form>
                                    <form action="{{ route('lecturers.forceDelete', $lecturer->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus permanen?')">Hapus Permanen</button>
                                    </form>
                                @else
                                    <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="btn btn-primary btn-sm">Ubah</a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteLecturer({{ $lecturer->id }})">Hapus</button>
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
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#lecturers').DataTable();

        // Initialize Select2 for the filter
        $('#filter').select2({
            placeholder: "Filter Dosen",
            allowClear: true
        });

        // On change of the filter, reload the page with the selected filter
        $('#filter').change(function() {
            let filter = $(this).val();
            window.location.href = `{{ route('lecturers.index') }}?filter=${filter}`;
        });
    });

    function deleteLecturer(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Dosen ini akan dipindahkan ke tempat sampah!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('lecturers.destroy', ':id') }}`.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        window.location.reload();
                        Swal.fire('Berhasil!', 'Dosen telah dipindahkan ke tempat sampah.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', 'Gagal menghapus dosen.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
