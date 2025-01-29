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
                        <th>Image</th>
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
                            <td>
                                <img src="{{ asset('storage/' . $lecturer->image) }}" width="50" class="rounded-circle">
                            </td>
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
