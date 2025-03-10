@extends('layouts.app')

@section('content')
<div class="row gx-3">
    <div class="col-xl-3 col-sm-6 col-12">
        <a href="{{ route('articles.index') }}" class="text-decoration-none">
            <div class="card mb-3 card-custom background-gradient-1">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-file-earmark-text fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Total Artikel</h5>
                        <h3 class="m-0 text-white">{{ $total_articles }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <a href="{{ route('courses.index') }}" class="text-decoration-none">
            <div class="card mb-3 card-custom background-gradient-2">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-mortarboard fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Total Kursus</h5>
                        <h3 class="m-0 text-white">{{ $total_courses }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <a href="{{ route('lecturers.index') }}" class="text-decoration-none">
            <div class="card mb-3 card-custom background-gradient-3">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-people fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Total Dosen</h5>
                        <h3 class="m-0 text-white">{{ $total_lecturers }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <a href="{{ route('virtuals.index') }}" class="text-decoration-none">
            <div class="card mb-3 card-custom background-gradient-4">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-camera-reels fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Total Virtual Tours</h5>
                        <h3 class="m-0 text-white">{{ $total_virtual_tours }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row gx-3">
    <div class="col-xl-6">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Artikel Populer</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($popular_articles as $article)
                            <tr>
                                <td><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></td>
                                <td>{{ $article->view_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Kategori Virtual Populer</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Tours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($popular_virtual_categories as $category)
                            <tr>
                                <td><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></td>
                                <td>{{ $category->virtuals_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
