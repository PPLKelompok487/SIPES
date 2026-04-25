<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - SIPES</title>
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
        .input-wrapper { position: relative; }
        .form-control {
            background: var(--bg-color);
            border: 1px solid rgba(0,0,0,0.1);
            color: var(--dark-green);
            border-radius: 12px;
            padding: 0.75rem 3rem 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: white;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.15);
            color: var(--dark-green);
        }
        .form-control::placeholder { color: #aaa; }
        .toggle-pass {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            background: none;
            border: none;
            padding: 0;
            transition: color 0.2s;
        }
        .toggle-pass:hover { color: var(--primary-green); }
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
        .btn-back:hover { background: var(--soft-green); color: var(--dark-green); }
        .alert-danger-custom {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
        }
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: #e9ecef;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .strength-text {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            color: #6c757d;
        }
        .sipes-header {
            color: var(--primary-green);
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 2px;
        }
        .page-title { font-size: 1.4rem; font-weight: 700; margin-bottom: 0.25rem; color: var(--dark-green); }
        .page-subtitle { color: #6c757d; font-size: 0.875rem; }
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
                        <div class="page-title"><i class="fas fa-lock me-2" style="color:var(--primary-green)"></i>Ganti Password</div>
                        <div class="page-subtitle">Pastikan gunakan password yang kuat dan aman</div>
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

                    <form method="POST" action="{{ route('profile.update-password') }}">
                        @csrf
                        @method('PUT')

                        <!-- Password Lama -->
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-key me-1"></i> Password Saat Ini</label>
                            <div class="input-wrapper">
                                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password saat ini" required>
                                <button type="button" class="toggle-pass" onclick="togglePass('current_password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-lock me-1"></i> Password Baru</label>
                            <div class="input-wrapper">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter" required oninput="checkStrength(this.value)">
                                <button type="button" class="toggle-pass" onclick="togglePass('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                            <div class="strength-text" id="strengthText">Masukkan password baru</div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-check-double me-1"></i> Konfirmasi Password Baru</label>
                            <div class="input-wrapper">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required>
                                <button type="button" class="toggle-pass" onclick="togglePass('password_confirmation', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>Simpan Password Baru
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
    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function checkStrength(val) {
            const fill = document.getElementById('strengthFill');
            const text = document.getElementById('strengthText');
            let strength = 0;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            const levels = [
                { pct: '0%',   color: 'transparent', label: 'Masukkan password baru' },
                { pct: '25%',  color: '#ff4d4d',      label: '⚠️ Lemah' },
                { pct: '50%',  color: '#ffa500',      label: '🟠 Cukup' },
                { pct: '75%',  color: '#43e97b',      label: '✅ Kuat' },
                { pct: '100%', color: '#38f9d7',      label: '💪 Sangat Kuat' },
            ];

            fill.style.width = levels[strength].pct;
            fill.style.background = levels[strength].color;
            text.textContent = levels[strength].label;
        }
    </script>
</body>
</html>
