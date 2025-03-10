@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Articles</h5>
            <div>
                <a href="{{ route('articles.create') }}" class="btn btn-success">Add Article</a>
            </div>
        </div>

        <div class="mb-3 mt-3 d-flex justify-content-end">
            <label for="filter" class="form-label me-2">Filter Articles</label>
            <select id="filter" class="form-select w-auto">
                <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Active Articles</option>
                <option value="trashed" {{ $filter == 'trashed' ? 'selected' : '' }}>Deleted Articles</option>
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Articles</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table styled-table" id="articles">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>
                                @if ($article->deleted_at)
                                    <span class="badge bg-danger">Deleted</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>
                                @if ($article->deleted_at)
                                    <form action="{{ route('articles.restore', $article->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                                    </form>
                                    <form action="{{ route('articles.forceDelete', $article->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete permanently?')">Delete Permanently</button>
                                    </form>
                                @else
                                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteArticle({{ $article->id }})">Delete</button>
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
        $('#articles').DataTable();

        $('#filter').select2({
            placeholder: "Filter Articles",
            allowClear: true
        });

        $('#filter').change(function() {
            let filter = $(this).val();
            window.location.href = `{{ route('articles.index') }}?filter=${filter}`;
        });
    });

    function deleteArticle(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This article will be moved to trash!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('articles.destroy', ':id') }}`.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        window.location.reload();
                        Swal.fire('Deleted!', 'Article has been moved to trash.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to delete article.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
