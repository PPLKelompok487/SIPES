<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - SIPES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #2d6a4f;
            --accent-green: #52b788;
            --soft-green: #d8f3dc;
            --dark-green: #1b4332;
            --light-green: #95d5b2;
            --bg-color: #f4f7f6;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: #333;
        }

        /* Navbar Styles */
        .navbar {
            background: var(--primary-green);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: white !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .dropdown-item:hover {
            background-color: var(--soft-green);
            color: var(--dark-green);
        }

        /* Page Header */
        .dashboard-header {
            background: white;
            padding: 2rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }

        .dashboard-title {
            color: var(--dark-green);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .dashboard-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* Container card */
        .laporan-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 1.5rem;
        }

        /* Per-laporan card */
        .laporan-card {
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            border-left: 4px solid var(--accent-green);
            border-radius: 10px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .laporan-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .laporan-card.status-menunggu     { border-left-color: #ffc107; }
        .laporan-card.status-diverifikasi { border-left-color: #0dcaf0; }
        .laporan-card.status-diproses     { border-left-color: #fd7e14; }
        .laporan-card.status-selesai      { border-left-color: #198754; }
        .laporan-card.status-ditolak      { border-left-color: #dc3545; }

        .laporan-card .badge {
            font-weight: 600;
            padding: 0.4rem 0.7rem;
            border-radius: 50rem;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }

        .laporan-card h6 {
            color: var(--dark-green);
            font-size: 1.05rem;
        }

        .laporan-card .meta-row {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .laporan-card .btn-outline-success {
            border-color: var(--accent-green);
            color: var(--primary-green);
        }

        .laporan-card .btn-outline-success:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* Pagination */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: var(--primary-green);
        }

        .page-item.active .page-link {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-leaf"></i>
                SIPES
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">Daftar Laporan</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-weight: bold;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user-circle me-2"></i>Kelola Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1 class="dashboard-title">Daftar Laporan Sampah</h1>
            <p class="dashboard-subtitle">Berikut adalah laporan sampah yang telah dibuat.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container pb-5">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Filter & Search Section -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="card-body p-4">
                <form action="{{ route('laporan.index') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold text-muted small">CARI LAPORAN</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Cari deskripsi atau lokasi..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted small">STATUS</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-grid w-100 gap-2 d-md-flex">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            @if(request()->anyFilled(['search', 'status']))
                                <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="laporan-container">

            <!-- Card header row -->
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <small class="text-muted">
                    <i class="fas fa-clipboard-list me-1"></i>
                    {{ $laporans->total() }} Laporan ditemukan
                </small>
                @if(Auth::user()->role === 'pelapor')
                <a href="{{ route('reports.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus me-1"></i> Buat Laporan
                </a>
                @endif
            </div>

            @if($laporans->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <p>Belum ada laporan.</p>
                </div>
            @else
                @foreach($laporans as $laporan)
                    @php
                        $statusMap = [
                            'pending'      => ['class' => 'bg-warning text-dark',  'label' => 'Menunggu',     'style' => '', 'key' => 'menunggu'],
                            'menunggu'     => ['class' => 'bg-warning text-dark',  'label' => 'Menunggu',     'style' => '', 'key' => 'menunggu'],
                            'diverifikasi' => ['class' => 'bg-info text-white',    'label' => 'Diverifikasi', 'style' => '', 'key' => 'diverifikasi'],
                            'diproses'     => ['class' => 'text-white',            'label' => 'Diproses',     'style' => 'background:#fd7e14;', 'key' => 'diproses'],
                            'selesai'      => ['class' => 'bg-success text-white', 'label' => 'Selesai',      'style' => '', 'key' => 'selesai'],
                            'ditolak'      => ['class' => 'bg-danger text-white',  'label' => 'Ditolak',      'style' => '', 'key' => 'ditolak'],
                        ];
                        $s = $statusMap[$laporan->status] ?? $statusMap['menunggu'];
                        $heading = \Illuminate\Support\Str::limit($laporan->description, 70);
                    @endphp

                    <div class="laporan-card status-{{ $s['key'] }}">
                        <div class="row align-items-center">
                            @if($laporan->photo_path)
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <img src="{{ asset('storage/' . $laporan->photo_path) }}" alt="Foto Laporan" class="img-fluid rounded shadow-sm" style="max-height: 120px; object-fit: cover; border: 1px solid rgba(0,0,0,0.1);">
                            </div>
                            @endif
                            <div class="col-md-{{ $laporan->photo_path ? '9' : '12' }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge {{ $s['class'] }}" @if($s['style']) style="{{ $s['style'] }}" @endif>
                                        {{ $s['label'] }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $laporan->created_at->format('d M Y') }}
                                    </small>
                                </div>

                                <h6 class="fw-bold mb-1">{{ $heading }}</h6>

                                <div class="meta-row mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $laporan->location }}
                                    </small>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-outline-success">
                                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center mt-4">
                    {{ $laporans->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
