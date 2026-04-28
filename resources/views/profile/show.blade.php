<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIPES</title>
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
            background-color: var(--bg-color);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .avatar-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(45, 106, 79, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-green);
            margin: 0 auto 1rem auto;
            border: 3px solid var(--soft-green);
        }
        .info-row {
            background: var(--bg-color);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--accent-green);
            margin-bottom: 0.25rem;
        }
        .info-value {
            font-size: 1rem;
            color: var(--dark-green);
            font-weight: 500;
        }
        .badge-role {
            background: var(--soft-green);
            color: var(--dark-green);
            font-size: 0.8rem;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-weight: 600;
        }
        .btn-edit-profile {
            background: var(--primary-green);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }
        .btn-edit-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45, 106, 79, 0.2);
            color: white;
            background: var(--dark-green);
        }
        .btn-change-pass {
            background: white;
            color: var(--primary-green);
            border: 1px solid var(--primary-green);
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-change-pass:hover {
            background: var(--soft-green);
            color: var(--dark-green);
            transform: translateY(-2px);
        }
        .alert-success-custom {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 12px;
            padding: 1rem 1.5rem;
        }
        .sipes-header {
            color: var(--primary-green);
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
            <a href="/dashboard" class="btn btn-sm btn-outline-success rounded-pill px-3">
                <i class="fas fa-home me-1"></i> Dashboard
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
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto Profil" class="avatar-circle" style="object-fit:cover; border-radius:50%;">
                        @else
                            <div class="avatar-circle">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
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
