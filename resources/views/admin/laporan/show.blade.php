@if(Auth::user()->role === 'petugas')
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Laporan - SIPES Petugas</title>
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
                font-size: .85rem; font-weight: 600; padding: .5rem 1.2rem;
                border-radius: 10px; cursor: pointer; transition: background .2s, transform .1s;
                font-family: 'Inter', sans-serif;
            }
            .btn-save:hover { background: var(--primary-dk); }
            .btn-save:active { transform: scale(.96); }
            .btn-back {
                background: #e5e7eb; color: #374151; border: none;
                font-size: .85rem; font-weight: 600; padding: .5rem 1.2rem;
                border-radius: 10px; cursor: pointer; transition: background .2s;
                font-family: 'Inter', sans-serif;
            }
            .btn-back:hover { background: #d1d5db; }
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
                <a href="{{ route('admin.laporan.index', ['status' => 'pending']) }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="fas fa-inbox w-5"></i>
                    <span class="font-medium">Laporan Masuk</span>
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'diproses']) }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="fas fa-spinner w-5"></i>
                    <span class="font-medium">Dalam Proses</span>
                </a>
                <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="fas fa-check-circle w-5"></i>
                    <span class="font-medium">Selesai</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="sidebar-link active flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
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
                    <a href="javascript:void(0)" onclick="openSupportModal()" class="text-xs font-bold text-blue-700 hover:underline">Kontak Support</a>
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
                    <button class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-all">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div class="h-8 w-px bg-gray-200 mx-1"></div>
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
                    <a href="{{ route('admin.laporan.index') }}" class="btn-back mb-3">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Laporan
                    </a>
                    <div class="mt-2">
                        <h1 class="text-2xl font-bold text-gray-800">Detail Laporan #{{ $report->id }}</h1>
                    </div>
                </div>
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
                @endif
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Laporan</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Status</p>
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
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
                                <p class="text-gray-800">{{ $report->description }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Lokasi</p>
                                <p class="text-gray-800"><i class="fas fa-map-marker-alt text-red-400 mr-2"></i>{{ $report->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Tanggal Dibuat</p>
                                <p class="text-gray-800">{{ $report->created_at->format('d M Y H:i') }} WIB</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Dibuat Oleh</p>
                                <p class="text-gray-800">
                                    <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                                    {{ $report->user ? $report->user->name : 'Anonim' }}
                                    @if($report->user)
                                        <span class="text-xs text-gray-400">({{ $report->user->email }})</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Bukti Foto</h3>
                        @if($report->photo_path)
                            <img src="{{ asset('storage/' . $report->photo_path) }}" alt="Foto Laporan" class="w-full rounded-xl shadow-sm border border-gray-100">
                        @else
                            <div class="bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center h-64">
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-sm text-gray-400">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mt-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Perbarui Status</h3>
                    <form method="POST" action="{{ route('admin.laporan.updateStatus', $report->id) }}" id="form-update-status">
                        @csrf
                        @method('PATCH')
                        <div class="flex flex-wrap items-end gap-4">
                            <div class="flex-1 min-w-[200px]">
                                <label for="status" class="block text-sm text-gray-500 mb-1">Status Baru</label>
                                @php
                                    $currentStatus = $report->status;
                                    $allowedOptions = [];
                                    if(Auth::user()->role === 'admin') {
                                        if(in_array($currentStatus, ['pending','menunggu'])) {
                                            $allowedOptions = ['diverifikasi','ditolak'];
                                        }
                                    } elseif(Auth::user()->role === 'petugas') {
                                        if($currentStatus === 'diverifikasi') {
                                            $allowedOptions = ['diproses'];
                                        } elseif($currentStatus === 'diproses') {
                                            $allowedOptions = ['selesai'];
                                        }
                                    }
                                    $optionLabels = [
                                        'diverifikasi' => 'Diverifikasi',
                                        'ditolak' => 'Ditolak',
                                        'diproses' => 'Diproses',
                                        'selesai' => 'Selesai'
                                    ];
                                @endphp
                                @if(!empty($allowedOptions))
                                    <select name="status" id="status" class="sel-status w-full">
                                        <option value="">Pilih Status...</option>
                                        @foreach($allowedOptions as $opt)
                                            <option value="{{ $opt }}">{{ $optionLabels[$opt] }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <p class="text-gray-500 italic">Tidak ada aksi yang tersedia</p>
                                @endif
                            </div>
                            @if(!empty($allowedOptions))
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save mr-1"></i> Simpan
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <script>
            document.getElementById('form-update-status').addEventListener('submit', function(e) {
                var select = document.getElementById('status');
                var newStatus = select.value;
                var message = '';
                if (newStatus === 'diverifikasi') message = 'Apakah Anda yakin ingin memverifikasi laporan ini?';
                else if (newStatus === 'ditolak') message = 'Apakah Anda yakin ingin menolak laporan ini?';
                else if (newStatus === 'diproses') message = 'Apakah Anda yakin akan mulai menangani laporan ini?';
                else if (newStatus === 'selesai') message = 'Apakah Anda yakin laporan ini telah selesai ditangani?';
                if (message && !confirm(message)) {
                    e.preventDefault();
                }
            });
    <!-- Support Modal -->
    <div id="supportModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeSupportModal()"></div>
        
        <!-- Modal Card -->
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm transform scale-95 opacity-0 transition-all duration-300 overflow-hidden z-10 border border-gray-100 p-8 text-center flex flex-col items-center">
            <!-- Close Button -->
            <button onclick="closeSupportModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-50 transition-all focus:outline-none" aria-label="Tutup">
                <i class="fas fa-times text-lg"></i>
            </button>
            
            <!-- WhatsApp Icon Container with premium gradient & shadow -->
            <div class="w-20 h-20 bg-gradient-to-tr from-green-500 to-emerald-400 rounded-3xl flex items-center justify-center text-white text-4xl mb-6 shadow-lg shadow-green-200">
                <i class="fab fa-whatsapp"></i>
            </div>
            
            <!-- Text Content -->
            <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Kontak Support</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-8">
                Butuh bantuan terkait sistem SIPES? Hubungi admin melalui WhatsApp untuk respon cepat dan penanganan langsung.
            </p>
            
            <!-- Action Buttons -->
            <div class="w-full space-y-3">
                <a href="https://wa.me/6285697749964" target="_blank" class="w-full py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-2xl shadow-lg shadow-green-100 hover:shadow-xl hover:shadow-green-200 transition-all flex items-center justify-center gap-2 cursor-pointer text-decoration-none">
                    <i class="fab fa-whatsapp text-lg"></i>
                    Hubungi via WhatsApp
                </a>
                <button onclick="closeSupportModal()" class="w-full py-3.5 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold rounded-2xl transition-all cursor-pointer border border-gray-100">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <!-- Support Modal Logic -->
    <script>
        function openSupportModal() {
            const modal = document.getElementById('supportModal');
            const card = modal.querySelector('.relative');
            
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }

        function closeSupportModal() {
            const modal = document.getElementById('supportModal');
            const card = modal.querySelector('.relative');
            
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
            
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
        }
    </script>
    </body>
    </html>
@else
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Laporan - Admin SIPES</title>
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
                font-size: .85rem; font-weight: 600; padding: .5rem 1.2rem;
                border-radius: 10px; cursor: pointer; transition: background .2s, transform .1s;
                font-family: 'Inter', sans-serif;
            }
            .btn-save:hover { background: var(--primary-dk); }
            .btn-save:active { transform: scale(.96); }
            .btn-back {
                background: #eee; color: #555; border: none;
                font-size: .85rem; font-weight: 600; padding: .5rem 1.2rem;
                border-radius: 10px; cursor: pointer; transition: background .2s;
                font-family: 'Inter', sans-serif;
            }
            .btn-back:hover { background: #ddd; }
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
    <body>
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
            <div class="breadcrumb-custom mt-4 mb-4">
                <a href="{{ route('admin.laporan.index') }}" class="btn-back mb-3">
                    <i class="fas fa-arrow-left"></i>Kembali ke Daftar Laporan
                </a>
                <div class="mt-2">
                    <span class="current">Detail Laporan #{{ $report->id }}</span>
                </div>
            </div>
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
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-5">
                            @if($report->photo_path)
                                <img src="{{ asset('storage/' . $report->photo_path) }}" class="img-fluid rounded-3 shadow-sm" alt="Foto Laporan">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <div class="text-center">
                                        <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                        <p class="text-muted">Tidak ada foto</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-8 col-md-7">
                            <div class="mb-3">
                                <span class="text-muted small">Status</span>
                                <div class="mt-1">
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
                                </div>
                            </div>
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $report->location }}
                            </h5>
                            <p class="text-muted">{{ $report->description }}</p>
                            <div class="mt-4 pt-3 border-top">
                                <p class="mb-1">
                                    <i class="fas fa-user-circle text-muted me-2"></i>
                                    <strong>Dibuat oleh:</strong>
                                    {{ $report->user ? $report->user->name : 'Anonim' }}
                                    @if($report->user)
                                        <span class="text-muted">({{ $report->user->email }})</span>
                                    @endif
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock text-muted me-2"></i>
                                    <strong>Tanggal:</strong> {{ $report->created_at->format('d M Y H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Perbarui Status</h6>
                    <form method="POST" action="{{ route('admin.laporan.updateStatus', $report->id) }}" id="form-update-status">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex flex-wrap align-items-end gap-3">
                            <div class="flex-grow-1" style="max-width: 300px;">
                                <label for="status" class="form-label small mb-1 text-muted">Status Baru</label>
                                @php
                                    $currentStatus = $report->status;
                                    $allowedOptions = [];
                                    if(Auth::user()->role === 'admin') {
                                        if(in_array($currentStatus, ['pending','menunggu'])) {
                                            $allowedOptions = ['diverifikasi','ditolak'];
                                        }
                                    } elseif(Auth::user()->role === 'petugas') {
                                        if($currentStatus === 'diverifikasi') {
                                            $allowedOptions = ['diproses'];
                                        } elseif($currentStatus === 'diproses') {
                                            $allowedOptions = ['selesai'];
                                        }
                                    }
                                    $optionLabels = [
                                        'diverifikasi' => 'Diverifikasi',
                                        'ditolak' => 'Ditolak',
                                        'diproses' => 'Diproses',
                                        'selesai' => 'Selesai'
                                    ];
                                @endphp
                                @if(!empty($allowedOptions))
                                    <select name="status" id="status" class="sel-status w-100">
                                        <option value="">Pilih Status...</option>
                                        @foreach($allowedOptions as $opt)
                                            <option value="{{ $opt }}">{{ $optionLabels[$opt] }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <p class="text-muted fst-italic">Tidak ada aksi yang tersedia</p>
                                @endif
                            </div>
                            @if(!empty($allowedOptions))
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.getElementById('form-update-status').addEventListener('submit', function(e) {
                var select = document.getElementById('status');
                var newStatus = select.value;
                var message = '';
                if (newStatus === 'diverifikasi') message = 'Apakah Anda yakin ingin memverifikasi laporan ini?';
                else if (newStatus === 'ditolak') message = 'Apakah Anda yakin ingin menolak laporan ini?';
                else if (newStatus === 'diproses') message = 'Apakah Anda yakin akan mulai menangani laporan ini?';
                else if (newStatus === 'selesai') message = 'Apakah Anda yakin laporan ini telah selesai ditangani?';
                if (message && !confirm(message)) {
                    e.preventDefault();
                }
            });
        </script>
    </body>
    </html>
@endif
