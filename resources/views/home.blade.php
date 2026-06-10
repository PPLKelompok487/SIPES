<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPES - Laporkan Sampah, Wujudkan Lingkungan Bersih</title>
    <!-- Tailwind CSS 4 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .hero-gradient { background: linear-gradient(135deg, #22C55E 0%, #2563EB 100%); }
        .text-gradient { background: linear-gradient(135deg, #22C55E 0%, #2563EB 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 glass border-b border-gray-200" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center text-white text-xl shadow-lg shadow-green-200">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-gray-800">SIPES</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#beranda" class="text-sm font-semibold text-gray-600 hover:text-green-600 transition-colors">Beranda</a>
                    <a href="#tentang" class="text-sm font-semibold text-gray-600 hover:text-green-600 transition-colors">Tentang</a>
                    <a href="#fitur" class="text-sm font-semibold text-gray-600 hover:text-green-600 transition-colors">Fitur</a>
                    <a href="#kontak" class="text-sm font-semibold text-gray-600 hover:text-green-600 transition-colors">Kontak</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-green-600 px-5 py-2.5 rounded-xl hover:bg-green-50 transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 px-5 py-2.5 rounded-xl hover:bg-gray-100 transition-all">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-green-500 px-6 py-2.5 rounded-xl hover:bg-green-600 hover:shadow-lg hover:shadow-green-200 transition-all">Registrasi</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden">
        <!-- Background Shapes -->
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[600px] h-[600px] bg-green-100 rounded-full blur-3xl opacity-50 -z-10"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-[500px] h-[500px] bg-blue-100 rounded-full blur-3xl opacity-50 -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider">
                        <i class="fas fa-star text-[10px]"></i>
                        <span>Sistem Pelaporan Sampah Modern</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                        Laporkan Sampah, Wujudkan Lingkungan yang <span class="text-gradient">Lebih Bersih</span>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-lg mx-auto md:mx-0">
                        SIPES membantu masyarakat melaporkan permasalahan sampah secara cepat, mudah, dan transparan. Bersama kita jaga keasrian lingkungan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-green-500 text-white font-bold rounded-2xl hover:bg-green-600 hover:shadow-xl hover:shadow-green-200 transition-all flex items-center justify-center gap-2">
                            Mulai Melapor <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                        <a href="#tentang" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 font-bold rounded-2xl hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <!-- Illustration Placeholder (Using FontAwesome and Shapes for clean look) -->
                    <div class="relative z-10 w-full aspect-square max-w-md mx-auto flex items-center justify-center bg-white rounded-3xl shadow-2xl border border-gray-100 p-8">
                        <div class="text-center space-y-6">
                            <div class="relative">
                                <i class="fas fa-recycle text-[120px] text-green-500 animate-pulse"></i>
                                <div class="absolute -top-4 -right-4 w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-lg">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="h-4 w-48 bg-gray-100 rounded-full mx-auto"></div>
                                <div class="h-4 w-32 bg-gray-100 rounded-full mx-auto"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative Elements -->
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="p-6 text-center space-y-2">
                    <div class="text-3xl md:text-4xl font-extrabold text-gray-900">{{ number_format($stats['total']) }}</div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Total Laporan</p>
                </div>
                <div class="p-6 text-center space-y-2 border-l border-gray-100">
                    <div class="text-3xl md:text-4xl font-extrabold text-blue-600">{{ number_format($stats['diproses']) }}</div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Laporan Diproses</p>
                </div>
                <div class="p-6 text-center space-y-2 border-l border-gray-100">
                    <div class="text-3xl md:text-4xl font-extrabold text-green-600">{{ number_format($stats['selesai']) }}</div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Laporan Selesai</p>
                </div>
                <div class="p-6 text-center space-y-2 border-l border-gray-100">
                    <div class="text-3xl md:text-4xl font-extrabold text-gray-900">{{ number_format($stats['users']) }}</div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Pengguna Aktif</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">Fitur Utama <span class="text-green-500">SIPES</span></h2>
                <p class="text-gray-600">Berbagai kemudahan yang kami tawarkan untuk membantu Anda menjaga kebersihan lingkungan sekitar.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group text-center">
                    <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-green-500 text-2xl mb-6 mx-auto group-hover:bg-green-500 group-hover:text-white transition-all">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Buat Laporan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Laporkan permasalahan sampah di sekitar Anda hanya dalam hitungan detik.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group text-center">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 text-2xl mb-6 mx-auto group-hover:bg-blue-500 group-hover:text-white transition-all">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pantau Status</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Lihat perkembangan penanganan laporan Anda secara real-time dan transparan.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group text-center">
                    <div class="w-16 h-16 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-500 text-2xl mb-6 mx-auto group-hover:bg-yellow-500 group-hover:text-white transition-all">
                        <i class="fas fa-camera"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Upload Foto</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Sertakan bukti foto kondisi lapangan untuk mempermudah petugas melakukan validasi.</p>
                </div>
                <!-- Feature 4 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group text-center">
                    <div class="w-16 h-16 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500 text-2xl mb-6 mx-auto group-hover:bg-purple-500 group-hover:text-white transition-all">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Transparansi</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Pantau tindak lanjut laporan secara terbuka sebagai wujud layanan publik yang akuntabel.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Workflow Section -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Cara Kerja <span class="text-blue-600">SIPES</span></h2>
                <p class="text-gray-600">Alur pelaporan yang sistematis untuk menjamin setiap laporan tertangani dengan baik.</p>
            </div>

            <div class="relative">
                <!-- Connecting Line -->
                <div class="hidden lg:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-100 -translate-y-1/2"></div>
                
                <div class="grid lg:grid-cols-4 gap-12 lg:gap-8 relative z-10">
                    <!-- Step 1 -->
                    <div class="bg-white text-center space-y-4">
                        <div class="w-16 h-16 bg-white border-4 border-green-500 rounded-full flex items-center justify-center text-green-500 text-xl font-bold mx-auto shadow-lg shadow-green-100">1</div>
                        <h4 class="font-bold text-gray-900">Buat Laporan</h4>
                        <p class="text-sm text-gray-500">Isi detail permasalahan dan unggah foto lokasi.</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="bg-white text-center space-y-4">
                        <div class="w-16 h-16 bg-white border-4 border-blue-500 rounded-full flex items-center justify-center text-blue-500 text-xl font-bold mx-auto shadow-lg shadow-blue-100">2</div>
                        <h4 class="font-bold text-gray-900">Verifikasi Admin</h4>
                        <p class="text-sm text-gray-500">Admin akan meninjau dan memvalidasi laporan Anda.</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="bg-white text-center space-y-4">
                        <div class="w-16 h-16 bg-white border-4 border-yellow-500 rounded-full flex items-center justify-center text-yellow-500 text-xl font-bold mx-auto shadow-lg shadow-yellow-100">3</div>
                        <h4 class="font-bold text-gray-900">Diproses Petugas</h4>
                        <p class="text-sm text-gray-500">Petugas kebersihan terjun langsung ke lokasi.</p>
                    </div>
                    <!-- Step 4 -->
                    <div class="bg-white text-center space-y-4">
                        <div class="w-16 h-16 bg-green-500 border-4 border-white rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto shadow-lg shadow-green-200">4</div>
                        <h4 class="font-bold text-gray-900">Selesai</h4>
                        <p class="text-sm text-gray-500">Lingkungan kembali bersih dan laporan ditutup.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=1470&auto=format&fit=crop" alt="Kebersihan" class="rounded-3xl shadow-2xl grayscale hover:grayscale-0 transition-all duration-700">
                    <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-green-500 rounded-3xl -z-10 animate-pulse"></div>
                </div>
                <div class="space-y-6">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Membangun Budaya Bersih Bersama <span class="text-green-500">SIPES</span></h2>
                    <p class="text-gray-600 leading-relaxed">
                        SIPES hadir sebagai jembatan komunikasi antara masyarakat dan pemerintah dalam upaya menjaga kebersihan lingkungan. Kami percaya bahwa setiap laporan Anda adalah langkah nyata menuju kota yang lebih asri dan sehat.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Dengan teknologi, kami memangkas birokrasi dan memastikan setiap pengaduan masyarakat didengar serta ditindaklanjuti secara akuntabel oleh petugas di lapangan.
                    </p>
                    <div class="pt-4 flex items-center gap-4">
                        <div class="flex -space-x-3 overflow-hidden">
                            <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                        </div>
                        <span class="text-sm font-bold text-gray-700 font-bold">1,000+ Warga telah berkontribusi</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="hero-gradient rounded-[40px] p-8 md:p-16 text-center text-white relative overflow-hidden shadow-2xl shadow-green-200">
                <!-- Decorative circles -->
                <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute bottom-0 right-0 translate-x-1/2 translate-y-1/2 w-96 h-96 bg-white opacity-10 rounded-full"></div>

                <div class="relative z-10 space-y-8">
                    <h2 class="text-3xl md:text-5xl font-extrabold leading-tight">Mulai berkontribusi menjaga<br>lingkungan sekarang.</h2>
                    <p class="text-lg opacity-90 max-w-xl mx-auto">Bergabunglah dengan ribuan warga lainnya dalam mewujudkan lingkungan yang lebih bersih dan sehat.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="px-10 py-4 bg-white text-green-600 font-extrabold rounded-2xl hover:scale-105 transition-all shadow-xl">Daftar Sekarang</a>
                        <a href="{{ route('login') }}" class="px-10 py-4 border-2 border-white text-white font-extrabold rounded-2xl hover:bg-white hover:text-green-600 transition-all">Login Pengguna</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-gray-900 pt-20 pb-10 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <!-- Column 1 -->
                <div class="col-span-2 space-y-6">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center text-white text-xl">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight">SIPES</span>
                    </div>
                    <p class="text-gray-400 max-w-sm">
                        Sistem Pelaporan Sampah digital untuk mempermudah masyarakat dalam menjaga kebersihan kota secara kolaboratif.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-green-500 transition-all"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-green-500 transition-all"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-green-500 transition-all"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                
                <!-- Column 2 -->
                <div class="space-y-6">
                    <h4 class="text-lg font-bold">Navigasi</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#beranda" class="hover:text-green-400 transition-colors">Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-green-400 transition-colors">Tentang</a></li>
                        <li><a href="#fitur" class="hover:text-green-400 transition-colors">Fitur</a></li>
                    </ul>
                </div>

                <!-- Column 3 -->
                <div class="space-y-6">
                    <h4 class="text-lg font-bold">Kontak Kami</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-green-500"></i>
                            <span>support@sipes.id</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-green-500"></i>
                            <span>(021) 123-4567</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt text-green-500"></i>
                            <span>Gedung SIPES, Jakarta</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
                <p>&copy; 2026 SIPES - Sistem Pelaporan Sampah. Seluruh Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('py-4', 'shadow-lg');
                navbar.classList.remove('h-20');
            } else {
                navbar.classList.remove('py-4', 'shadow-lg');
                navbar.classList.add('h-20');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>