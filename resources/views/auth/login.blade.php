<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
            <div class="login-card">
                <h2 class="form-header-title text-center text-lg-start">Masuk ke Akun</h2>

                @if (session('success'))
                    <div class="alert alert-success p-2 mb-4" style="font-size: 0.85rem; border-radius: 10px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors && $errors->any())
                    <div class="alert alert-danger p-2 mb-4" style="font-size: 0.85rem; border-radius: 10px;">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">ALAMAT EMAIL</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Alamat Email" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">PASSWORD</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-size: 0.9rem; color: #555;">Ingat Saya</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="text-center login-text">
                    Belum memiliki akun? <a href="{{ route('register') }}" class="login-link">Daftar Sipes</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
