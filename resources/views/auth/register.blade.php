<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIPES (Sistem Pelaporan Sampah)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #2d6a4f;
            --accent-green: #52b788;
            --soft-green: #d8f3dc;
            --dark-green: #1b4332;
        }

        body {
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .main-container {
            width: 100%;
            min-height: 100vh;
            display: flex;
        }

        /* Sisi Kiri: Branding */
        .brand-section {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Efek Dekorasi Lingkaran di Background */
        .brand-section::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }

        .brand-logo {
            font-size: 5rem;
            margin-bottom: 20px;
            text-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .brand-title {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 10px;
        }

        .brand-tagline {
            font-size: 1.2rem;
            opacity: 0.8;
            max-width: 400px;
        }

        /* Sisi Kanan: Form */
        .form-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px;
            background-color: #fcfdfc;
        }

        .register-box {
            width: 100%;
            max-width: 450px;
        }

        .form-title {
            color: var(--dark-green);
            font-weight: 700;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #555;
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1.5px solid #e0e0e0;
            background-color: #fff;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-green);
            box-shadow: 0 0 0 0.25rem rgba(82, 183, 136, 0.1);
        }

        .btn-register {
            background-color: var(--primary-green);
            border: none;
            padding: 14px;
            font-weight: 600;
            border-radius: 8px;
            color: white;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background-color: var(--dark-green);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .text-link {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }
            .brand-section {
                padding: 60px 20px;
                flex: none;
            }
            .brand-title { font-size: 2.5rem; }
            .form-section { padding: 40px 20px; }
        }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="brand-section">
            <div class="brand-logo">
                <i class="fas fa-leaf"></i>
            </div>
            <h1 class="brand-title">SIPES</h1>
            <p class="brand-tagline">Sistem Pelaporan Sampah Lingkungan yang Terintegrasi dan Modern.</p>
            
            <div class="mt-5 d-none d-lg-block">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-check-circle me-3"></i> <span>Lapor sampah lebih cepat</span>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-check-circle me-3"></i> <span>Pantau status pembersihan</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3"></i> <span>Wujudkan lingkungan asri</span>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="register-box">
                <h2 class="form-title">Daftar Akun Baru</h2>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">NAMA LENGKAP</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">ALAMAT EMAIL</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">KATEGORI PENGGUNA</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="pelapor" {{ old('role') == 'pelapor' ? 'selected' : '' }}>Pelapor (Masyarakat)</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas Kebersihan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">PASSWORD</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Min. 8 Karakter" required>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">KONFIRMASI PASSWORD</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-register">
                            DAFTAR SEKARANG
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted small">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-link">Login Sipes</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>