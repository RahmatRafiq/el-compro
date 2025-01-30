@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Virtual Content</h5>
            <div>
                <a href="{{ route('virtuals.create') }}" class="btn btn-success">Add Virtual</a>
            </div>
        </div>

        <div class="mb-3 mt-3 d-flex justify-content-end">
            <label for="filter" class="form-label me-2">Filter Content</label>
            <select id="filter" class="form-select w-auto">
                <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Active</option>
                <option value="trashed" {{ $filter == 'trashed' ? 'selected' : '' }}>Deleted</option>
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table styled-table" id="virtuals">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>URL</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($virtuals as $virtual)
                        <tr>
                            <td>{{ $virtual->id }}</td>
                            <td>{{ $virtual->name }}</td>
                            <td>{{ $virtual->category->name }}</td>
                            <td><a href="{{ $virtual->url_embed }}" target="_blank">View</a></td>
                            <td>
                                @if ($virtual->deleted_at)
                                    <span class="badge bg-danger">Deleted</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>
                                @if ($virtual->deleted_at)
                                    <form action="{{ route('virtuals.restore', $virtual->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                                    </form>
                                    <form action="{{ route('virtuals.forceDelete', $virtual->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete permanently?')">Delete Permanently</button>
                                    </form>
                                @else
                                    <a href="{{ route('virtuals.edit', $virtual->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteVirtual({{ $virtual->id }})">Delete</button>
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
        $('#virtuals').DataTable();

        // Initialize Select2 for the filter
        $('#filter').select2({
            placeholder: "Filter Content",
            allowClear: true
        });

        // On change of the filter, reload the page with the selected filter
        $('#filter').change(function() {
            let filter = $(this).val();
            window.location.href = `{{ route('virtuals.index') }}?filter=${filter}`;
        });
    });

    function deleteVirtual(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This content will be moved to trash!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('virtuals.destroy', ':id') }}`.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        window.location.reload();
                        Swal.fire('Deleted!', 'Content has been moved to trash.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to delete content.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
