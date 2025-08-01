@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Buat Role Baru</h5>
            </div>
            <form action="{{ route('role.store') }}" method="POST">
                @csrf

                <div class="col-xxl-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Role</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="mb-3">
                                <label for="guard_name" class="form-label">Nama Guard</label>
                                <select class="form-select" id="guard_name" name="guard_name">
                                    <option value="">Pilih Nama Guard</option>
                                    @foreach (App\Helpers\Guards::list() as $guard_name)
                                        <option value="{{ $guard_name }}" {{ old('guard_name') == $guard_name ? 'selected' : '' }}>
                                            {{ $guard_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Buat Role</button>
            </form>
        </div>
    </div>
@endsection
