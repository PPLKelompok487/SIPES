<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporkan Sampah - SIPES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #2d6a4f;
            --accent-green: #52b788;
            --soft-green: #d8f3dc;
            --dark-green: #1b4332;
        }
        body { background-color: #f4f7f6; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
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
        .navbar-brand i { margin-right: 10px; }
        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .nav-link:hover, .nav-link.active { color: white !important; }
        
        .page-header { margin: 2rem 0 1rem; }
        .report-card { border-radius: 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .form-label { font-weight: 600; }
        .btn-primary { background: var(--primary-green); border: none; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}"><i class="fas fa-leaf me-2"></i>SIPES</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.index') }}">Laporan Saya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">
        @if(session('success'))
            <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session('info'))
            <div id="toast-info" class="toast align-items-center text-bg-info border-0" role="alert" aria-live="polite" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('info') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <div class="container">
        <div class="page-header text-center">
            <h1 class="display-6">Laporkan Sampah</h1>
            <p class="text-muted">Berikan deskripsi, lokasi, dan foto untuk membantu petugas membersihkan dengan cepat.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card report-card p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Sampah</label>
                            <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <button class="btn btn-sm btn-success" id="use-location-btn" type="button">
                                    <i class="fas fa-map-marker-alt me-1"></i>Gunakan Lokasi Saya
                                </button>
                                <span id="location-status" class="text-muted small">Real-time lokasi akan ditampilkan di sini.</span>
                            </div>
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" placeholder="Contoh: Jl. Sudirman No.5, Jakarta" required>
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto Sampah</label>
                            <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
                            <div class="form-text">Unggah foto yang jelas agar petugas dapat menangani laporan dengan tepat.</div>
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toastSuccess = document.getElementById('toast-success');
        const toastInfo = document.getElementById('toast-info');

        document.addEventListener('DOMContentLoaded', () => {
            if (toastSuccess) {
                new bootstrap.Toast(toastSuccess, { delay: 5000 }).show();
            }
            if (toastInfo) {
                new bootstrap.Toast(toastInfo, { delay: 5000 }).show();
            }
        });

        const useLocationBtn = document.getElementById('use-location-btn');
        const locationInput = document.getElementById('location');
        const locationStatus = document.getElementById('location-status');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const reverseLocationUrl = '{{ route('location.reverse') }}';

        async function reverseGeocode(lat, lon) {
            const internalUrl = `${reverseLocationUrl}?lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`;

            try {
                const response = await fetch(internalUrl, { credentials: 'same-origin' });
                if (!response.ok) {
                    throw new Error(`Internal API error (${response.status})`);
                }

                return await response.json();
            } catch (internalError) {
                const fallbackUrl = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`;
                const fallbackResponse = await fetch(fallbackUrl);
                if (!fallbackResponse.ok) {
                    throw new Error('Gagal memuat alamat dari layanan fallback.');
                }

                return await fallbackResponse.json();
            }
        }

        useLocationBtn?.addEventListener('click', () => {
            if (!navigator.geolocation) {
                locationStatus.textContent = 'Browser Anda tidak mendukung geolokasi.';
                return;
            }

            useLocationBtn.disabled = true;
            locationStatus.textContent = 'Mengambil lokasi saat ini...';

            navigator.geolocation.getCurrentPosition(async (position) => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                try {
                    const data = await reverseGeocode(lat, lon);
                    locationInput.value = data.display_name || `${lat}, ${lon}`;
                    latitudeInput.value = data.lat || lat;
                    longitudeInput.value = data.lon || lon;
                    locationStatus.textContent = 'Lokasi berhasil diisi otomatis.';
                } catch (error) {
                    locationStatus.textContent = `Gagal mengambil lokasi: ${error.message}`;
                } finally {
                    useLocationBtn.disabled = false;
                }
            }, (error) => {
                useLocationBtn.disabled = false;
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        locationStatus.textContent = 'Izin lokasi ditolak. Izinkan akses lokasi untuk menggunakan fitur ini.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        locationStatus.textContent = 'Lokasi tidak tersedia. Coba lagi nanti.';
                        break;
                    case error.TIMEOUT:
                        locationStatus.textContent = 'Pengambilan lokasi kedaluwarsa. Coba lagi.';
                        break;
                    default:
                        locationStatus.textContent = 'Terjadi kesalahan saat mengambil lokasi.';
                }
            }, {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 10000,
            });
        });
    </script>
</body>
</html>
