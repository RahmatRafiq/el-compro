@extends('layouts.app')

@section('content')
<!-- Welcome Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-1">👋 Selamat Datang, {{ auth()->user()->name }}!</h2>
                        <p class="mb-0 opacity-75">Berikut adalah ringkasan aktivitas sistem hari ini</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="text-white-50">
                            <i class="bi bi-calendar-event fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-muted small">Total Artikel</div>
                        <div class="fs-3 fw-bold text-primary">{{ $total_articles }}</div>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> {{ $articles_this_month }} bulan ini
                        </small>
                    </div>
                    <div class="col-auto">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-muted small">Total Mata Kuliah</div>
                        <div class="fs-3 fw-bold text-success">{{ $total_courses }}</div>
                        <small class="text-info">
                            <i class="bi bi-star-fill"></i> {{ number_format($total_credits) }} SKS Total
                        </small>
                    </div>
                    <div class="col-auto">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-mortarboard text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-muted small">Total Dosen</div>
                        <div class="fs-3 fw-bold text-warning">{{ $total_lecturers }}</div>
                        <small class="text-primary">
                            <i class="bi bi-check-circle"></i> {{ $lecturers_with_courses }} aktif mengajar
                        </small>
                    </div>
                    <div class="col-auto">
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-people text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-muted small">Virtual Tours</div>
                        <div class="fs-3 fw-bold text-info">{{ $total_virtual_tours }}</div>
                        <small class="text-success">
                            <i class="bi bi-plus-circle"></i> {{ $virtual_tours_this_month }} bulan ini
                        </small>
                    </div>
                    <div class="col-auto">
                        <div class="bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-camera-reels text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Views and Users Row -->
<div class="row g-3 mb-4">
    <div class="col-xl-6 col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-3">📊 Statistik Pengunjung</h6>
                <div class="row text-center">
                    <div class="col-4">
                        <div class="border-end">
                            <div class="fs-4 fw-bold text-primary">{{ number_format($total_views) }}</div>
                            <small class="text-muted">Total Views</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border-end">
                            <div class="fs-4 fw-bold text-success">{{ $total_users }}</div>
                            <small class="text-muted">Total Users</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="fs-4 fw-bold text-info">{{ $users_this_month }}</div>
                        <small class="text-muted">User Baru</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-3">🎯 Konsentrasi Mata Kuliah</h6>
                <div class="row">
                    @foreach($courses_by_concentration as $concentration)
                        <div class="col-6 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ ucwords(str_replace('_', ' ', $concentration->major_concentration)) }}</small>
                                <span class="badge bg-primary">{{ $concentration->count }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Statistics and System Info -->

<!-- Charts and Tables Row -->
<div class="row g-3 mb-4">
    <!-- Articles Chart -->
    <div class="col-xl-6 col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0">📈 Artikel Populer</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th class="text-center">Views</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($popular_articles as $article)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                                <i class="bi bi-file-earmark-text text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ Str::limit($article->title, 30) }}</div>
                                                <small class="text-muted">
                                                    {{ $article->created_at ? $article->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">{{ number_format($article->view_count) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-success">
                                            <i class="bi bi-check-circle"></i> Aktif
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye"></i> Lihat Semua Artikel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Lecturers -->
    <div class="col-xl-6 col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0">👨‍🏫 Dosen Terpopuler</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Dosen</th>
                                <th class="text-center">Mata Kuliah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($top_lecturers as $lecturer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                                                <i class="bi bi-person text-warning"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $lecturer->name }}</div>
                                                <small class="text-muted">Dosen Aktif</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $lecturer->courses_count }}</span>
                                    </td>
                                  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('lecturers.index') }}" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-people"></i> Lihat Semua Dosen
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0">🕐 Aktivitas Terkini</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Recent Articles -->
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted mb-3">Artikel Terbaru</h6>
                        @foreach($recent_activity['articles'] as $article)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                    <i class="bi bi-file-earmark-text text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium small">{{ Str::limit($article->title, 25) }}</div>
                                    <small class="text-muted">
                                        {{ $article->created_at ? $article->created_at->diffForHumans() : 'Tanggal tidak tersedia' }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Recent Courses -->
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted mb-3">Mata Kuliah Terbaru</h6>
                        @foreach($recent_activity['courses'] as $course)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                                    <i class="bi bi-mortarboard text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium small">{{ Str::limit($course->name, 25) }}</div>
                                    <small class="text-muted">
                                        {{ $course->created_at ? $course->created_at->diffForHumans() : 'Tanggal tidak tersedia' }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Recent Virtual Tours -->
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted mb-3">Virtual Tours Terbaru</h6>
                        @foreach($recent_activity['virtual_tours'] as $tour)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                                    <i class="bi bi-camera-reels text-info"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium small">{{ Str::limit($tour->name, 25) }}</div>
                                    <small class="text-muted">
                                        {{ $tour->created_at ? $tour->created_at->diffForHumans() : 'Tanggal tidak tersedia' }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0">⚡ Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('articles.create') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle"></i><br>
                            <small>Buat Artikel</small>
                        </a>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('courses.create') }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-plus-circle"></i><br>
                            <small>Tambah Mata Kuliah</small>
                        </a>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('lecturers.create') }}" class="btn btn-outline-warning w-100">
                            <i class="bi bi-plus-circle"></i><br>
                            <small>Tambah Dosen</small>
                        </a>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('virtuals.create') }}" class="btn btn-outline-info w-100">
                            <i class="bi bi-plus-circle"></i><br>
                            <small>Buat Virtual Tour</small>
                        </a>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('categories.create') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-plus-circle"></i><br>
                            <small>Tambah Kategori</small>
                        </a>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('user.index') }}" class="btn btn-outline-dark w-100">
                            <i class="bi bi-gear"></i><br>
                            <small>Kelola User</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add some interactivity
document.addEventListener('DOMContentLoaded', function() {
    // Animate numbers on load
    const numbers = document.querySelectorAll('.fs-3');
    numbers.forEach(number => {
        const finalValue = parseInt(number.textContent.replace(/,/g, ''));
        if (!isNaN(finalValue)) {
            animateNumber(number, finalValue);
        }
    });
});

function animateNumber(element, finalValue) {
    const duration = 1000;
    const startValue = 0;
    const increment = finalValue / (duration / 16);
    let currentValue = startValue;
    
    const timer = setInterval(() => {
        currentValue += increment;
        if (currentValue >= finalValue) {
            currentValue = finalValue;
            clearInterval(timer);
        }
        element.textContent = Math.floor(currentValue).toLocaleString();
    }, 16);
}
</script>
@endsection
