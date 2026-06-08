<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin SIPES</title>
    <meta name="description" content="Halaman admin untuk mengelola data pengguna SIPES">
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
        .dot-pelapor  { background: #0ea5e9; }
        .dot-petugas  { background: #f59e0b; }
        .dot-admin    { background: #ef4444; }
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

        /* ── User Row ────────────────────────────── */
        .user-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }
        .user-row:last-child { border-bottom: none; }
        .user-row:hover { background: #fafcfb; }

        /* avatar */
        .user-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1rem; flex-shrink: 0;
            color: #fff;
        }
        .avatar-pelapor  { background: linear-gradient(135deg, #0ea5e9, #0284c7); }
        .avatar-petugas  { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .avatar-admin    { background: linear-gradient(135deg, #ef4444, #dc2626); }

        .user-avatar img {
            width: 44px; height: 44px; border-radius: 50%;
            object-fit: cover;
        }

        /* info */
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-weight: 600; color: var(--primary-dk); font-size: .95rem; line-height: 1.3; }
        .user-email { font-size: .82rem; color: var(--muted); }

        /* role badge */
        .rbadge {
            font-size: .72rem; font-weight: 700;
            padding: .28rem .7rem; border-radius: 50px;
            letter-spacing: .3px; display: inline-block;
            text-transform: capitalize;
        }
        .rbadge-pelapor  { background: #e0f2fe; color: #0c4a6e; }
        .rbadge-petugas  { background: #fef3c7; color: #92400e; }
        .rbadge-admin    { background: #fee2e2; color: #7f1d1d; }

        /* action area */
        .user-action { flex-shrink: 0; display: flex; align-items: center; gap: .5rem; }
        .user-meta { font-size: .78rem; color: var(--muted); white-space: nowrap; margin-right: .5rem; }
        .sel-role {
            border: 1.5px solid var(--border); border-radius: 8px;
            padding: .38rem .65rem; font-size: .82rem;
            font-family: 'Inter', sans-serif; color: var(--text);
            background: #fff; cursor: pointer; outline: none;
            transition: border-color .2s; min-width: 110px;
        }
        .sel-role:focus { border-color: var(--accent); }
        .btn-save {
            background: var(--primary); border: none; color: #fff;
            font-size: .82rem; font-weight: 600; padding: .4rem .9rem;
            border-radius: 8px; cursor: pointer; transition: background .2s, transform .1s;
            white-space: nowrap; font-family: 'Inter', sans-serif;
        }
        .btn-save:hover { background: var(--primary-dk); }
        .btn-save:active { transform: scale(.96); }
        .btn-delete {
            background: none; border: 1.5px solid #fecaca; color: #dc2626;
            font-size: .82rem; font-weight: 600; padding: .4rem .7rem;
            border-radius: 8px; cursor: pointer; transition: all .2s;
            white-space: nowrap; font-family: 'Inter', sans-serif;
        }
        .btn-delete:hover { background: #fee2e2; border-color: #dc2626; }
        .btn-delete:active { transform: scale(.96); }

        /* ── Self badge ──────────────────────────── */
        .self-badge {
            font-size: .7rem; font-weight: 600;
            padding: .2rem .55rem; border-radius: 50px;
            background: var(--soft); color: var(--primary);
            margin-left: .4rem;
        }

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

        /* ── Delete Modal ────────────────────────── */
        .modal-content { border: none; border-radius: 16px; }
        .modal-header { border-bottom: 1px solid var(--border); }
        .modal-footer { border-top: 1px solid var(--border); }
        .btn-cancel-modal {
            background: #f3f4f6; border: none; color: var(--text);
            font-weight: 600; padding: .5rem 1.2rem; border-radius: 8px;
            font-family: 'Inter', sans-serif; cursor: pointer;
        }
        .btn-cancel-modal:hover { background: #e5e7eb; }
        .btn-confirm-delete {
            background: #dc2626; border: none; color: #fff;
            font-weight: 600; padding: .5rem 1.2rem; border-radius: 8px;
            font-family: 'Inter', sans-serif; cursor: pointer;
        }
        .btn-confirm-delete:hover { background: #b91c1c; }

        /* ── Responsive ──────────────────────────── */
        @media (max-width: 768px) {
            .user-row { flex-wrap: wrap; }
            .user-action { width: 100%; justify-content: flex-end; margin-top: .5rem; }
            .user-meta { display: none; }
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
                    <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}"
                       href="{{ route('admin.laporan.index') }}">
                        <i class="fas fa-tasks me-1"></i>Kelola Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users-cog me-1"></i>Kelola Pengguna
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
                <h1><i class="fas fa-users-cog me-2"></i>Kelola Pengguna</h1>
                <p>Lihat, ubah role, atau hapus akun pengguna pada sistem.</p>
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
        $totalUsers   = \App\Models\User::count();
        $pelaporCount = \App\Models\User::where('role', 'pelapor')->count();
        $petugasCount = \App\Models\User::where('role', 'petugas')->count();
        $adminCount   = \App\Models\User::where('role', 'admin')->count();
        $curRole      = request('role', '');
    @endphp
    <div class="stats-bar mt-4">
        <a href="{{ route('admin.users.index') }}"
           class="stat-chip {{ $curRole==='' ? 'active-chip' : '' }}">
            <span class="dot dot-all"></span>Semua <strong>{{ $totalUsers }}</strong>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'pelapor']) }}"
           class="stat-chip {{ $curRole==='pelapor' ? 'active-chip' : '' }}">
            <span class="dot dot-pelapor"></span>Pelapor <strong>{{ $pelaporCount }}</strong>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'petugas']) }}"
           class="stat-chip {{ $curRole==='petugas' ? 'active-chip' : '' }}">
            <span class="dot dot-petugas"></span>Petugas <strong>{{ $petugasCount }}</strong>
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
           class="stat-chip {{ $curRole==='admin' ? 'active-chip' : '' }}">
            <span class="dot dot-admin"></span>Admin <strong>{{ $adminCount }}</strong>
        </a>
    </div>

    {{-- Main Card --}}
    <div class="main-card">
        <div class="main-card-header">
            <span class="title">
                <i class="fas fa-list-ul me-2 text-muted" style="font-size:.85rem;"></i>
                {{ $users->total() }} pengguna ditemukan
                @if($curRole || request('search')) &mdash; filter: <em>{{ $curRole ? ucfirst($curRole) : '' }} {{ request('search') ? '"'.request('search').'"' : '' }}</em> @endif
            </span>
            <div class="d-flex align-items-center gap-3">
                <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0"
                               placeholder="Cari nama atau email..." value="{{ request('search') }}"
                               id="search-input">
                    </div>

                    <select name="role" class="filter-select" onchange="this.form.submit()" id="filter-role">
                        <option value="">Semua Role</option>
                        <option value="pelapor"  {{ $curRole==='pelapor'  ? 'selected':'' }}>Pelapor</option>
                        <option value="petugas"  {{ $curRole==='petugas'  ? 'selected':'' }}>Petugas</option>
                        <option value="admin"    {{ $curRole==='admin'    ? 'selected':'' }}>Admin</option>
                    </select>

                    <button type="submit" class="btn btn-sm btn-primary px-3" style="border-radius:8px;" id="btn-search">
                        Cari
                    </button>
                </form>

                @if($curRole || request('search'))
                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.82rem;" title="Reset Filter">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </div>

        {{-- User List --}}
        @if($users->isEmpty())
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <h6>Tidak ada pengguna</h6>
                <p>Belum ada pengguna yang terdaftar atau sesuai dengan filter yang dipilih.</p>
            </div>
        @else
            @foreach($users as $user)
            <div class="user-row" id="user-row-{{ $user->id }}">
                {{-- Avatar --}}
                @if($user->profile_photo_path)
                    <div class="user-avatar avatar-{{ $user->role }}">
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                    </div>
                @else
                    <div class="user-avatar avatar-{{ $user->role }}">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                {{-- Info --}}
                <div class="user-info">
                    <div class="user-name">
                        {{ $user->name }}
                        @if($user->id === Auth::id())
                            <span class="self-badge">Anda</span>
                        @endif
                    </div>
                    <div class="user-email">{{ $user->email }}</div>
                </div>

                {{-- Role Badge --}}
                <span class="rbadge rbadge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>

                {{-- Action --}}
                <div class="user-action">
                    <span class="user-meta">
                        <i class="fas fa-calendar-alt me-1"></i>{{ $user->created_at->format('d M Y') }}
                    </span>

                    @if($user->id !== Auth::id())
                        {{-- Update Role --}}
                        <form method="POST"
                              action="{{ route('admin.users.updateRole', $user->id) }}"
                              class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="sel-role" id="select-role-{{ $user->id }}">
                                <option value="pelapor"  {{ $user->role==='pelapor'  ? 'selected':'' }}>Pelapor</option>
                                <option value="petugas"  {{ $user->role==='petugas'  ? 'selected':'' }}>Petugas</option>
                                <option value="admin"    {{ $user->role==='admin'    ? 'selected':'' }}>Admin</option>
                            </select>
                            <button type="submit" class="btn-save" id="save-role-{{ $user->id }}">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                        </form>

                        {{-- Delete --}}
                        <button type="button" class="btn-delete" id="btn-delete-{{ $user->id }}"
                                onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    @else
                        <span class="text-muted" style="font-size:.8rem;font-style:italic;">—</span>
                    @endif
                </div>
            </div>
            @endforeach
        @endif
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
    @endif

</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengguna <strong id="deleteUserName"></strong>?</p>
                <div class="alert alert-danger py-2 mb-0" style="font-size:.85rem;">
                    <i class="fas fa-info-circle me-1"></i>
                    Semua laporan yang dibuat oleh pengguna ini juga akan <strong>ikut dihapus</strong> secara permanen.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-confirm-delete" id="btn-confirm-delete">
                        <i class="fas fa-trash-alt me-1"></i>Hapus Pengguna
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Delete confirmation modal
    function confirmDelete(userId, userName) {
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteForm').action = '/admin/users/' + userId;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    // Visual feedback saat simpan role diklik
    document.querySelectorAll('.user-action form').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('.btn-save');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan…';
                btn.disabled = true;
            }
        });
    });

    // Visual feedback saat hapus diklik
    document.getElementById('deleteForm').addEventListener('submit', function() {
        const btn = document.getElementById('btn-confirm-delete');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menghapus…';
        btn.disabled = true;
    });
</script>
</body>
</html>
