@extends('layouts.app')

@section('content')
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Tambah Artikel</h5>
                </div>
                <div class="card-body">
                    <form id="article-form" action="{{ route('articles.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select id="category-select" name="category_id" class="form-select">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Konten</label>
                            <textarea class="form-control" name="content" rows="5" id="content"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Gambar Artikel</label>
                            <div class="dropzone" id="myDropzone"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('articles.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('assets/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('head')
    @vite(['resources/js/dropzoner.js'])
    <script src="{{ asset('assets/vendor/toastify/toastify.js') }}"></script>
@endpush

@push('javascript')
    <script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>

    <script>
        let editorInstance;

        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                editorInstance = editor;
            })
            .catch(error => {
                console.error(error);
            });

        $(document).ready(function () {
            $('#category-select').select2({
                placeholder: "Pilih Kategori",
                allowClear: true
            });
        });

        document.querySelector("#article-form").addEventListener("submit", function (e) {
            const editorData = editorInstance.getData().trim();
            if (!editorData) {
                alert("Konten wajib diisi!");
                e.preventDefault();
            }
        });
    </script>

    <script type="module">
        const element = '#myDropzone';
        const key = 'article-image';
        const files = [];
        const urlStore = "{!! route('storage.store') !!}";
        const urlDestroy = "{!! route('articles.deleteFile') !!}";
        const csrf = "{!! csrf_token() !!}";
        const acceptedFiles = 'image/*';
        const maxFiles = 1;

        @if ($articleImage)
            files.push({
                id: '{{ $articleImage->id }}',
                name: '{{ $articleImage->name }}',
                file_name: '{{ $articleImage->file_name }}',
                size: '{{ $articleImage->size }}',
                type: '{{ $articleImage->type }}',
                url: '{{ $articleImage->url }}',
                original_url: '{{ $articleImage->original_url }}',
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
            document.querySelector('#article-form').appendChild(input);
        });
    </script>
@endpush