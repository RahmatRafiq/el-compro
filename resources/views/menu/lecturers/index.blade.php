@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Lecturer Data</h5>
            <div>
                <a href="{{ route('lecturers.create') }}" class="btn btn-success">Add Lecturer</a>
            </div>
        </div>

        <div class="mb-3 mt-3 d-flex justify-content-end">
            <label for="filter" class="form-label me-2">Filter Lecturers</label>
            <select id="filter" class="form-select w-auto">
                <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Active Lecturers</option>
                <option value="trashed" {{ $filter == 'trashed' ? 'selected' : '' }}>Deleted Lecturers</option>
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Lecturers</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table styled-table" id="lecturers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Courses</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lecturers as $lecturer)
                        <tr>
                            <td>{{ $lecturer->id }}</td>
                            <td>{{ $lecturer->name }}</td>
                            <td>{{ $lecturer->courses->pluck('name')->join(', ') }}</td>
                            <td>
                                @if ($lecturer->deleted_at)
                                    <span class="badge bg-danger">Deleted</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>
                                @if ($lecturer->deleted_at)
                                    <form action="{{ route('lecturers.restore', $lecturer->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                                    </form>
                                    <form action="{{ route('lecturers.forceDelete', $lecturer->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete permanently?')">Delete Permanently</button>
                                    </form>
                                @else
                                    <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteLecturer({{ $lecturer->id }})">Delete</button>
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
@endpush

@push('javascript')
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#lecturers').DataTable();

        $('#filter').change(function() {
            let filter = $(this).val();
            window.location.href = `{{ route('lecturers.index') }}?filter=${filter}`;
        });
    });

    function deleteLecturer(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This lecturer will be moved to trash!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
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
                        Swal.fire('Deleted!', 'Lecturer has been moved to trash.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to delete lecturer.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
{{-- @extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Lecturer Data</h5>
            <div>
                <a href="{{ route('lecturers.create') }}" class="btn btn-success">Add Lecturer</a>
            </div>
        </div>

        <div class="mb-3">
            <label for="statusFilter">Filter by Status</label>
            <select id="statusFilter" class="form-control select2">
                <option value="">All</option>
                <option value="active">Active</option>
                <option value="deleted">Deleted</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table styled-table" id="lecturers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/DataTables/custom.css') }}">
    <link href="{{ asset('assets/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('javascript')
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>

<script>
    // Initialize Select2
    $('#statusFilter').select2();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // DataTable initialization with filtering functionality
    var table = $('#lecturers').DataTable({
        responsive: true,
        serverSide: true,
        processing: true,
        paging: true,
        ajax: {
            url: '{{ route('lecturers.json') }}',
            type: 'POST',
            data: function (d) {
                d.status = $('#statusFilter').val();  // Send selected filter value
            }
        },
        columns: [{
            data: 'id'
        },
        {
            data: 'name'
        },
        {
            data: 'status'
        },
        {
            data: 'action',
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                let restoreButton = '';
                let forceDeleteButton = '';

                if (row.status === 'Deleted') {
                    restoreButton = `<button class="btn btn-warning btn-sm restore" data-id="${row.id}">Restore</button>`;
                    forceDeleteButton = `<button class="btn btn-danger btn-sm force-delete" data-id="${row.id}">Force Delete</button>`;
                } else {
                    restoreButton = '';
                    forceDeleteButton = '';
                }

                return `
                    <a href="{{ route( 'lecturers.edit', ':id' ) }}" class="btn btn-primary btn-sm me-2">Edit</a>
                    <button class="btn btn-danger btn-sm delete" data-id="${row.id}">Delete</button>
                    ${restoreButton}
                    ${forceDeleteButton}
                `.replace(/:id/g, row.id);
            }
        }]
    });

    // Event listener for delete button
    $(document).on('click', '.delete', function () {
        var lecturerId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this lecturer!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('lecturers.destroy', ':id') }}'.replace(':id', lecturerId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire('Deleted!', 'Lecturer has been deleted.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to delete lecturer.', 'error');
                    }
                });
            }
        });
    });

    // Event listener for restore button
    $(document).on('click', '.restore', function () {
        var lecturerId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This lecturer will be restored!',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('lecturers.restore', ':id') }}'.replace(':id', lecturerId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire('Restored!', 'Lecturer has been restored.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to restore lecturer.', 'error');
                    }
                });
            }
        });
    });

    // Event listener for force delete button
    // Event listener for force delete button
$(document).on('click', '.force-delete', function () {
    var lecturerId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: 'This lecturer will be permanently deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, force delete it!',
        cancelButtonText: 'No, keep it',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
    url: '{{ route('lecturers.:id.force-delete', ':id') }}'.replace(':id', lecturerId),
    type: 'DELETE',  // Method DELETE sesuai dengan rute
    data: {
        _token: '{{ csrf_token() }}',  // Pastikan CSRF token sudah ada
    },
    success: function(response) {
        table.ajax.reload();  // Reload DataTable
        Swal.fire('Deleted!', 'Lecturer has been permanently deleted.', 'success');
    },
    error: function(xhr) {
        console.error(xhr.responseText);  // Debug error response
        Swal.fire('Error!', 'Failed to permanently delete lecturer.', 'error');
    }
});

        }
    });
});


    // Re-filter table data when filter changes
    $('#statusFilter').change(function() {
        table.ajax.reload();
    });
</script>
@endpush --}}
