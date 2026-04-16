<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIPES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
</head>
<body>
    <div class="main-container">
        <div class="brand-section">
            <div class="brand-content">
                <div class="brand-logo-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h1 class="brand-title">SIPES</h1>
                <p class="brand-description">
                    Sistem Pelaporan Sampah Lingkungan yang Terintegrasi dan Modern.
                </p>
                
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> Lapor sampah lebih cepat</li>
                    <li><i class="fas fa-check-circle"></i> Pantau status pembersihan</li>
                    <li><i class="fas fa-check-circle"></i> Wujudkan lingkungan asri</li>
                </ul>
            </div>
        </div>

        <div class="form-section">
            <div class="register-card">
                <h2 class="form-header-title text-center text-lg-start">Daftar Akun Baru</h2>

                @if ($errors && $errors->any())
                    <div class="alert alert-danger p-2 mb-4" style="font-size: 0.85rem; border-radius: 10px;">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">NAMA LENGKAP</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ALAMAT EMAIL</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Alamat Email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">KATEGORI PENGGUNA</label>
                        <select class="form-select" name="role" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="pelapor">Masyarakat (Pelapor)</option>
                            <option value="petugas">Petugas Kebersihan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">PASSWORD</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">KONFIRMASI PASSWORD</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-register">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>

                <div class="text-center login-text">
                    Sudah memiliki akun? <a href="{{ route('login') }}" class="login-link">Login Sipes</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>