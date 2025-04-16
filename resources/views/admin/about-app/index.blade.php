@extends('layouts.app')

@section('content')
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Tentang Aplikasi</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="about-app-form"
                        action="{{ $aboutApp ? route('about-app.update', $aboutApp->id) : route('about-app.store') }}"
                        method="POST">
                        @csrf
                        @if ($aboutApp)
                            @method('PUT')
                        @endif

                        <div class="form-group row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Nama Prodi</label>
                            <div class="col-md-8">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" value="{{ old('title', $aboutApp->title ?? '') }}" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Deskripsi</label>
                            <div class="col-md-8">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                    name="description" rows="5"
                                    required>{{ old('description', $aboutApp->description ?? '') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="greeting" class="col-md-4 col-form-label text-md-right">Sekapur Sirih</label>
                            <div class="col-md-8">
                                <textarea id="greeting" class="form-control @error('greeting') is-invalid @enderror"
                                    name="greeting" rows="3">{{ old('greeting', $aboutApp->greeting ?? '') }}</textarea>
                                @error('greeting')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="mission" class="col-md-4 col-form-label text-md-right">Visi-Misi</label>
                            <div class="col-md-8">
                                <textarea id="mission" class="form-control @error('mission') is-invalid @enderror"
                                    name="mission" rows="3">{{ old('mission', $aboutApp->vision_mission ?? '') }}</textarea>
                                @error('mission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="history" class="col-md-4 col-form-label text-md-right">Sejarah</label>
                            <div class="col-md-8">
                                <textarea id="history" class="form-control @error('history') is-invalid @enderror"
                                    name="history" rows="3">{{ old('history', $aboutApp->history ?? '') }}</textarea>
                                @error('history')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="contact_email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-8">
                                <input id="contact_email" type="email"
                                    class="form-control @error('contact_email') is-invalid @enderror" name="contact_email"
                                    value="{{ old('contact_email', $aboutApp->contact_email ?? '') }}">
                                @error('contact_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="contact_phone" class="col-md-4 col-form-label text-md-right">Telepon</label>
                            <div class="col-md-8">
                                <input id="contact_phone" type="text"
                                    class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone"
                                    value="{{ old('contact_phone', $aboutApp->contact_phone ?? '') }}">
                                @error('contact_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="contact_address" class="col-md-4 col-form-label text-md-right">Alamat</label>
                            <div class="col-md-8">
                                <input id="contact_address" type="text"
                                    class="form-control @error('contact_address') is-invalid @enderror"
                                    name="contact_address"
                                    value="{{ old('contact_address', $aboutApp->contact_address ?? '') }}">
                                @error('contact_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="images" class="col-md-4 col-form-label text-md-right">
                                Struktur Organisasi
                                @if (isset($strukturOrganisasi) && $strukturOrganisasi)
                                    <a href="{{ $strukturOrganisasi->url }}" target="_blank"
                                        class="btn btn-sm btn-primary">Lihat</a>
                                @endif
                            </label>
                            <div class="col-md-8">
                                <div class="dropzone" id="myDropzone"></div>
                                @error('images')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $aboutApp ? 'Update' : 'Save' }}
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
        const key = 'struktur-organisasi';
        const files = [];
        const urlStore = "{!! route('storage.store') !!}";
        const urlDestroy = "{!! route('aboutApp.deleteFile') !!}";
        const csrf = "{!! csrf_token() !!}";
        const acceptedFiles = 'image/*';
        const maxFiles = 1;

        @if ($strukturOrganisasi)
            files.push({
                id: '{{ $strukturOrganisasi->id }}',
                name: '{{ $strukturOrganisasi->name }}',
                file_name: '{{ $strukturOrganisasi->file_name }}',
                size: '{{ $strukturOrganisasi->size }}',
                type: '{{ $strukturOrganisasi->type }}',
                url: '{{ $strukturOrganisasi->url }}',
                original_url: '{{ $strukturOrganisasi->original_url }}',
            });
        @endif

                    const dz = Dropzoner(
            element,
            key,
            {
                urlStore,
                urlDestroy,
                acceptedFiles,
                files,
                maxFiles,
                kind: 'image',
                csrf,
            }
        );

        dz.on("success", function (file, response) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'images[]';
            input.value = response.path;
            document.querySelector('#about-app-form').appendChild(input);
        });
    </script>
@endpush