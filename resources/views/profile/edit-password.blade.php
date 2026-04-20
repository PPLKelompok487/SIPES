<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - SIPES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .form-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 2.5rem;
            color: #fff;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .form-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #43e97b;
            margin-bottom: 0.4rem;
        }
        .input-wrapper { position: relative; }
        .form-control {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            color: #fff;
            border-radius: 12px;
            padding: 0.75rem 3rem 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.12);
            border-color: #43e97b;
            box-shadow: 0 0 0 3px rgba(67,233,123,0.15);
            color: #fff;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.4); }
        .toggle-pass {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255,255,255,0.4);
            background: none;
            border: none;
            padding: 0;
            transition: color 0.2s;
        }
        .toggle-pass:hover { color: #43e97b; }
        .btn-save {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
            color: #0f2027;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(67,233,123,0.4);
            color: #0f2027;
        }
        .btn-back {
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 12px;
            padding: 0.75rem 2rem;
            width: 100%;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-back:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .alert-danger-custom {
            background: rgba(220,53,69,0.15);
            border: 1px solid rgba(220,53,69,0.4);
            color: #ff8a9b;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
        }
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: rgba(255,255,255,0.1);
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
            color: rgba(255,255,255,0.5);
        }
        .sipes-header {
            color: #43e97b;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 2px;
        }
        .page-title { font-size: 1.4rem; font-weight: 700; margin-bottom: 0.25rem; }
        .page-subtitle { color: rgba(255,255,255,0.5); font-size: 0.875rem; }
    </style>
</head>
<body>
    <div class="container py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="sipes-header"><i class="fas fa-leaf me-2"></i>SIPES</span>
            <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="form-card">
                    <div class="mb-4">
                        <div class="page-title"><i class="fas fa-lock me-2" style="color:#43e97b"></i>Ganti Password</div>
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
