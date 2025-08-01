@extends('layouts.app')

@section('content')
<div class="row gx-3">
    <!-- Kartu Update Profil -->
    <div class="col-xxl-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Perbarui Profil</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- Input Nama -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Input Email -->
                    <div class="form-group row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Alamat Email') }}</label>
                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Dropzone untuk Gambar Profil -->
                    <div class="form-group row mb-3">
                        <label for="images" class="col-md-4 col-form-label text-md-right">Gambar Profil</label>
                        <div class="col-md-8">
                            <div class="dropzone" id="myDropzone"></div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group row mb-3">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Perbarui Profil') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kartu Update Password -->
    <div class="col-xxl-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Perbarui Kata Sandi</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row mb-3">
                        <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Kata Sandi Saat Ini') }}</label>
                        <div class="col-md-8">
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   name="current_password" required autocomplete="current-password">
                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Kata Sandi Baru') }}</label>
                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Konfirmasi Kata Sandi') }}</label>
                        <div class="col-md-8">
                            <input id="password_confirmation" type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group row mb-3">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Perbarui Kata Sandi') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kartu Hapus Akun -->
    <div class="col-xxl-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Hapus Akun</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="form-group row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Kata Sandi') }}</label>
                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group row mb-3">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-danger">
                                {{ __('Hapus Akun') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('head')
    @vite(['resources/js/dropzoner.js'])
    <script src="{{ asset('assets/vendor/toastify/toastify.js') }}"></script>
@endpush

@push('javascript')
<script type="module">
    const element = '#myDropzone';
    const key = 'profile-images';
    const files = [];
    const urlStore = "{!! route('storage.store') !!}";
    const urlDestroy = "{!! route('profile.deleteFile') !!}";
    const csrf = "{!! csrf_token() !!}";
    const acceptedFiles = 'image/*';
    const maxFiles = 3;

    // Tambahkan file yang sudah ada jika ada
    @if($profileImage)
        files.push({
            id: '{{ $profileImage->id }}',
            name: '{{ $profileImage->name }}',
            file_name: '{{ $profileImage->file_name }}',
            size: '{{ $profileImage->size }}',
            type: '{{ $profileImage->mime_type }}',
            url: '{{ $profileImage->getUrl() }}',
            original_url: '{{ $profileImage->getFullUrl() }}',
        });
    @endif

    const dz = Dropzoner(
        element,
        key,
        {
            urlStore,
            urlDestroy,
            csrf,
            acceptedFiles,
            files,
            maxFiles,
            kind: 'image',
        }
    );

    dz.on("success", function(file, response) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'images[]';
        input.value = response.path;
        document.querySelector('form').appendChild(input);
    });
</script>
@endpush
