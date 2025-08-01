@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Data Capaian Pembelajaran Lulusan</h5>
            <a href="{{ route('graduate_learning_outcomes.create') }}" class="btn btn-success">Tambah Capaian</a>
        </div>

        <div class="mb-3 mt-3 d-flex justify-content-end">
            <label for="filter" class="form-label me-2">Filter</label>
            <select id="filter" class="form-select w-auto">
                <option value="all">Semua</option>
                <option value="teknik_telekomunikasi">Teknik Telekomunikasi</option>
                <option value="teknik_tenaga_listrik">Teknik Tenaga Listrik</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table" id="outcomesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Konsentrasi</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outcomes as $outcome)
                        <tr>
                            <td>{{ $outcome->id }}</td>
                            <td>{{ $outcome->concentration }}</td>
                            <td>{{ $outcome->name }}</td>
                            <td>
                                <div style="word-wrap: break-word; max-width: 200px;">
                                    {{ Str::limit(strip_tags($outcome->description), 300) }}
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('graduate_learning_outcomes.edit', $outcome->id) }}" class="btn btn-primary btn-sm">Ubah</a>
                                <form action="{{ route('graduate_learning_outcomes.destroy', $outcome->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus capaian ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
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
        $('#outcomesTable').DataTable();

        // Initialize Select2 for the filter
        $('#filter').select2({
            placeholder: "Filter Konsentrasi",
            allowClear: true
        });

        // On change of the filter, reload the page with the selected filter
        $('#filter').change(function() {
            let filter = $(this).val();
            window.location.href = `{{ route('graduate_learning_outcomes.index') }}?filter=${filter}`;
        });

        // Delete Data with SweetAlert
        $('.btn-danger').click(function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Capaian ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak, batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Berhasil!',
                        'Capaian telah dihapus.',
                        'success'
                    );
                }
            });
        });
    });
</script>
@endpush
@endsection
