<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan - SIPES</title>
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

        .report-card { border-radius: 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .badge-status { font-size: 0.85rem; }
        .report-image { max-width: 120px; border-radius: 10px; object-fit: cover; }
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
                    @if(Auth::user()->role === 'pelapor')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.create') }}">Lapor Baru</a>
                    </li>
                    @endif
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

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3">Riwayat Laporan</h1>
                <p class="text-muted mb-0">Laporan sampah yang Anda kirim sebagai pelapor.</p>
            </div>
            @if(Auth::user()->role === 'pelapor')
            <a href="{{ route('reports.create') }}" class="btn btn-success"><i class="fas fa-plus me-2"></i>Tambah Laporan</a>
            @endif
        </div>

        @if($reports->isEmpty())
            <div class="alert alert-info">Belum ada laporan. Mulai laporkan sampah di sekitar Anda.</div>
        @else
            <div class="row gy-3">
                @foreach($reports as $report)
                    @php
                        $statusMap = [
                            'pending'      => ['bg' => 'warning', 'text' => 'text-dark', 'label' => 'Menunggu'],
                            'menunggu'     => ['bg' => 'warning', 'text' => 'text-dark', 'label' => 'Menunggu'],
                            'diverifikasi' => ['bg' => 'info',    'text' => 'text-white','label' => 'Diverifikasi'],
                            'diproses'     => ['bg' => 'info',    'text' => 'text-white','label' => 'Diproses'],
                            'processing'   => ['bg' => 'info',    'text' => 'text-white','label' => 'Diproses'],
                            'selesai'      => ['bg' => 'success', 'text' => 'text-white','label' => 'Selesai'],
                            'ditolak'      => ['bg' => 'danger',  'text' => 'text-white','label' => 'Ditolak'],
                        ];
                        $s = $statusMap[$report->status] ?? ['bg' => 'secondary', 'text' => 'text-white', 'label' => ucfirst($report->status)];
                    @endphp
                    <div class="col-lg-12">
                        <div class="card report-card p-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-2 text-center">
                                    <img src="{{ asset('storage/' . $report->photo_path) }}" alt="Foto laporan" class="report-image img-fluid">
                                </div>
                                <div class="col-md-7">
                                    <h5 class="mb-1">{{ \Illuminate\Support\Str::limit($report->description, 80) }}</h5>
                                    <p class="mb-1 text-muted"><strong>Lokasi:</strong> {{ $report->location }}</p>
                                    <p class="mb-0 text-secondary">Dilaporkan oleh <strong>{{ Auth::user()->name }}</strong> pada {{ $report->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="badge bg-{{ $s['bg'] }} badge-status {{ $s['text'] }}">
                                        {{ $s['label'] }}
                                    </span>
                                    <form method="POST" action="{{ route('reports.destroy', $report) }}" class="d-inline-block mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus laporan ini?');">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastSuccess = document.getElementById('toast-success');
            const toastInfo = document.getElementById('toast-info');

            if (toastSuccess) {
                new bootstrap.Toast(toastSuccess, { delay: 5000 }).show();
            }

            if (toastInfo) {
                new bootstrap.Toast(toastInfo, { delay: 5000 }).show();
            }
        });
    </script>
</body>
</html>
