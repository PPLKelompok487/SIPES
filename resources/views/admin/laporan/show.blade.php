<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #{{ $report->id }} - Admin SIPES</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary:    #2d6a4f;
            --primary-dk: #1b4332;
            --accent:     #52b788;
            --soft:       #d8f3dc;
            --bg:         #f0f4f1;
            --card-bg:    #ffffff;
            --text:       #1e2d23;
            --muted:      #6b7c72;
            --border:     #e4ece7;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Navbar ───────────────────────────────── */
        .navbar {
            background: var(--primary);
            box-shadow: 0 2px 12px rgba(0,0,0,.12);
            padding: .85rem 0;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: .3px;
        }
        .navbar-brand i { margin-right: 8px; color: var(--accent); }
        .nav-link { color: rgba(255,255,255,.75) !important; font-weight: 500; padding: .4rem .9rem !important; border-radius: 6px; transition: all .2s; }
        .nav-link:hover, .nav-link.active { color: #fff !important; background: rgba(255,255,255,.12); }
        .dropdown-menu { border: none; border-radius: 12px; box-shadow: 0 8px 28px rgba(0,0,0,.12); padding: .5rem; }
        .dropdown-item { border-radius: 8px; padding: .5rem .9rem; font-size: .9rem; }
        .dropdown-item:hover { background: var(--soft); color: var(--primary); }

        /* ── Page Header ──────────────────────────── */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, #40916c 100%);
            padding: 2rem 0 3.5rem;
            margin-bottom: -1.8rem;
        }
        .page-header h1 { color: #fff; font-weight: 700; font-size: 1.6rem; margin-bottom: .25rem; }
        .page-header p  { color: rgba(255,255,255,.75); margin: 0; font-size: .95rem; }
        .admin-pill {
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.3);
            color: #fff;
            padding: .3rem .85rem;
            border-radius: 50px;
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .5px;
            backdrop-filter: blur(4px);
        }

        /* ── Breadcrumb ───────────────────────────── */
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        .breadcrumb-custom a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            font-size: .9rem;
        }
        .breadcrumb-custom a:hover { text-decoration: underline; }
        .breadcrumb-custom .separator {
            color: var(--muted);
            margin: 0 .5rem;
            font-size: .85rem;
        }
        .breadcrumb-custom .current {
            color: var(--muted);
            font-size: .9rem;
            font-weight: 500;
        }

        /* ── Detail Card ─────────────────────────── */
        .detail-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
            overflow: hidden;
        }
        .detail-card-header {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .detail-card-header .title {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--primary-dk);
        }
        .detail-card-body {
            padding: 1.5rem;
        }

        /* ── Photo ────────────────────────────────── */
        .photo-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
            cursor: pointer;
            transition: transform .2s;
        }
        .photo-container:hover { transform: scale(1.01); }
        .photo-container img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            display: block;
        }
        .photo-overlay {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,.5));
            padding: .8rem 1rem;
            color: #fff;
            font-size: .82rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .photo-placeholder {
            width: 100%;
            height: 250px;
            border-radius: 12px;
            background: var(--soft);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 3rem;
            border: 1px solid var(--border);
        }

        /* ── Info Sections ────────────────────────── */
        .info-section { margin-bottom: 1.5rem; }
        .info-label {
            font-size: .78rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: .4rem;
        }
        .info-value {
            font-size: .95rem;
            color: var(--text);
            line-height: 1.6;
        }

        /* ── Pelapor Card ─────────────────────────── */
        .pelapor-card {
            background: var(--soft);
            border-radius: 12px;
            padding: 1rem 1.2rem;
            display: flex;
            align-items: center;
            gap: .8rem;
        }
        .pelapor-avatar {
            width: 42px; height: 42px; border-radius: 50%;
            background: var(--primary); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: .95rem; font-weight: 700; flex-shrink: 0;
        }
        .pelapor-info .name { font-weight: 600; font-size: .92rem; color: var(--primary-dk); }
        .pelapor-info .email { font-size: .82rem; color: var(--muted); }

        /* ── Status Badge ─────────────────────────── */
        .sbadge {
            font-size: .75rem; font-weight: 700;
            padding: .3rem .8rem; border-radius: 50px;
            letter-spacing: .3px; display: inline-block;
        }
        .sbadge-pending, .sbadge-menunggu { background: #fef3c7; color: #92400e; }
        .sbadge-diproses     { background: #ffedd5; color: #9a3412; }
        .sbadge-selesai      { background: #dcfce7; color: #14532d; }
        .sbadge-ditolak      { background: #fee2e2; color: #7f1d1d; }
        .sbadge-diverifikasi { background: #e0f2fe; color: #0c4a6e; }

        /* ── Buttons ──────────────────────────────── */
        .btn-back {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            color: var(--text);
            font-weight: 600;
            font-size: .88rem;
            padding: .5rem 1.2rem;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            transition: all .2s;
        }
        .btn-back:hover { border-color: var(--accent); color: var(--primary); background: #fafcfb; }

        .btn-save-status {
            background: var(--primary); border: none; color: #fff;
            font-size: .85rem; font-weight: 600; padding: .5rem 1.2rem;
            border-radius: 10px; cursor: pointer; transition: background .2s, transform .1s;
            font-family: 'Inter', sans-serif;
        }
        .btn-save-status:hover { background: var(--primary-dk); }
        .btn-save-status:active { transform: scale(.96); }

        .btn-delete {
            background: #fee2e2; border: 1.5px solid #fecaca; color: #991b1b;
            font-size: .85rem; font-weight: 600; padding: .5rem 1.2rem;
            border-radius: 10px; cursor: pointer; transition: all .2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-delete:hover { background: #fca5a5; border-color: #f87171; color: #7f1d1d; }

        .sel-status {
            border: 1.5px solid var(--border); border-radius: 8px;
            padding: .45rem .75rem; font-size: .85rem;
            font-family: 'Inter', sans-serif; color: var(--text);
            background: #fff; cursor: pointer; outline: none;
            transition: border-color .2s; min-width: 150px;
        }
        .sel-status:focus { border-color: var(--accent); }

        /* ── Alert ────────────────────────────────── */
        .alert-success {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #14532d; border-radius: 10px;
        }
        .alert-danger {
            background: #fef2f2; border: 1px solid #fecaca;
            color: #7f1d1d; border-radius: 10px;
        }

        /* ── Modal Lightbox ──────────────────────── */
        .modal-photo .modal-content {
            background: transparent;
            border: none;
        }
        .modal-photo .modal-body {
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-photo .modal-body img {
            max-width: 100%;
            max-height: 90vh;
            border-radius: 12px;
            box-shadow: 0 8px 40px rgba(0,0,0,.4);
        }
        .modal-photo .btn-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255,255,255,.9);
            border-radius: 50%;
            padding: .6rem;
            opacity: 1;
            z-index: 10;
        }

        /* ── Delete Confirm Modal ────────────────── */
        .delete-modal .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 12px 40px rgba(0,0,0,.15);
        }
        .delete-modal .modal-header {
            border-bottom: 1px solid var(--border);
            padding: 1.2rem 1.5rem;
        }
        .delete-modal .modal-body {
            padding: 1.5rem;
        }
        .delete-modal .modal-footer {
            border-top: 1px solid var(--border);
            padding: 1rem 1.5rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-leaf"></i>SIPES
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.laporan.index') }}">
                        <i class="fas fa-tasks me-1"></i>Kelola Laporan
                    </a>
                </li>
                @if(Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                       href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users-cog me-1"></i>Kelola Pengguna
                    </a>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                       id="userMenu" role="button" data-bs-toggle="dropdown">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                 class="rounded-circle" style="width:30px;height:30px;object-fit:cover;" alt="">
                        @else
                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                 style="width:30px;height:30px;font-weight:700;color:var(--primary);font-size:.85rem;">
                                {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                            </div>
                        @endif
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="fas fa-user-circle me-2 text-muted"></i>Kelola Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">
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
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1><i class="fas fa-file-alt me-2"></i>Detail Laporan</h1>
                <p>Detail lengkap laporan #{{ $report->id }}</p>
            </div>
            @if(Auth::user()->role === 'admin')
            <span class="admin-pill"><i class="fas fa-shield-alt me-1"></i>Admin</span>
            @else
            <span class="admin-pill" style="background: rgba(82, 183, 136, 0.2);"><i class="fas fa-user-shield me-1"></i>Petugas</span>
            @endif
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container pb-5">

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 mt-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4 mt-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Breadcrumb --}}
    <div class="breadcrumb-custom mt-4">
        <a href="{{ route('admin.laporan.index') }}"><i class="fas fa-arrow-left me-1"></i>Kelola Laporan</a>
        <span class="separator">/</span>
        <span class="current">Detail Laporan #{{ $report->id }}</span>
    </div>

    @php
        $sc = [
            'pending'      => ['key'=>'pending',      'label'=>'Menunggu'],
            'menunggu'     => ['key'=>'menunggu',     'label'=>'Menunggu'],
            'diproses'     => ['key'=>'diproses',     'label'=>'Diproses'],
            'selesai'      => ['key'=>'selesai',      'label'=>'Selesai'],
            'ditolak'      => ['key'=>'ditolak',      'label'=>'Ditolak'],
            'diverifikasi' => ['key'=>'diverifikasi', 'label'=>'Diverifikasi'],
        ][$report->status] ?? ['key'=>'pending','label'=>'Menunggu'];
    @endphp

    <div class="row g-4">
        {{-- Left Column: Photo & Description --}}
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="d-flex align-items-center gap-3">
                        <span class="title"><i class="fas fa-hashtag me-1" style="font-size:.85rem;color:var(--muted);"></i>Laporan #{{ $report->id }}</span>
                        <span class="sbadge sbadge-{{ $sc['key'] }}">{{ $sc['label'] }}</span>
                    </div>
                    <span style="font-size:.82rem;color:var(--muted);">
                        <i class="fas fa-clock me-1"></i>{{ $report->created_at->format('d M Y, H:i') }} WIB
                    </span>
                </div>
                <div class="detail-card-body">
                    {{-- Photo --}}
                    <div class="mb-4">
                        <div class="info-label"><i class="fas fa-camera me-1"></i>Foto Laporan</div>
                        @if($report->photo_path)
                            <div class="photo-container" data-bs-toggle="modal" data-bs-target="#photoModal" title="Klik untuk memperbesar">
                                <img src="{{ asset('storage/'.$report->photo_path) }}" alt="Foto Laporan #{{ $report->id }}">
                                <div class="photo-overlay">
                                    <i class="fas fa-search-plus"></i>Klik untuk memperbesar
                                </div>
                            </div>
                        @else
                            <div class="photo-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="info-section">
                        <div class="info-label"><i class="fas fa-align-left me-1"></i>Deskripsi</div>
                        <div class="info-value">{{ $report->description }}</div>
                    </div>

                    {{-- Location --}}
                    <div class="info-section">
                        <div class="info-label"><i class="fas fa-map-marker-alt me-1"></i>Lokasi</div>
                        <div class="info-value">{{ $report->location }}</div>
                    </div>

                    @if($report->latitude && $report->longitude)
                    <div class="info-section">
                        <div class="info-label"><i class="fas fa-globe me-1"></i>Koordinat</div>
                        <div class="info-value">
                            <code>{{ $report->latitude }}, {{ $report->longitude }}</code>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column: Info & Actions --}}
        <div class="col-lg-4">
            {{-- Pelapor Info --}}
            <div class="detail-card mb-4">
                <div class="detail-card-header">
                    <span class="title" style="font-size:.92rem;"><i class="fas fa-user me-2" style="font-size:.8rem;color:var(--muted);"></i>Info Pelapor</span>
                </div>
                <div class="detail-card-body">
                    <div class="pelapor-card">
                        <div class="pelapor-avatar">
                            {{ strtoupper(substr($report->user->name ?? '?', 0, 1)) }}
                        </div>
                        <div class="pelapor-info">
                            <div class="name">{{ $report->user->name ?? 'Tidak diketahui' }}</div>
                            <div class="email">{{ $report->user->email ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="detail-card mb-4">
                <div class="detail-card-header">
                    <span class="title" style="font-size:.92rem;"><i class="fas fa-exchange-alt me-2" style="font-size:.8rem;color:var(--muted);"></i>Ubah Status</span>
                </div>
                <div class="detail-card-body">
                    <form method="POST" action="{{ route('admin.laporan.updateStatus', $report->id) }}" id="statusForm">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <select name="status" class="sel-status w-100">
                                <option value="pending"      {{ $report->status==='pending'      ? 'selected':'' }}>Menunggu</option>
                                <option value="diverifikasi" {{ $report->status==='diverifikasi' ? 'selected':'' }}>Diverifikasi</option>
                                <option value="diproses"     {{ $report->status==='diproses'     ? 'selected':'' }}>Diproses</option>
                                <option value="selesai"      {{ $report->status==='selesai'      ? 'selected':'' }}>Selesai</option>
                                <option value="ditolak"      {{ $report->status==='ditolak'      ? 'selected':'' }}>Ditolak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-save-status w-100" id="btnSaveStatus">
                            <i class="fas fa-save me-1"></i>Simpan Status
                        </button>
                    </form>
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
            {{-- Danger Zone --}}
            <div class="detail-card" style="border: 1.5px solid #fecaca;">
                <div class="detail-card-header" style="background: #fef2f2; border-bottom-color: #fecaca;">
                    <span class="title" style="font-size:.92rem; color: #991b1b;"><i class="fas fa-exclamation-triangle me-2" style="font-size:.8rem;"></i>Zona Bahaya</span>
                </div>
                <div class="detail-card-body">
                    <p style="font-size:.85rem; color: var(--muted); margin-bottom: 1rem;">
                        Menghapus laporan bersifat permanen dan tidak dapat dibatalkan.
                    </p>
                    <button type="button" class="btn-delete w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash-alt me-1"></i>Hapus Laporan Ini
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Back Button --}}
    <div class="mt-4">
        <a href="{{ route('admin.laporan.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>Kembali ke Daftar Laporan
        </a>
    </div>

</div>

{{-- Photo Lightbox Modal --}}
@if($report->photo_path)
<div class="modal fade modal-photo" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <img src="{{ asset('storage/'.$report->photo_path) }}" alt="Foto Laporan #{{ $report->id }}">
            </div>
        </div>
    </div>
</div>
@endif

{{-- Delete Confirmation Modal --}}
<div class="modal fade delete-modal" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:700; font-size:1.05rem; color: #991b1b;">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="margin-bottom:.5rem;">Apakah Anda yakin ingin menghapus <strong>Laporan #{{ $report->id }}</strong>?</p>
                <p style="font-size:.88rem; color: var(--muted); margin-bottom:0;">
                    Tindakan ini bersifat permanen. Laporan beserta foto-nya akan dihapus dari sistem dan tidak dapat dikembalikan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:8px; font-size:.88rem;">
                    Batal
                </button>
                <form method="POST" action="{{ route('admin.laporan.destroy', $report->id) }}" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" style="border-radius:8px; font-size:.88rem; font-weight:600;" id="btnConfirmDelete">
                        <i class="fas fa-trash-alt me-1"></i>Ya, Hapus Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Visual feedback saat simpan status diklik
    document.getElementById('statusForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSaveStatus');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan…';
        btn.disabled = true;
    });

    // Visual feedback saat hapus diklik
    document.getElementById('deleteForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnConfirmDelete');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menghapus…';
        btn.disabled = true;
    });
</script>
</body>
</html>
