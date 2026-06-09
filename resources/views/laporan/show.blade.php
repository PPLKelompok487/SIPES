<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - SIPES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #2d6a4f;
            --accent-green: #52b788;
            --soft-green: #d8f3dc;
            --dark-green: #1b4332;
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

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            margin: 0 10px;
        }

        .nav-link:hover {
            color: white !important;
        }

        /* Page Header */
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
        }

        /* Detail Card */
        .detail-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow: hidden;
            border: none;
        }

        .detail-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .status-badge {
            padding: 0.5rem 1.2rem;
            border-radius: 50rem;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .info-label {
            color: #6c757d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .info-value {
            color: var(--dark-green);
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .btn-back {
            background: var(--soft-green);
            color: var(--dark-green);
            border: none;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: var(--light-green);
            color: var(--dark-green);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-leaf me-2"></i>
                SIPES
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('laporan.index') }}">Daftar Laporan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="dashboard-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="dashboard-title mb-0">Detail Laporan</h1>
                <a href="{{ route('laporan.index') }}" class="btn-back text-decoration-none">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="detail-card">
                    @if($report->photo_path)
                        <img src="{{ asset('storage/' . $report->photo_path) }}" alt="Foto Laporan" class="detail-image">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif

                    <div class="p-4 p-md-5">
                        @php
                            $statusMap = [
                                'pending'      => ['class' => 'bg-warning text-dark',  'label' => 'Menunggu'],
                                'menunggu'     => ['class' => 'bg-warning text-dark',  'label' => 'Menunggu'],
                                'diverifikasi' => ['class' => 'bg-info text-white',    'label' => 'Diverifikasi'],
                                'diproses'     => ['class' => 'text-white',            'label' => 'Diproses', 'style' => 'background:#fd7e14;'],
                                'selesai'      => ['class' => 'bg-success text-white', 'label' => 'Selesai'],
                                'ditolak'      => ['class' => 'bg-danger text-white',  'label' => 'Ditolak'],
                            ];
                            $s = $statusMap[$report->status] ?? $statusMap['menunggu'];
                        @endphp

                        <div class="mb-4">
                            <span class="status-badge {{ $s['class'] }}" @if(isset($s['style'])) style="{{ $s['style'] }}" @endif>
                                {{ $s['label'] }}
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="info-label">Deskripsi Laporan</div>
                                <h4 class="info-value mb-4">{{ $report->description }}</h4>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-label">Lokasi</div>
                                <div class="info-value">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                    {{ $report->location }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-label">Tanggal Lapor</div>
                                <div class="info-value">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                    {{ $report->created_at->format('d F Y') }}
                                    <small class="text-muted ms-1">({{ $report->created_at->format('H:i') }})</small>
                                </div>
                            </div>
                        </div>

                        @if($report->latitude && $report->longitude)
                        <div class="mt-3">
                            <div class="info-label">Koordinat</div>
                            <div class="info-value">
                                <code class="bg-light p-2 rounded">
                                    {{ $report->latitude }}, {{ $report->longitude }}
                                </code>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>