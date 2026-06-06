<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan - Admin SIPES</title>
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

        /* ── Summary Stats ────────────────────────── */
        .stats-bar {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }
        .stat-chip {
            background: var(--card-bg);
            border-radius: 50px;
            padding: .45rem 1.1rem;
            font-size: .82rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            color: var(--text);
        }
        .stat-chip:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(0,0,0,.1); color: var(--text); }
        .stat-chip .dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; }
        .dot-all      { background: var(--primary); }
        .dot-menunggu { background: #f59e0b; }
        .dot-diproses { background: #f97316; }
        .dot-selesai  { background: #22c55e; }
        .dot-ditolak  { background: #ef4444; }
        .stat-chip.active-chip { background: var(--primary); color: #fff; border-color: var(--primary); }
        .stat-chip.active-chip .dot { background: rgba(255,255,255,.6); }

        /* ── Main Card ────────────────────────────── */
        .main-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
            overflow: hidden;
        }
        .main-card-header {
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .main-card-header .title { font-weight: 700; font-size: 1rem; color: var(--primary-dk); }

        /* ── Filter bar ───────────────────────────── */
        .filter-select {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: .4rem .8rem;
            font-size: .85rem;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: #fff;
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
        }
        .filter-select:focus { border-color: var(--accent); }

        /* ── Laporan Row ──────────────────────────── */
        .laporan-row {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }
        .laporan-row:last-child { border-bottom: none; }
        .laporan-row:hover { background: #fafcfb; }

        /* status stripe */
        .stripe { width: 4px; flex-shrink: 0; border-radius: 4px; align-self: stretch; min-height: 60px; }
        .stripe-pending, .stripe-menunggu { background: #f59e0b; }
        .stripe-diproses     { background: #f97316; }
        .stripe-selesai      { background: #22c55e; }
        .stripe-ditolak      { background: #ef4444; }
        .stripe-diverifikasi { background: #0ea5e9; }

        /* foto */
        .laporan-thumb {
            width: 72px; height: 72px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }
        .laporan-thumb-placeholder {
            width: 72px; height: 72px;
            border-radius: 10px;
            background: var(--soft);
            display: flex; align-items: center; justify-content: center;
            color: var(--accent); font-size: 1.4rem;
            flex-shrink: 0;
            border: 1px solid var(--border);
        }

        /* body */
        .laporan-body { flex: 1; min-width: 0; }
        .laporan-desc { font-weight: 600; color: var(--primary-dk); margin-bottom: .3rem; font-size: .95rem; line-height: 1.45; }
        .laporan-meta { font-size: .8rem; color: var(--muted); display: flex; flex-wrap: wrap; gap: .9rem; margin-bottom: .75rem; }
        .laporan-meta i { margin-right: 3px; }

        /* pelapor chip */
        .pelapor-chip {
            display: inline-flex; align-items: center; gap: .5rem;
            background: var(--soft); border-radius: 50px;
            padding: .25rem .7rem .25rem .35rem;
            margin-bottom: .85rem;
        }
        .pelapor-avatar {
            width: 26px; height: 26px; border-radius: 50%;
            background: var(--primary); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: .72rem; font-weight: 700; flex-shrink: 0;
        }
        .pelapor-name { font-size: .8rem; font-weight: 600; color: var(--primary-dk); }

        /* status badge */
        .sbadge {
            font-size: .72rem; font-weight: 700;
            padding: .28rem .7rem; border-radius: 50px;
            letter-spacing: .3px; display: inline-block;
        }
        .sbadge-pending, .sbadge-menunggu { background: #fef3c7; color: #92400e; }
        .sbadge-diproses     { background: #ffedd5; color: #9a3412; }
        .sbadge-selesai      { background: #dcfce7; color: #14532d; }
        .sbadge-ditolak      { background: #fee2e2; color: #7f1d1d; }
        .sbadge-diverifikasi { background: #e0f2fe; color: #0c4a6e; }

        /* action area */
        .laporan-action { flex-shrink: 0; display: flex; flex-direction: column; align-items: flex-end; gap: .7rem; min-width: 200px; }
        .action-date { font-size: .75rem; color: var(--muted); text-align: right; }
        .status-form-wrap { display: flex; align-items: center; gap: .5rem; }
        .sel-status {
            border: 1.5px solid var(--border); border-radius: 8px;
            padding: .38rem .65rem; font-size: .82rem;
            font-family: 'Inter', sans-serif; color: var(--text);
            background: #fff; cursor: pointer; outline: none;
            transition: border-color .2s; min-width: 130px;
        }
        .sel-status:focus { border-color: var(--accent); }
        .btn-save {
            background: var(--primary); border: none; color: #fff;
            font-size: .82rem; font-weight: 600; padding: .4rem .9rem;
            border-radius: 8px; cursor: pointer; transition: background .2s, transform .1s;
            white-space: nowrap; font-family: 'Inter', sans-serif;
        }
        .btn-save:hover { background: var(--primary-dk); }
        .btn-save:active { transform: scale(.96); }

        /* ── Empty state ──────────────────────────── */
        .empty-state { padding: 4rem 1rem; text-align: center; }
        .empty-state i { font-size: 3rem; color: #cbd5d0; margin-bottom: 1rem; display: block; }
        .empty-state h6 { font-weight: 700; color: var(--muted); margin-bottom: .3rem; }
        .empty-state p  { font-size: .88rem; color: var(--muted); margin: 0; }

        /* ── Pagination ───────────────────────────── */
        .page-link { color: var(--primary); border-radius: 8px !important; margin: 0 2px; border: 1px solid var(--border); }
        .page-item.active .page-link { background: var(--primary); border-color: var(--primary); }

        /* ── Alert ────────────────────────────────── */
        .alert-success {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #14532d; border-radius: 10px;
        }
        .alert-danger {
            background: #fef2f2; border: 1px solid #fecaca;
            color: #7f1d1d; border-radius: 10px;
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
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.laporan.index') }}">
                        <i class="fas fa-tasks me-1"></i>Kelola Laporan
                    </a>
                </li>
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
                <h1><i class="fas fa-tasks me-2"></i>Kelola Laporan</h1>
                <p>Pantau dan ubah status laporan yang masuk dari masyarakat.</p>
            </div>
            <span class="admin-pill"><i class="fas fa-shield-alt me-1"></i>Admin</span>
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

    {{-- Stats Chips --}}
    @php
        $total    = \App\Models\Report::count();
        $menunggu = \App\Models\Report::whereIn('status', ['pending', 'menunggu'])->count();
        $diverifikasi = \App\Models\Report::where('status', 'diverifikasi')->count();
        $diproses = \App\Models\Report::where('status', 'diproses')->count();
        $selesai  = \App\Models\Report::where('status', 'selesai')->count();
        $ditolak  = \App\Models\Report::where('status', 'ditolak')->count();
        $cur      = request('status','');
    @endphp
    <div class="stats-bar mt-4">
        <a href="{{ route('admin.laporan.index') }}"
           class="stat-chip {{ $cur==='' ? 'active-chip' : '' }}">
            <span class="dot dot-all"></span>Semua <strong>{{ $total }}</strong>
        </a>
        <a href="{{ route('admin.laporan.index','status=pending') }}"
           class="stat-chip {{ $cur==='pending' ? 'active-chip' : '' }}">
            <span class="dot dot-menunggu"></span>Menunggu <strong>{{ $menunggu }}</strong>
        </a>
        <a href="{{ route('admin.laporan.index','status=diverifikasi') }}"
           class="stat-chip {{ $cur==='diverifikasi' ? 'active-chip' : '' }}">
            <span class="dot" style="background: #0ea5e9;"></span>Diverifikasi <strong>{{ $diverifikasi }}</strong>
        </a>
        <a href="{{ route('admin.laporan.index','status=diproses') }}"
           class="stat-chip {{ $cur==='diproses' ? 'active-chip' : '' }}">
            <span class="dot dot-diproses"></span>Diproses <strong>{{ $diproses }}</strong>
        </a>
        <a href="{{ route('admin.laporan.index','status=selesai') }}"
           class="stat-chip {{ $cur==='selesai' ? 'active-chip' : '' }}">
            <span class="dot dot-selesai"></span>Selesai <strong>{{ $selesai }}</strong>
        </a>
        <a href="{{ route('admin.laporan.index','status=ditolak') }}"
           class="stat-chip {{ $cur==='ditolak' ? 'active-chip' : '' }}">
            <span class="dot dot-ditolak"></span>Ditolak <strong>{{ $ditolak }}</strong>
        </a>
    </div>

    {{-- Main Card --}}
    <div class="main-card">
        <div class="main-card-header">
            <span class="title">
                <i class="fas fa-list-ul me-2 text-muted" style="font-size:.85rem;"></i>
                {{ $reports->total() }} laporan ditemukan
                @if($cur || request('search')) &mdash; filter: <em>{{ $cur ? ucfirst($cur) : '' }} {{ request('search') ? '"'.request('search').'"' : '' }}</em> @endif
            </span>
            <div class="d-flex align-items-center gap-3">
                <form method="GET" action="{{ route('admin.laporan.index') }}" class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari laporan..." value="{{ request('search') }}">
                    </div>

                    <select name="status" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending"  {{ $cur==='pending'  ? 'selected':'' }}>Menunggu</option>
                        <option value="diverifikasi" {{ $cur==='diverifikasi' ? 'selected':'' }}>Diverifikasi</option>
                        <option value="diproses" {{ $cur==='diproses' ? 'selected':'' }}>Diproses</option>
                        <option value="selesai"  {{ $cur==='selesai'  ? 'selected':'' }}>Selesai</option>
                        <option value="ditolak"  {{ $cur==='ditolak'  ? 'selected':'' }}>Ditolak</option>
                    </select>

                    <button type="submit" class="btn btn-sm btn-primary px-3" style="border-radius:8px;">
                        Cari
                    </button>
                </form>

                @if($cur || request('search'))
                <a href="{{ route('admin.laporan.index') }}"
                   class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.82rem;" title="Reset Filter">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </div>

        {{-- List --}}
        @if($reports->isEmpty())
            <div class="empty-state">
                <i class="fas fa-clipboard-check"></i>
                <h6>Tidak ada laporan</h6>
                <p>Belum ada laporan yang masuk atau sesuai dengan filter yang dipilih.</p>
            </div>
        @else
            @foreach($reports as $report)
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
            <div class="laporan-row">
                {{-- Stripe warna status --}}
                <div class="stripe stripe-{{ $sc['key'] }}"></div>

                {{-- Foto --}}
                @if($report->photo_path)
                    <img src="{{ asset('storage/'.$report->photo_path) }}"
                         class="laporan-thumb" alt="Foto Laporan">
                @else
                    <div class="laporan-thumb-placeholder">
                        <i class="fas fa-image"></i>
                    </div>
                @endif

                {{-- Body --}}
                <div class="laporan-body">
                    <div class="laporan-desc">{{ Str::limit($report->description, 90) }}</div>
                    <div class="laporan-meta">
                        <span><i class="fas fa-map-marker-alt"></i>{{ $report->location }}</span>
                        <span><i class="fas fa-hashtag"></i>#{{ $report->id }}</span>
                    </div>
                    <div class="pelapor-chip">
                        <div class="pelapor-avatar">
                            {{ strtoupper(substr($report->user->name ?? '?', 0, 1)) }}
                        </div>
                        <span class="pelapor-name">{{ $report->user->name ?? 'Tidak diketahui' }}</span>
                    </div>
                    <span class="sbadge sbadge-{{ $sc['key'] }}">{{ $sc['label'] }}</span>
                </div>

                {{-- Action --}}
                <div class="laporan-action">
                    <span class="action-date">
                        <i class="fas fa-clock me-1"></i>
                        {{ $report->created_at->format('d M Y') }}<br>
                        <span style="font-size:.7rem;">{{ $report->created_at->format('H:i') }} WIB</span>
                    </span>
                    <form method="POST"
                          action="{{ route('admin.laporan.updateStatus', $report->id) }}"
                          class="status-form-wrap">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="sel-status">
                            <option value="pending"  {{ $report->status==='pending'  ? 'selected':'' }}>Menunggu</option>
                            <option value="diproses" {{ $report->status==='diproses' ? 'selected':'' }}>Diproses</option>
                            <option value="selesai"  {{ $report->status==='selesai'  ? 'selected':'' }}>Selesai</option>
                            <option value="ditolak"  {{ $report->status==='ditolak'  ? 'selected':'' }}>Ditolak</option>
                        </select>
                        <button type="submit" class="btn-save" id="save-{{ $report->id }}">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </form>
                    <div class="d-flex align-items-center gap-2" style="margin-top: .3rem;">
                        <a href="{{ route('admin.laporan.show', $report->id) }}"
                           class="btn btn-sm btn-outline-primary" style="border-radius:8px; font-size:.78rem; font-weight:600; padding:.3rem .7rem;">
                            <i class="fas fa-eye me-1"></i>Detail
                        </a>
                        <form method="POST" action="{{ route('admin.laporan.destroy', $report->id) }}"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus Laporan #{{ $report->id }}? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px; font-size:.78rem; font-weight:600; padding:.3rem .7rem;">
                                <i class="fas fa-trash-alt me-1"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    {{-- Pagination --}}
    @if($reports->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $reports->links('pagination::bootstrap-5') }}
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Visual feedback saat simpan diklik
    document.querySelectorAll('.status-form-wrap').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('.btn-save');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan…';
            btn.disabled = true;
        });
    });
</script>
</body>
</html>
