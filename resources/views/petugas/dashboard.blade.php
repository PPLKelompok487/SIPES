<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - SIPES</title>
    <!-- Tailwind CSS 4 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Leaflet CSS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #F3F4F6; }
        .sidebar-link.active {
            background-color: #22C55E;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.4);
        }
        #map { height: 350px; border-radius: 0.75rem; z-index: 1; }
        @keyframes bounce-short {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .animate-bounce-short {
            animation: bounce-short 2.4s infinite ease-in-out;
        }
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
            <a href="{{ route('dashboard') }}" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-xl transition-all">
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
            <a href="{{ route('admin.laporan.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
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
                <!-- Notifications -->
                <button class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-all">
                    <i class="fas fa-bell"></i>
                    @if($stats['menunggu'] > 0)
                        <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">
                            {{ $stats['menunggu'] }}
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
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Monitoring</h1>
                <p class="text-gray-500">Selamat bekerja, mari jaga kebersihan kota bersama SIPES.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Laporan</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Menunggu</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['menunggu'] }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-truck-loading"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Diproses</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['diproses'] }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Selesai</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['selesai'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column (2/3) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Map Card -->
                    <div class="bg-white p-1 rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 flex items-center justify-between">
                            <h2 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-map-marked-alt text-green-500"></i>
                                Peta Sebaran Sampah
                            </h2>
                            <span class="text-xs font-medium text-gray-400">Update Real-time</span>
                        </div>
                        <div id="map"></div>
                    </div>

                    <!-- Recent Reports Table -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                            <h2 class="font-bold text-gray-800">Daftar Laporan Terbaru</h2>
                            <a href="{{ route('admin.laporan.index') }}" class="text-sm font-bold text-green-600 hover:text-green-700">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-gray-400 text-xs font-bold uppercase tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4">Laporan</th>
                                        <th class="px-6 py-4">Lokasi</th>
                                        <th class="px-6 py-4">Tanggal</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($recentReports as $report)
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
                                                    'diproses' => 'bg-blue-100 text-blue-700',
                                                    'selesai' => 'bg-green-100 text-green-700',
                                                    'ditolak' => 'bg-red-100 text-red-700',
                                                    'diverifikasi' => 'bg-sky-100 text-sky-700',
                                                ];
                                                $statusClass = $statusClasses[$report->status] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                                                {{ $report->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('admin.laporan.show', $report->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-50 text-green-600 hover:bg-green-500 hover:text-white transition-all">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column (1/3) -->
                <div class="space-y-8">
                    
                    <!-- Priority Tasks -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="font-bold text-gray-800">Tugas Prioritas</h2>
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                        </div>
                        <div class="space-y-4">
                            @forelse($priorityReports as $report)
                            <div class="group p-4 rounded-xl border border-gray-100 hover:border-green-200 hover:bg-green-50 transition-all cursor-pointer">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-bold text-red-500 uppercase tracking-widest">Sangat Penting</span>
                                    <span class="text-[10px] text-gray-400">{{ $report->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm font-bold text-gray-800 mb-1 group-hover:text-green-700 transition-colors">{{ Str::limit($report->description, 50) }}</p>
                                <p class="text-xs text-gray-500 mb-3"><i class="fas fa-map-marker-alt mr-1"></i>{{ $report->location }}</p>
                                <a href="{{ route('admin.laporan.show', $report->id) }}" class="text-xs font-bold text-green-600 flex items-center gap-1 hover:gap-2 transition-all">
                                    Tangani Sekarang <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300">
                                    <i class="fas fa-tasks fa-2x"></i>
                                </div>
                                <p class="text-sm text-gray-400 font-medium">Tidak ada tugas mendesak.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Activity (Timeline) -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h2 class="font-bold text-gray-800 mb-6">Aktivitas Terbaru</h2>
                        <div class="relative space-y-6 before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-gray-200 before:via-gray-100 before:to-transparent">
                            @foreach($recentReports as $report)
                            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-100 text-gray-500 group-hover:bg-green-500 group-hover:text-white shadow-sm z-10 transition-all duration-300">
                                    <i class="fas fa-plus text-[10px]"></i>
                                </div>
                                <div class="flex-1 ml-4">
                                    <div class="text-sm font-bold text-gray-800">Laporan Baru Masuk</div>
                                    <div class="text-xs text-gray-500">Laporan #{{ $report->id }} dari {{ $report->user->name ?? 'Warga' }}</div>
                                    <div class="text-[10px] text-gray-400 mt-1">{{ $report->created_at->format('H:i') }} WIB</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Leaflet JS for Map -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Map
            const map = L.map('map').setView([-6.200000, 106.816666], 12); // Default to Jakarta
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add Markers
            const reports = @json($mapReports);
            const markers = [];

            reports.forEach(report => {
                if(report.latitude && report.longitude) {
                    const marker = L.marker([report.latitude, report.longitude])
                        .addTo(map)
                        .bindPopup(`
                            <div class="p-2">
                                <p class="font-bold text-gray-800 text-sm mb-1">${report.description.substring(0, 30)}...</p>
                                <p class="text-xs text-gray-500 mb-2"><i class="fas fa-map-marker-alt mr-1"></i>${report.location}</p>
                                <a href="/admin/laporan/${report.id}" class="text-[10px] font-bold text-green-600 uppercase hover:underline">Lihat Detail</a>
                            </div>
                        `);
                    markers.push(marker);
                }
            });

            if (markers.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Support Modal -->
    <div id="supportModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <!-- Backdrop with blur -->
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-md transition-all duration-300" onclick="closeSupportModal()"></div>
        
        <!-- Modal content with scale-in animation -->
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 max-w-md w-full mx-4 p-6 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out z-10" id="supportModalContent">
            <!-- Close Button -->
            <button onclick="closeSupportModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center transition-all cursor-pointer">
                <i class="fas fa-times"></i>
            </button>

            <div class="flex flex-col items-center text-center mt-2">
                <!-- Icon/Visual element with gradient background -->
                <div class="w-16 h-16 bg-gradient-to-tr from-green-400 to-emerald-600 rounded-full flex items-center justify-center text-white text-3xl shadow-lg shadow-green-200 mb-4 animate-bounce-short">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <!-- Title -->
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hubungi Kontak Support</h3>
                <p class="text-sm text-gray-500 mb-6 px-4">
                    Ada kendala dengan sistem SIPES? Hubungi tim support kami melalui WhatsApp untuk respon cepat.
                </p>

                <!-- Number Info Card -->
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 w-full mb-6 flex items-center justify-center gap-3">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">No. WhatsApp:</span>
                    <span class="text-sm font-bold text-gray-800">+62 856-9774-9964</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 w-full">
                    <button onclick="closeSupportModal()" class="w-full sm:w-1/3 py-3 px-4 border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold rounded-xl text-sm transition-all cursor-pointer">
                        Batal
                    </button>
                    <a href="https://wa.me/6285697749964" target="_blank" rel="noopener noreferrer" onclick="closeSupportModal()" class="w-full sm:w-2/3 py-3 px-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2 shadow-lg shadow-green-200 hover:shadow-green-300 transition-all cursor-pointer">
                        <i class="fab fa-whatsapp text-lg"></i>
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Support Modal -->
    <script>
        function openSupportModal() {
            const modal = document.getElementById('supportModal');
            const content = document.getElementById('supportModalContent');
            
            modal.classList.remove('hidden');
            
            // Force a reflow
            modal.offsetHeight;
            
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }

        function closeSupportModal() {
            const modal = document.getElementById('supportModal');
            const content = document.getElementById('supportModalContent');
            
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>