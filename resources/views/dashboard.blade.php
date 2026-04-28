<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SI PES</title>
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

        /* Dashboard Content */
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

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-right: 1.5rem;
        }

        .stat-icon.primary { background: rgba(45, 106, 79, 0.1); color: var(--primary-green); }
        .stat-icon.warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .stat-icon.success { background: rgba(40, 167, 69, 0.1); color: #28a745; }

        .stat-details h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
            color: var(--dark-green);
        }

        .stat-details p {
            margin-bottom: 0;
            color: #6c757d;
            font-weight: 500;
        }

        /* Quick Actions */
        .action-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
            border: 2px solid transparent;
        }

        .action-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-green);
            color: inherit;
        }

        .action-icon {
            font-size: 2.5rem;
            color: var(--primary-green);
            margin-bottom: 1rem;
        }

        .action-title {
            font-weight: 600;
            color: var(--dark-green);
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-leaf"></i>
                SI PES
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a>
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

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1 class="dashboard-title">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
            <p class="dashboard-subtitle">Ini adalah ringkasan aktivitas dan laporan Anda hari ini.</p>
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

        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-details">
                        <h3>0</h3>
                        <p>Total Laporan Anda</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-details">
                        <h3>0</h3>
                        <p>Laporan Diproses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-details">
                        <h3>0</h3>
                        <p>Laporan Selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Row -->
        <h4 class="mb-3 text-secondary fw-bold" style="font-size: 1.1rem;">Akses Cepat</h4>
        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="{{ route('reports.create') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h5 class="action-title">Buat Laporan Baru</h5>
                    <p class="text-muted small mb-0">Laporkan masalah kebersihan di sekitar Anda.</p>
                </a>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
