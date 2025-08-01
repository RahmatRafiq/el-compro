@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Data Kategori</h5>
            <div>
                <a href="{{ route('categories.create') }}" class="btn btn-success">Tambah Kategori</a>
            </div>
        </div>

        <div class="mb-3 mt-3 d-flex justify-content-end">
            <label for="filter" class="form-label me-2">Filter Kategori</label>
            <select id="filter" class="form-select w-auto">
                <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="trashed" {{ $filter == 'trashed' ? 'selected' : '' }}>Terhapus</option>
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table styled-table" id="categories">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                @if ($category->type == 'virtual_tours')
                                    Virtual Tour
                                @elseif ($category->type == 'general_information')
                                    Informasi Umum
                                @elseif ($category->type == 'article')
                                    Artikel
                                @else
                                    {{ $category->type ?? '-' }}
                                @endif
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if ($category->deleted_at)
                                    <span class="badge bg-danger">Terhapus</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if ($category->deleted_at)
                                    <form action="{{ route('categories.restore', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Pulihkan</button>
                                    </form>
                                    <form action="{{ route('categories.forceDelete', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus permanen?')">Hapus Permanen</button>
                                    </form>
                                @else
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Ubah</a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteCategory({{ $category->id }})">Hapus</button>
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
<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">
@endpush

@push('javascript')
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#categories').DataTable();

        $('#filter').select2({
            placeholder: "Filter Kategori",
            allowClear: true
        });

        $('#filter').change(function() {
            let filter = $(this).val();
            window.location.href = `{{ route('categories.index') }}?filter=${filter}`;
        });
    });

    function deleteCategory(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Kategori ini akan dipindahkan ke tempat sampah!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('categories.destroy', ':id') }}`.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', 'Kategori telah dipindahkan ke tempat sampah.', 'success')
                        .then(() => window.location.reload());
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', 'Gagal menghapus kategori.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush

