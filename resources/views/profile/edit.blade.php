<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - SIPES</title>
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
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .form-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--accent-green);
            margin-bottom: 0.4rem;
        }
        .form-control {
            background: var(--bg-color);
            border: 1px solid rgba(0,0,0,0.1);
            color: var(--dark-green);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: white;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.15);
            color: var(--dark-green);
        }
        .form-control::placeholder { color: #aaa; }
        .form-control:disabled {
            background: #e9ecef;
            color: #6c757d;
        }
        .btn-save {
            background: var(--primary-green);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45, 106, 79, 0.2);
            color: white;
            background: var(--dark-green);
        }
        .btn-back {
            background: transparent;
            color: var(--primary-green);
            border: 1px solid var(--primary-green);
            border-radius: 12px;
            padding: 0.75rem 2rem;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background: var(--soft-green);
            color: var(--dark-green);
        }
        .alert-danger-custom {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
        }
        .sipes-header {
            color: var(--primary-green);
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 2px;
        }
        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--dark-green);
        }
        .page-subtitle {
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="sipes-header"><i class="fas fa-leaf me-2"></i>SIPES</span>
            <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="form-card">
                    <div class="mb-4">
                        <div class="page-title"><i class="fas fa-user-edit me-2" style="color:var(--primary-green)"></i>Edit Profil</div>
                        <div class="page-subtitle">Perbarui nama dan email akun Anda</div>
                    </div>

                    @if($errors->any())
                        <div class="alert-danger-custom mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-user me-1"></i> Nama Lengkap</label>
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Nama Lengkap"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-envelope me-1"></i> Alamat Email</label>
                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                placeholder="Alamat Email"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-shield-alt me-1"></i> Role / Peran</label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ ucfirst($user->role) }}"
                                disabled
                            >
                            <small class="text-white-50 mt-1 d-block">Role tidak dapat diubah sendiri</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('profile.show') }}" class="btn btn-back text-center">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
