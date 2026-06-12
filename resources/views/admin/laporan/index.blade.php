@if(Auth::user()->role === 'petugas')
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kelola Laporan - SIPES Petugas</title>
        <!-- Tailwind CSS 4 -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
            body { font-family: 'Inter', sans-serif; background-color: #F3F4F6; }
            .sidebar-link.active {
                background-color: #22C55E;
                color: white;
                box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.4);
            }
            :root {
                --primary:      #2d6a4f;
                --primary-dk: #1b4332;
                --accent:      #52b788;
                --soft:        #d8f3dc;
                --bg:          #f0f4f1;
                --card-bg:     #ffffff;
                --text:        #1e2d23;
                --muted:       #6b7c72;
                --border:      #e4ece7;
            }
            /* Custom Laporan Styles */
            * { box-sizing: border-box; }
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
            .btn-save {
                background: var(--primary); border: none; color: white;
                font-size: .85rem; font-weight: 600; padding: .5rem 1rem;
                border-radius: 10px; cursor: pointer; transition: background .2s, transform .1s;
                font-family: 'Inter', sans-serif;
            }
            .btn-save:hover { background: var(--primary-dk); }
            .sel-status {
                border: 1.5px solid var(--border); border-radius: 8px;
                padding: .45rem .75rem; font-size: .85rem;
                font-family: 'Inter', sans-serif; color: var(--text);
                background: white; cursor: pointer; outline: none;
                transition: border-color .2s; min-width: 150px;
            }
            .sel-status:focus { border-color: var(--accent); }
        </style>
    </head>
    <body class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center text-white text-xl">
                    <i class="fas fa-leaf"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">SIPES <span class="text-green-500">Petugas</span></span>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="fas fa-th-large w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'pending']) }}" class="sidebar-link @if(request('status') == 'pending' || request('status') == 'menunggu') active @endif flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="fas fa-inbox w-5"></i>
                    <span class="font-medium">Laporan Masuk</span>
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'diproses']) }}" class="sidebar-link @if(request('status') == 'diproses') active @endif flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="fas fa-spinner w-5"></i>
                    <span class="font-medium">Dalam Proses</span>
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}" class="sidebar-link @if(request('status') == 'selesai') active @endif flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="fas fa-check-circle w-5"></i>
                    <span class="font-medium">Selesai</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="sidebar-link @if(!request('status')) active @endif flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="fas fa-history w-5"></i>
                    <span class="font-medium">Riwayat Penanganan</span>
                </a>
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akun</div>
                <a href="{{ route('profile.show') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="fas fa-user w-5"></i>
                    <span class="font-medium">Profil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full sidebar-link flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition-all">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <div class="bg-blue-50 p-4 rounded-xl">
                    <p class="text-xs text-blue-600 font-bold uppercase mb-1">Butuh Bantuan?</p>
                    <p class="text-xs text-blue-500 mb-3">Hubungi Admin jika ada kendala sistem.</p>
                    <a href="#" class="text-xs font-bold text-blue-700 hover:underline">Kontak Support</a>
                </div>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 md:px-8 flex-shrink-0">
                <button class="md:hidden text-gray-500 text-xl">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex-1 max-w-xl mx-4 hidden sm:block">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm transition-all" placeholder="Cari laporan atau lokasi...">
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-all">
                        <i class="fas fa-bell"></i>
                        @php
                            $menungguCount = \App\Models\Report::whereIn('status', ['pending', 'menunggu'])->count();
                        @endphp
                        @if($menungguCount > 0)
                            <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">
                                {{ $menungguCount }}
                            </span>
                        @endif
                    </button>
                    <div class="h-8 w-px bg-gray-200 mx-1"></div>
                    <!-- User Profile -->
                    <div class="flex items-center gap-3 pl-2">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 mt-1 uppercase font-semibold tracking-wider">Petugas Kebersihan</p>
                        </div>
                        <a href="{{ route('profile.show') }}" class="w-10 h-10 rounded-full overflow-hidden border-2 border-green-500 flex-shrink-0">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-green-100 text-green-600 flex items-center justify-center font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </a>
                    </div>
                </div>
            </header>
            <!-- Page Body -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Kelola Laporan</h1>
                    <p class="text-gray-500">Lihat dan kelola seluruh laporan yang masuk ke SIPES.</p>
                </div>
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
                @endif
                <!-- Stats Bar -->
                <div class="flex flex-wrap gap-3 mb-6">
                    @php
                        $total      = \App\Models\Report::count();
                        $menunggu   = \App\Models\Report::whereIn('status', ['pending', 'menunggu'])->count();
                        $diverifikasi = \App\Models\Report::where('status', 'diverifikasi')->count();
                        $diproses   = \App\Models\Report::where('status', 'diproses')->count();
                        $selesai    = \App\Models\Report::where('status', 'selesai')->count();
                        $ditolak    = \App\Models\Report::where('status', 'ditolak')->count();
                        $cur        = request('status', '');
                    @endphp
                    <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-50 text-gray-600 transition-all">
                        <span class="font-bold text-gray-800 mr-1">{{ $total }}</span> Semua
                    </a>
                    <a href="{{ route('admin.laporan.index', ['status' => 'pending']) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-50 text-gray-600 transition-all">
                        <span class="font-bold text-yellow-600 mr-1">{{ $menunggu }}</span> Menunggu
                    </a>
                    <a href="{{ route('admin.laporan.index', ['status' => 'diverifikasi']) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-50 text-gray-600 transition-all">
                        <span class="font-bold text-sky-600 mr-1">{{ $diverifikasi }}</span> Diverifikasi
                    </a>
                    <a href="{{ route('admin.laporan.index', ['status' => 'diproses']) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-50 text-gray-600 transition-all">
                        <span class="font-bold text-orange-600 mr-1">{{ $diproses }}</span> Diproses
                    </a>
                    <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-50 text-gray-600 transition-all">
                        <span class="font-bold text-green-600 mr-1">{{ $selesai }}</span> Selesai
                    </a>
                    <a href="{{ route('admin.laporan.index', ['status' => 'ditolak']) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-50 text-gray-600 transition-all">
                        <span class="font-bold text-red-600 mr-1">{{ $ditolak }}</span> Ditolak
                    </a>
                </div>
                <!-- Main Card -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between mb-4 gap-3">
                        <span class="text-lg font-bold text-gray-800">
                            <i class="fas fa-list-ul me-2 text-muted" style="font-size:.85rem;"></i>
                            {{ $reports->total() }} laporan ditemukan
                            @if($cur || request('search')) &mdash; filter: <em>{{ $cur ? ucfirst($cur) : '' }} {{ request('search') ? '"'.request('search').'"' : '' }}</em> @endif
                        </span>
                        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex items-center gap-2">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" name="search" class="pl-10 pr-3 py-2 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm transition-all" value="{{ request('search') }}" placeholder="Cari laporan...">
                            </div>
                            <select name="status" class="sel-status" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="pending"  {{ $cur == 'pending'  ? 'selected' : '' }}>Menunggu</option>
                                <option value="diverifikasi" {{ $cur == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                <option value="diproses" {{ $cur == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai"  {{ $cur == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak"  {{ $cur == 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <button type="submit" class="btn-save">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                        </form>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-400 text-xs font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Laporan</th>
                                    <th class="px-6 py-4">Lokasi</th>
                                    <th class="px-6 py-4">Tanggal</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($reports as $report)
                                <tr class="hover:bg-gray-50 transition-all">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                                @if($report->photo_path)
                                                    <img src="{{ asset('storage/' . $report->photo_path) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-gray-800 truncate">{{ Str::limit($report->description, 30) }}</p>
                                                <p class="text-xs text-gray-400 truncate">Oleh: {{ $report->user->name ?? 'Anonim' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-600 truncate max-w-[150px]"><i class="fas fa-map-marker-alt text-red-400 mr-1"></i>{{ $report->location }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-600">{{ $report->created_at->format('d/m/Y') }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $report->created_at->format('H:i') }} WIB</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'menunggu' => 'bg-yellow-100 text-yellow-700',
                                                'diverifikasi' => 'bg-sky-100 text-sky-700',
                                                'diproses' => 'bg-blue-100 text-blue-700',
                                                'selesai' => 'bg-green-100 text-green-700',
                                                'ditolak' => 'bg-red-100 text-red-700',
                                            ];
                                            $statusClass = $statusClasses[$report->status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                                            {{ $report->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.laporan.show', $report->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-500 hover:text-white transition-all">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(Auth::user()->role === 'admin')
                                            <form method="POST" action="{{ route('admin.laporan.destroy', $report->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Laporan #{{ $report->id }}? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-all">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $reports->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </main>
    </body>
    </html>
@else
    <!-- Original Admin View -->
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kelola Laporan - Admin SIPES</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            :root {
                --primary:      #2d6a4f;
                --primary-dk: #1b4332;
                --accent:      #52b788;
                --soft:        #d8f3dc;
                --bg:          #f0f4f1;
                --card-bg:     #ffffff;
                --text:        #1e2d23;
                --muted:       #6b7c72;
                --border:      #e4ece7;
            }
            * { box-sizing: border-box; }
            body {
                font-family: 'Inter', sans-serif;
                background: var(--bg);
                color: var(--text);
            }
            .navbar {
                background: var(--primary);
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
            .navbar-brand i { margin-right: 8px; }
            .nav-link {
                color: rgba(255,255,255,0.8) !important;
                font-weight: 500;
                margin: 0 10px;
                transition: color 0.3s ease;
            }
            .nav-link:hover, .nav-link.active { color: white !important; }
            .dropdown-menu { border: none; border-radius: 12px; box-shadow: 0 8px 28px rgba(0,0,0,0.12); padding: .5rem; }
            .dropdown-item { border-radius: 8px; padding: .5rem .9rem; font-size: .9rem; }
            .dropdown-item:hover { background: var(--soft); color: var(--primary); }
            .btn-save {
                background: var(--primary); border: none; color: white;
                font-size: .85rem; font-weight: 600; padding: .5rem 1.2rem;
                border-radius: 10px; cursor: pointer; transition: background .2s, transform .1s;
                font-family: 'Inter', sans-serif;
            }
            .btn-save:hover { background: var(--primary-dk); }
            .btn-save:active { transform: scale(.96); }
            .sel-status {
                border: 1.5px solid var(--border); border-radius: 8px;
                padding: .45rem .75rem; font-size: .85rem;
                font-family: 'Inter', sans-serif; color: var(--text);
                background: white; cursor: pointer; outline: none;
                transition: border-color .2s; min-width: 150px;
            }
            .sel-status:focus { border-color: var(--accent); }
            .sbadge {
                font-size: .75rem; font-weight: 700;
                padding: .3rem .8rem; border-radius: 50px;
                letter-spacing: .3px; display: inline-block;
            }
            .sbadge-pending, .sbadge-menunggu { background: #fef3c7; color: #92400e; }
            .sbadge-diverifikasi { background: #e0f2fe; color: #0c4a6e; }
            .sbadge-diproses { background: #ffedd5; color: #9a3412; }
            .sbadge-selesai { background: #dcfce7; color: #14532d; }
            .sbadge-ditolak { background: #fee2e2; color: #7f1d1d; }
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
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users-cog me-1"></i>Kelola Pengguna
                            </a>
                        </li>
                        @endif
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="rounded-circle" style="width:30px;height:30px;object-fit:cover;" alt="">
                                @else
                                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width:30px;height:30px;font-weight:700;color:var(--primary);font-size:.85rem;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
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
        <div class="container py-5">
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
            <!-- Stats Bar -->
            <div class="d-flex flex-wrap gap-3 mb-4">
                @php
                    $total      = \App\Models\Report::count();
                    $menunggu   = \App\Models\Report::whereIn('status', ['pending', 'menunggu'])->count();
                    $diverifikasi = \App\Models\Report::where('status', 'diverifikasi')->count();
                    $diproses   = \App\Models\Report::where('status', 'diproses')->count();
                    $selesai    = \App\Models\Report::where('status', 'selesai')->count();
                    $ditolak    = \App\Models\Report::where('status', 'ditolak')->count();
                    $cur        = request('status', '');
                @endphp
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-success btn-sm rounded-pill px-4 py-2 {{ $cur == '' ? 'active' : '' }}">
                    <span class="fw-bold"> {{ $total }}</span> Semua
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'pending']) }}" class="btn btn-outline-warning btn-sm rounded-pill px-4 py-2 {{ $cur == 'pending' || $cur == 'menunggu' ? 'active' : '' }}">
                    <span class="fw-bold">{{ $menunggu }}</span> Menunggu
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'diverifikasi']) }}" class="btn btn-outline-info btn-sm rounded-pill px-4 py-2 {{ $cur == 'diverifikasi' ? 'active' : '' }}">
                    <span class="fw-bold">{{ $diverifikasi }}</span> Diverifikasi
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'diproses']) }}" class="btn btn-outline-warning btn-sm rounded-pill px-4 py-2 {{ $cur == 'diproses' ? 'active' : '' }}">
                    <span class="fw-bold">{{ $diproses }}</span> Diproses
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}" class="btn btn-outline-success btn-sm rounded-pill px-4 py-2 {{ $cur == 'selesai' ? 'active' : '' }}">
                    <span class="fw-bold">{{ $selesai }}</span> Selesai
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'ditolak']) }}" class="btn btn-outline-danger btn-sm rounded-pill px-4 py-2 {{ $cur == 'ditolak' ? 'active' : '' }}">
                    <span class="fw-bold">{{ $ditolak }}</span> Ditolak
                </a>
            </div>
            <!-- Main Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <span class="fw-bold text-muted">
                            <i class="fas fa-list-ul me-2 text-muted" style="font-size:.85rem;"></i>
                            {{ $reports->total() }} laporan ditemukan
                            @if($cur || request('search')) &mdash; filter: <em>{{ $cur ? ucfirst($cur) : '' }} {{ request('search') ? '"'.request('search').'"' : '' }}</em> @endif
                        </span>
                        <div class="d-flex align-items-center gap-2">
                            <form method="GET" action="{{ route('admin.laporan.index') }}" class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari laporan..." value="{{ request('search') }}">
                                </div>
                                <select name="status" class="sel-status" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="pending"  {{ $cur == 'pending'  ? 'selected' : '' }}>Menunggu</option>
                                    <option value="diverifikasi" {{ $cur == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                    <option value="diproses" {{ $cur == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai"  {{ $cur == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak"  {{ $cur == 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <button type="submit" class="btn-save" id="searchButton">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                            </form>
                            @if($cur || request('search'))
                            <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.82rem;">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th style="width:35%">Laporan</th>
                                    <th style="width:20%">Lokasi</th>
                                    <th style="width:15%">Tanggal</th>
                                    <th style="width:15%">Status</th>
                                    <th style="width:15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width:50px;height:50px;border-radius:8px;overflow:hidden;background:#eee;flex-shrink:0;">
                                                @if($report->photo_path)
                                                    <img src="{{ asset('storage/' . $report->photo_path) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
                                                @else
                                                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#ccc;">
                                                        <i class="fas fa-image fa-2x"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="mb-0 fw-semibold text-truncate" style="max-width:300px;">{{ $report->description }}</p>
                                                <p class="mb-0 text-muted small">
                                                    <i class="fas fa-user me-1"></i>{{ $report->user->name ?? 'Anonim' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $report->location }}
                                    </td>
                                    <td class="text-muted small">
                                        {{ $report->created_at->format('d M Y') }}
                                        <br><small class="text-xs">{{ $report->created_at->format('H:i') }} WIB</small>
                                    </td>
                                    <td>
                                        @php
                                            $sc = [
                                                'pending'      => ['key'=>'pending',      'label'=>'Menunggu'],
                                                'menunggu'   => ['key'=>'menunggu', 'label'=>'Menunggu'],
                                                'diverifikasi' => ['key'=>'diverifikasi', 'label'=>'Diverifikasi'],
                                                'diproses'     => ['key'=>'diproses', 'label'=>'Diproses'],
                                                'selesai'      => ['key'=>'selesai', 'label'=>'Selesai'],
                                                'ditolak'      => ['key'=>'ditolak', 'label'=>'Ditolak'],
                                            ][$report->status] ?? ['key'=>'pending','label'=>'Menunggu'];
                                        @endphp
                                        <span class="sbadge sbadge-{{ $sc['key'] }}">{{ $sc['label'] }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.laporan.show', $report->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;font-size:.78rem;font-weight:600;padding:.3rem .7rem;">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                            @if(Auth::user()->role === 'admin')
                                            <form method="POST" action="{{ route('admin.laporan.destroy', $report->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Laporan #{{ $report->id }}? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;font-size:.78rem;font-weight:600;padding:.3rem .7rem;">
                                                    <i class="fas fa-trash-alt me-1"></i>Hapus
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $reports->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
@endif
