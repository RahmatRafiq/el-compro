@extends('layouts.app')

@section('content')
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Add Lecturer</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('lecturers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Lecturer Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="about" class="form-label">About</label>
                            <textarea class="form-control" name="about" id="about"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="courses" class="form-label">Assign Courses</label>
                            <select id="courses-select" name="courses[]" class="form-select" multiple="multiple">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Lecturer Image</label>
                            <div class="dropzone" id="myDropzone"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Cancel</a>
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
    <script>
        $(document).ready(function () {
            $('#courses-select').select2({
                placeholder: "Select Courses",
                allowClear: true
            });
        });
    </script>

    <script type="module">
        const element = '#myDropzone';
        const key = 'lecturer-image';
        const files = [];
        const urlStore = "{!! route('storage.store') !!}";
        const urlDestroy = "{!! route('lecturers.deleteFile') !!}";
        const csrf = "{!! csrf_token() !!}";
        const acceptedFiles = 'image/*';
        const maxFiles = 3;

        @if ($lecturerImage)
            files.push({
                id: '{{ $lecturerImage->id }}',
                name: '{{ $lecturerImage->name }}',
                file_name: '{{ $lecturerImage->file_name }}',
                size: '{{ $lecturerImage->size }}',
                type: '{{ $lecturerImage->mime_type }}',
                url: '{{ $lecturerImage->getUrl() }}',
                original_url: '{{ $lecturerImage->getFullUrl() }}',
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
            document.querySelector('form').appendChild(input);
        });

    </script>
@endpush