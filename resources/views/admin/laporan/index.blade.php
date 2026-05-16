<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan - Admin SIPES</title>
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

        /* Navbar */
        .navbar {
            background: var(--primary-green);
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        .navbar-brand i { margin-right: 10px; }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }
        .nav-link:hover, .nav-link.active { color: white !important; }
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .dropdown-item:hover {
            background-color: var(--soft-green);
            color: var(--dark-green);
        }

        /* Page Header */
        .page-header {
            background: white;
            padding: 2rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }
        .page-header h1 {
            color: var(--dark-green);
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        .page-header p { color: #6c757d; margin-bottom: 0; }

        /* Admin badge */
        .admin-badge {
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Filter card */
        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        /* Laporan card */
        .laporan-card {
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            border-left: 4px solid var(--accent-green);
            border-radius: 10px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .laporan-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .laporan-card.status-pending      { border-left-color: #ffc107; }
        .laporan-card.status-menunggu     { border-left-color: #ffc107; }
        .laporan-card.status-diproses     { border-left-color: #fd7e14; }
        .laporan-card.status-selesai      { border-left-color: #198754; }
        .laporan-card.status-ditolak      { border-left-color: #dc3545; }
        .laporan-card.status-diverifikasi { border-left-color: #0dcaf0; }

        /* Status badge */
        .status-badge {
            font-weight: 600;
            padding: 0.4rem 0.75rem;
            border-radius: 50rem;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }

        /* Pelapor info */
        .pelapor-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--soft-green);
            color: var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        /* Foto laporan */
        .laporan-photo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(0,0,0,0.1);
        }

        /* Status dropdown form */
        .status-form .form-select {
            font-size: 0.85rem;
            border-color: var(--accent-green);
            color: var(--primary-green);
            font-weight: 500;
            cursor: pointer;
        }
        .status-form .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(45,106,79,0.15);
        }
        .status-form .btn-update {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
            font-size: 0.85rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .status-form .btn-update:hover {
            background: var(--dark-green);
            border-color: var(--dark-green);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 3.5rem;
            color: #ced4da;
            margin-bottom: 1rem;
        }

        /* Pagination */
        .page-link { color: var(--primary-green); }
        .page-item.active .page-link {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        /* Stats bar */
        .stats-row .stat-pill {
            background: white;
            border-radius: 50px;
            padding: 0.4rem 1rem;
            font-size: 0.82rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
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
                        <a class="nav-link active" href="{{ route('admin.laporan.index') }}">
                            <i class="fas fa-tasks me-1"></i>Kelola Laporan
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto" class="rounded-circle me-2" style="width:30px;height:30px;object-fit:cover;">
                            @else
                                <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center me-2" style="width:30px;height:30px;font-weight:bold;">
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
    <div class="page-header">
        <div class="container">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h1 class="mb-1"><i class="fas fa-tasks me-2"></i>Kelola Laporan</h1>
                    <p>Ubah status laporan yang masuk dari masyarakat.</p>
                </div>
                <span class="admin-badge ms-auto"><i class="fas fa-shield-alt me-1"></i>Admin</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container pb-5">

        {{-- Flash message --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Filter status --}}
        <div class="filter-card">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-2 align-items-center">
                <div class="col-auto">
                    <label class="col-form-label fw-semibold text-muted small">
                        <i class="fas fa-filter me-1"></i>Filter Status:
                    </label>
                </div>
                <div class="col-auto">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending"      {{ request('status') === 'pending'      ? 'selected' : '' }}>Menunggu (pending)</option>
                        <option value="diproses"     {{ request('status') === 'diproses'     ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai"      {{ request('status') === 'selesai'      ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak"      {{ request('status') === 'ditolak'      ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                @if(request('status'))
                <div class="col-auto">
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
                @endif
                <div class="col-auto ms-auto">
                    <small class="text-muted">
                        <i class="fas fa-clipboard-list me-1"></i>
                        <strong>{{ $reports->total() }}</strong> laporan ditemukan
                    </small>
                </div>
            </form>
        </div>

        {{-- Daftar laporan --}}
        @if($reports->isEmpty())
            <div class="empty-state">
                <i class="fas fa-clipboard-list d-block"></i>
                <h5 class="mt-2">Tidak ada laporan</h5>
                <p class="mb-0">Belum ada laporan yang masuk atau sesuai filter.</p>
            </div>
        @else
            @foreach($reports as $report)
                @php
                    $statusConfig = [
                        'pending'      => ['class' => 'bg-warning text-dark',  'label' => 'Menunggu',     'key' => 'pending'],
                        'menunggu'     => ['class' => 'bg-warning text-dark',  'label' => 'Menunggu',     'key' => 'menunggu'],
                        'diproses'     => ['class' => 'text-white',            'label' => 'Diproses',     'key' => 'diproses', 'style' => 'background:#fd7e14;'],
                        'selesai'      => ['class' => 'bg-success text-white', 'label' => 'Selesai',      'key' => 'selesai'],
                        'ditolak'      => ['class' => 'bg-danger text-white',  'label' => 'Ditolak',      'key' => 'ditolak'],
                        'diverifikasi' => ['class' => 'bg-info text-white',    'label' => 'Diverifikasi', 'key' => 'diverifikasi'],
                    ];
                    $sc = $statusConfig[$report->status] ?? $statusConfig['pending'];
                @endphp
                <div class="laporan-card status-{{ $sc['key'] }}">
                    <div class="row align-items-start g-3">

                        {{-- Foto laporan --}}
                        @if($report->photo_path)
                        <div class="col-auto">
                            <img src="{{ asset('storage/' . $report->photo_path) }}"
                                 alt="Foto Laporan"
                                 class="laporan-photo">
                        </div>
                        @endif

                        {{-- Info laporan --}}
                        <div class="col">
                            {{-- Baris atas: status + tanggal --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="status-badge {{ $sc['class'] }}"
                                      @if(isset($sc['style'])) style="{{ $sc['style'] }}" @endif>
                                    {{ $sc['label'] }}
                                </span>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $report->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>

                            {{-- Deskripsi --}}
                            <p class="fw-semibold mb-1" style="color: var(--dark-green);">
                                {{ Str::limit($report->description, 100) }}
                            </p>

                            {{-- Lokasi --}}
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $report->location }}
                                </small>
                            </div>

                            {{-- Pelapor --}}
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="pelapor-avatar">
                                    {{ strtoupper(substr($report->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:0.88rem;">
                                        {{ $report->user->name ?? 'Tidak diketahui' }}
                                    </div>
                                    <div class="text-muted" style="font-size:0.78rem;">
                                        {{ $report->user->email ?? '' }}
                                    </div>
                                </div>
                                <span class="badge bg-secondary ms-1" style="font-size:0.7rem;">Pelapor</span>
                            </div>

                            {{-- Form ubah status --}}
                            <form method="POST"
                                  action="{{ route('admin.laporan.updateStatus', $report->id) }}"
                                  class="status-form d-flex align-items-center gap-2 flex-wrap">
                                @csrf
                                @method('PATCH')
                                <label class="text-muted small fw-semibold mb-0">
                                    <i class="fas fa-edit me-1"></i>Ubah Status:
                                </label>
                                <select name="status" class="form-select form-select-sm" style="width:auto; min-width:160px;">
                                    <option value="pending"   {{ $report->status === 'pending'   ? 'selected' : '' }}>Menunggu</option>
                                    <option value="diproses"  {{ $report->status === 'diproses'  ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai"   {{ $report->status === 'selesai'   ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak"   {{ $report->status === 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-update" id="btn-update-{{ $report->id }}">
                                    <i class="fas fa-save me-1"></i>Simpan
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $reports->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
