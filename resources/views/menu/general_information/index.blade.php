@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Data Informasi Umum</h5>
            <a href="{{ route('general_information.create') }}" class="btn btn-success">Tambah Data</a>
        </div>

        <div class="mb-3 mt-3 d-flex justify-content-end">
            <label for="filter" class="form-label me-2">Filter</label>
            <select id="filter" class="form-select w-auto">
                <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="trashed" {{ $filter == 'trashed' ? 'selected' : '' }}>Terhapus</option>
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table" id="generalInfoTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($generalInformations as $info)
                        <tr>
                            <td>{{ $info->id }}</td>
                            <td>{{ $info->type }}</td>
                            <td>{{ $info->name }}</td>
                            <td>
                                <div style="word-wrap: break-word; max-width: 200px;">
                                    {{ Str::limit(strip_tags($info->description), 300) }}
                                </div>
                            </td>
                            
                            <td>
                                @if ($info->deleted_at)
                                    <span class="badge bg-danger">Terhapus</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if ($info->deleted_at)
                                    <form action="{{ route('general_information.restore', $info->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Pulihkan</button>
                                    </form>
                                    <form action="{{ route('general_information.forceDelete', $info->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus permanen?')">Hapus Permanen</button>
                                    </form>
                                @else
                                    <a href="{{ route('general_information.edit', $info->id) }}" class="btn btn-primary btn-sm">Ubah</a>
                                    <form action="{{ route('general_information.destroy', $info->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                    </form>
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
<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('assets/DataTables/datatables.min.css') }}">
<!-- Select2 CSS -->
<link href="{{ asset('assets/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('javascript')
<!-- DataTables JS -->
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
<!-- Select2 JS -->
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
<!-- SweetAlert2 JS -->
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#generalInfoTable').DataTable();

        // Initialize Select2 for the filter
        $('#filter').select2({
            placeholder: "Filter Informasi Umum",
            allowClear: true
        });

        // On change of the filter, reload the page with the selected filter
        $('#filter').change(function() {
            let filter = $(this).val();
            window.location.href = `{{ route('general_information.index') }}?filter=${filter}`;
        });

        // Delete Data with SweetAlert
        $('.btn-danger').click(function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const title = $(this).text().includes('Hapus Permanen') ? 'Hapus Permanen' : 'Hapus';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data ini akan di${title.toLowerCase()}!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: `Ya, ${title.toLowerCase()}!`,
                cancelButtonText: 'Tidak, batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Berhasil!',
                        'Data telah dihapus.',
                        'success'
                    );
                }
            });
        });
    });
</script>
@endpush
