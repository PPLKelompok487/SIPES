<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI PES - Sistem Pelaporan Kebersihan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #2d6a4f;
            --accent-green: #52b788;
            --soft-green: #d8f3dc;
            --dark-green: #1b4332;
            --light-green: #95d5b2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            color: var(--primary-green) !important;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .nav-link {
            color: var(--dark-green) !important;
            font-weight: 500;
            margin: 0 15px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent-green) !important;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-green) 100%);
            color: white;
            padding: 150px 0 100px;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -200px;
            right: -200px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-description {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .btn-hero {
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            margin: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-hero {
            background: white;
            color: var(--primary-green);
            border: 2px solid white;
        }

        .btn-primary-hero:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary-hero {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary-hero:hover {
            background: white;
            color: var(--primary-green);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-green);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 3rem;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            border: none;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--soft-green), var(--light-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: var(--primary-green);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-green);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
        }

        /* Roles Section */
        .roles-section {
            padding: 100px 0;
            background: white;
        }

        .role-card {
            background: linear-gradient(135deg, var(--soft-green), white);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            border: 2px solid var(--light-green);
        }

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            border-color: var(--accent-green);
        }

        .role-icon {
            width: 70px;
            height: 70px;
            background: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
            color: white;
        }

        .role-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-green);
            margin-bottom: 1rem;
        }

        .role-description {
            color: #666;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background: var(--dark-green);
            color: white;
            padding: 3rem 0;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-description {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .feature-card, .role-card {
                margin-bottom: 2rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-leaf"></i>
                SI PES
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content animate-fade-in">
                        <h1 class="hero-title">Laporkan Masalah Kebersihan dengan Mudah</h1>
                        <p class="hero-description">
                            Sistem pelaporan kebersihan modern yang membantu masyarakat melaporkan masalah kebersihan dan memantau status penanganan secara real-time.
                        </p>
                        <div class="hero-buttons">
                            <a href="{{ route('register') }}" class="btn-hero btn-primary-hero">
                                <i class="fas fa-plus-circle me-2"></i>Mulai Lapor
                            </a>
                            <a href="{{ route('login') }}" class="btn-hero btn-secondary-hero">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Kemudahan dalam setiap langkah pelaporan kebersihan</p>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="feature-title">Lapor Masalah</h3>
                        <p class="feature-description">
                            Laporkan masalah kebersihan dengan mudah melalui form yang user-friendly. Tambah foto dan lokasi untuk informasi lebih lengkap.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Pantau Status</h3>
                        <p class="feature-description">
                            Pantau status penanganan laporan Anda secara real-time. Dapatkan notifikasi saat ada pembaruan dari petugas.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="feature-title">Respon Cepat</h3>
                        <p class="feature-description">
                            Sistem yang terintegrasi dengan petugas kebersihan untuk memastikan respon cepat dan penanganan yang efektif.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section class="roles-section">
        <div class="container">
            <h2 class="section-title">Peran Pengguna</h2>
            <p class="section-subtitle">Sistem dirancang untuk berbagai jenis pengguna</p>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="role-card">
                        <div class="role-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="role-title">Pelapor</h3>
                        <p class="role-description">
                            Masyarakat umum yang dapat melaporkan masalah kebersihan, melihat status laporan, dan memberikan feedback setelah penanganan.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="role-card">
                        <div class="role-icon">
                            <i class="fas fa-broom"></i>
                        </div>
                        <h3 class="role-title">Petugas</h3>
                        <p class="role-description">
                            Petugas kebersihan yang menerima laporan, memperbarui status penanganan, dan mengelola jadwal pembersihan.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="role-card">
                        <div class="role-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="role-title">Admin</h3>
                        <p class="role-description">
                            Administrator sistem yang mengelola pengguna, memantau statistik, dan mengatur konfigurasi sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 SI PES - Sistem Pelaporan Kebersihan. All rights reserved.</p>
            <p class="mt-2">
                <i class="fas fa-code me-2"></i>
                Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk lingkungan yang lebih bersih
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 5px 30px rgba(0, 0, 0, 0.15)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            }
        });
    </script>
</body>
</html>
