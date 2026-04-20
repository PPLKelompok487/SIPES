<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIPES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .profile-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 2.5rem;
            color: #fff;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .avatar-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #43e97b, #38f9d7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: bold;
            color: #0f2027;
            margin: 0 auto 1rem auto;
            box-shadow: 0 8px 24px rgba(67,233,123,0.4);
        }
        .info-row {
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255,255,255,0.08);
        }
        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #43e97b;
            margin-bottom: 0.25rem;
        }
        .info-value {
            font-size: 1rem;
            color: #fff;
            font-weight: 500;
        }
        .badge-role {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
            color: #0f2027;
            font-size: 0.8rem;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-weight: 600;
        }
        .btn-edit-profile {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
            color: #0f2027;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }
        .btn-edit-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(67,233,123,0.4);
            color: #0f2027;
        }
        .btn-change-pass {
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-change-pass:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateY(-2px);
        }
        .alert-success-custom {
            background: rgba(67, 233, 123, 0.15);
            border: 1px solid rgba(67,233,123,0.4);
            color: #43e97b;
            border-radius: 12px;
            padding: 1rem 1.5rem;
        }
        .sipes-header {
            color: #43e97b;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="sipes-header"><i class="fas fa-leaf me-2"></i>SIPES</span>
            <a href="/" class="btn btn-sm btn-outline-light rounded-pill px-3">
                <i class="fas fa-home me-1"></i> Beranda
            </a>
        </div>

        <!-- Alert sukses -->
        @if(session('success'))
            <div class="alert-success-custom mb-4">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Notif DEV mode --}}
        @if(session('info'))
            <div class="alert alert-warning mb-4 rounded-3" style="font-size:0.85rem;">
                <i class="fas fa-code me-2"></i>{{ session('info') }} <strong>[MODE DEVELOPMENT]</strong>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="profile-card">
                    <!-- Avatar -->
                    <div class="text-center mb-4">
                        <div class="avatar-circle">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <span class="badge-role">
                            <i class="fas fa-user me-1"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <!-- Info -->
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-user me-1"></i> Nama Lengkap</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-envelope me-1"></i> Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-shield-alt me-1"></i> Role / Peran</div>
                        <div class="info-value">{{ ucfirst($user->role) }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-calendar me-1"></i> Bergabung sejak</div>
                        <div class="info-value">{{ $user->created_at->format('d F Y') }}</div>
                    </div>

                    <!-- Tombol aksi -->
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-edit-profile">
                            <i class="fas fa-edit me-2"></i>Edit Profil
                        </a>
                        <a href="{{ route('profile.edit-password') }}" class="btn btn-change-pass">
                            <i class="fas fa-lock me-2"></i>Ganti Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
