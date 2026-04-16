@extends('layouts.app')

@section('title', 'Dashboard LKS')

@section('content')
    <style>
        /* Gaya modern khas SIPINJAM */
        .stat-card {
            background: #ffffff;
            border-radius: 1.5rem;
            border: 1px solid rgba(203, 213, 225, 0.4);
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            height: 100%;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -12px rgba(0,0,0,0.1);
            border-color: #cbd5e1;
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            background: #eef2ff;
            border-radius: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 1.4rem;
        }
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }
        .card-modern {
            border-radius: 1.5rem;
            border: 1px solid #edf2f7;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            transition: box-shadow 0.2s;
            overflow: hidden;
        }
        .card-modern:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        }
        .card-header-custom {
            background: #ffffff;
            border-bottom: 1px solid #eef2f6;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        .btn-outline-soft {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #334155;
            border-radius: 2rem;
            padding: 0.3rem 1rem;
            font-size: 0.8rem;
            transition: 0.2s;
        }
        .btn-outline-soft:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        .table-modern {
            margin-bottom: 0;
        }
        .table-modern th {
            background: #f8fafc;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #475569;
            padding: 0.8rem 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .table-modern td {
            padding: 0.8rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.85rem;
        }
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.2rem 0.7rem;
            border-radius: 2rem;
            font-size: 0.7rem;
            font-weight: 500;
        }
        .badge-diterima { background: #e6f7e6; color: #2e7d32; }
        .badge-menunggu { background: #fef3c7; color: #b45309; }
        .badge-ditolak { background: #fee2e2; color: #b91c1c; }
        .badge-lengkap { background: #e0e7ff; color: #1e40af; }
        .chart-container {
            position: relative;
            width: 100%;
            min-height: 320px;
        }
        @media (max-width: 768px) {
            .stat-value { font-size: 1.4rem; }
            .chart-container { min-height: 260px; }
            .table-modern th, .table-modern td { padding: 0.5rem; }
        }
    </style>
    
    <!-- Header Dashboard -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-semibold mb-1">
                <i class="bi bi-speedometer2 me-2" style="color: #2563eb;"></i> Dashboard LKS
            </h1>
            <p class="text-muted small mb-0">Selamat datang, {{ auth()->user()->name }} | Sistem Pendaftaran LKS Jawa Barat</p>
        </div>
        <a href="{{ route('lks.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Pendaftaran Baru
        </a>
    </div>
    
    <!-- Statistik Utama (Kewenangan) -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Total LKS Se-JABAR</div>
                        <div class="stat-value">{{ number_format($totalLKSJabar) }}</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-buildings"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Kabupaten/Kota</div>
                        <div class="stat-value">{{ number_format($kewenanganKabkota) }}</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-geo-alt"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Provinsi</div>
                        <div class="stat-value">{{ number_format($kewenanganProvinsi) }}</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-building"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Kemensos</div>
                        <div class="stat-value">{{ number_format($kewenanganKemensos) }}</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-bank2"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistik Pendaftaran Baru -->
    <div class="row g-4 mb-5">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card p-3 bg-primary text-white" style="background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="small opacity-75">Total Pendaftaran</div>
                        <div class="stat-value text-white">{{ number_format($totalLKS) }}</div>
                    </div>
                    <i class="bi bi-file-earmark-text fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card p-3 bg-success text-white" style="background: linear-gradient(135deg, #16a34a, #15803d) !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="small opacity-75">Lengkap</div>
                        <div class="stat-value text-white">{{ number_format($lengkapLKS) }}</div>
                    </div>
                    <i class="bi bi-check-circle fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card p-3 bg-warning text-white" style="background: linear-gradient(135deg, #eab308, #ca8a04) !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="small opacity-75">Menunggu Verifikasi</div>
                        <div class="stat-value text-white">{{ number_format($menungguLKS) }}</div>
                    </div>
                    <i class="bi bi-clock fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card p-3 bg-info text-white" style="background: linear-gradient(135deg, #0891b2, #0e7490) !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="small opacity-75">Diterima</div>
                        <div class="stat-value text-white">{{ number_format($diterimaLKS) }}</div>
                    </div>
                    <i class="bi bi-check-lg fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    @if($totalLKSJabar > 0 || $totalLKS > 0)
    <div class="row g-4 mb-5">
        <!-- Diagram Lingkaran Kewenangan -->
        <div class="col-md-5">
            <div class="card-modern">
                <div class="card-header-custom">
                    <i class="bi bi-pie-chart me-2"></i> Distribusi Kewenangan LKS
                </div>
                <div class="card-body p-4">
                    @if($kewenanganChartData['total'] > 0)
                        <div class="chart-container">
                            <canvas id="kewenanganChart"></canvas>
                        </div>
                        <div class="row mt-3 text-center">
                            <div class="col-4">
                                <div class="fw-bold text-primary">{{ number_format($kewenanganKabkota) }}</div>
                                <small class="text-muted">Kab/Kota</small>
                                <br><small class="text-muted">{{ $kewenanganChartData['percentages'][0] }}%</small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold text-success">{{ number_format($kewenanganProvinsi) }}</div>
                                <small class="text-muted">Provinsi</small>
                                <br><small class="text-muted">{{ $kewenanganChartData['percentages'][1] }}%</small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold text-info">{{ number_format($kewenanganKemensos) }}</div>
                                <small class="text-muted">Kemensos</small>
                                <br><small class="text-muted">{{ $kewenanganChartData['percentages'][2] }}%</small>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-pie-chart fs-1"></i>
                            <p class="mt-2">Belum ada data kewenangan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    
        <!-- Distribusi Kabupaten/Kota (Bar Chart) -->
        <div class="col-md-7">
            <div class="card-modern">
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <i class="bi bi-map me-2"></i> Distribusi LKS per Kabupaten/Kota
                        <small class="text-muted ms-2">(27 Kab/Kota)</small>
                    </div>
                    <small class="text-muted">Total: {{ number_format($totalLKSJabar) }} LKS</small>
                </div>
                <div class="card-body p-4">
                    @if($totalLKSJabar > 0)
                        <div class="chart-container">
                            <canvas id="kabupatenChart"></canvas>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-map fs-1"></i>
                            <p class="mt-2">Belum ada data LKS dari kewenangan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Status Permohonan & Trend -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-modern">
                <div class="card-header-custom">
                    <i class="bi bi-pie-chart me-2"></i> Status Permohonan
                </div>
                <div class="card-body p-4">
                    <div class="chart-container" style="min-height: 280px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card-modern">
                <div class="card-header-custom">
                    <i class="bi bi-graph-up me-2"></i> Trend Pendaftaran 6 Bulan Terakhir
                </div>
                <div class="card-body p-4">
                    <div class="chart-container" style="min-height: 280px;">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="card-modern text-center py-5 mb-5">
        <i class="bi bi-graph-up fs-1 text-muted"></i>
        <h4 class="text-muted mt-3">Belum Ada Data</h4>
        <p class="text-muted">Data chart akan muncul setelah ada pendaftaran LKS</p>
        <a href="{{ route('lks.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle"></i> Mulai Pendaftaran Pertama
        </a>
    </div>
    @endif
    
    <!-- Akses Cepat ke Kewenangan -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="card-modern">
                <div class="card-header-custom">
                    <i class="bi bi-lightning me-2"></i> Akses Cepat ke Data Kewenangan
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('kewenangan-kabkota.index') }}" class="btn btn-outline-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2 rounded-pill">
                                <i class="bi bi-building fs-5"></i>
                                <span>Kabupaten/Kota <span class="badge bg-primary ms-1">{{ number_format($kewenanganKabkota) }}</span></span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('kewenangan-provinsi.index') }}" class="btn btn-outline-success w-100 py-3 d-flex align-items-center justify-content-center gap-2 rounded-pill">
                                <i class="bi bi-building-fill fs-5"></i>
                                <span>Provinsi <span class="badge bg-success ms-1">{{ number_format($kewenanganProvinsi) }}</span></span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('kewenangan-kemensos.index') }}" class="btn btn-outline-info w-100 py-3 d-flex align-items-center justify-content-center gap-2 rounded-pill">
                                <i class="bi bi-house-gear fs-5"></i>
                                <span>Kemensos <span class="badge bg-info ms-1">{{ number_format($kewenanganKemensos) }}</span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pendaftaran Terbaru -->
    @if($totalLKS > 0)
    <div class="row g-4">
        <div class="col-12">
            <div class="card-modern">
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap">
                    <div><i class="bi bi-clock-history me-2"></i> Pendaftaran Terbaru</div>
                    <a href="{{ route('lks.index') }}" class="btn-outline-soft btn-sm">Lihat Semua <i class="bi bi-arrow-right-short"></i></a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr><th>No</th><th>Nama LKS</th><th>Kabupaten/Kota</th><th>Tanggal Masuk</th><th>Status</th><th>Kelengkapan</th>@if(auth()->user()->role === 'admin')<th>Aksi</th>@endif</tr>
                            </thead>
                            <tbody>
                                @foreach($recentLKS as $lks)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $lks->nama_lks }}</td>
                                    <td><span class="badge bg-light text-dark">{{ $lks->kabupaten_kota ?: $lks->lokasi_lks }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($lks->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge-status {{ $lks->status_permohonan == 'Diterima' ? 'badge-diterima' : ($lks->status_permohonan == 'Menunggu' ? 'badge-menunggu' : 'badge-ditolak') }}">
                                            {{ $lks->status_permohonan ?? 'Menunggu' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-status {{ $lks->pendaftaran_lengkap ? 'badge-diterima' : 'badge-menunggu' }}">
                                            {{ $lks->pendaftaran_lengkap ? 'Lengkap' : 'Tidak Lengkap' }}
                                        </span>
                                    </td>
                                    @if(auth()->user()->role === 'admin')
                                    <td>
                                        <a href="{{ route('lks.show', $lks->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Modal Status Permohonan (otomatis muncul) -->
    @if(isset($latestLks) && auth()->check() && $latestLks->user_id === auth()->id() && in_array($latestLks->status_permohonan, ['Proses Verifikasi', 'Diterima untuk proses', 'Diterima', 'Ditolak', 'Dikembalikan']))
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                @php
                    $status = $latestLks->status_permohonan;
                    $isAccepted = $status === 'Diterima untuk proses';
                    $isRejected = $status === 'Ditolak';
                    $isReturned = $status === 'Dikembalikan';
                    $headerClass = $isAccepted ? 'bg-success' : ($isRejected ? 'bg-danger' : 'bg-warning');
                    $icon = $isAccepted ? 'bi-check-circle' : ($isRejected ? 'bi-x-circle' : 'bi-arrow-counterclockwise');
                @endphp
                <div class="modal-header {{ $headerClass }} text-white border-0">
                    <h5 class="modal-title"><i class="bi {{ $icon }} me-2"></i> Status: {{ $status }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($isAccepted)
                        <div class="alert alert-success">Permohonan Anda telah diterima untuk proses. Tim verifikasi akan melanjutkan pemeriksaan dokumen.</div>
                    @elseif($isRejected)
                        <div class="alert alert-danger">Permohonan Anda ditolak.</div>
                        <div class="mb-2"><strong>Alasan penolakan:</strong><div class="border rounded p-2 bg-light mt-1">{{ $latestLks->alasan_penolakan ?? 'Tidak ada alasan.' }}</div></div>
                    @elseif($isReturned)
                        <div class="alert alert-warning">Permohonan Anda dikembalikan untuk perbaikan.</div>
                        <div class="mb-2"><strong>Alasan pengembalian:</strong><div class="border rounded p-2 bg-light mt-1">{{ $latestLks->alasan_dikembalikan ?? 'Tidak ada alasan.' }}</div></div>
                    @endif
                    <small class="text-muted">Terakhir diperbarui: {{ optional($latestLks->updated_at)->format('d/m/Y H:i') }}</small>
                </div>
                <div class="modal-footer border-0">
                    <a href="{{ route('lks.show', $latestLks->id) }}" class="btn btn-outline-primary rounded-pill px-4">Lihat Detail</a>
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    
@endsection

@push('scripts')
@if($totalLKSJabar > 0 || $totalLKS > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Kewenangan (Doughnut)
        @if($kewenanganChartData['total'] > 0)
        const kewenanganCtx = document.getElementById('kewenanganChart').getContext('2d');
        new Chart(kewenanganCtx, {
            type: 'doughnut',
            data: {
                labels: @json($kewenanganChartData['labels']),
                datasets: [{
                    data: @json($kewenanganChartData['data']),
                    backgroundColor: @json($kewenanganChartData['colors']),
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15 } } }
            }
        });
        @endif

        // Chart Kabupaten (Bar)
        @if($totalLKSJabar > 0)
        const kabupatenData = @json($kabupatenData);
        const semuaKabupatenKota = [
            'Kabupaten Bogor', 'Kabupaten Sukabumi', 'Kabupaten Cianjur', 'Kabupaten Bandung',
            'Kabupaten Garut', 'Kabupaten Tasikmalaya', 'Kabupaten Ciamis', 'Kabupaten Kuningan',
            'Kabupaten Cirebon', 'Kabupaten Majalengka', 'Kabupaten Sumedang', 'Kabupaten Indramayu',
            'Kabupaten Subang', 'Kabupaten Purwakarta', 'Kabupaten Karawang', 'Kabupaten Bekasi',
            'Kabupaten Bandung Barat', 'Kabupaten Pangandaran', 'Kota Bogor', 'Kota Sukabumi',
            'Kota Bandung', 'Kota Cirebon', 'Kota Bekasi', 'Kota Depok', 'Kota Cimahi',
            'Kota Tasikmalaya', 'Kota Banjar'
        ];
        const chartLabels = semuaKabupatenKota.map(k => k.replace('Kabupaten ', 'Kab. ').replace('Kota ', ''));
        const chartData = semuaKabupatenKota.map(k => kabupatenData[k] || 0);
        const colors = chartData.map((v, i) => v > 0 ? `hsl(${200 + (i * 7) % 360}, 70%, 70%)` : '#e2e8f0');

        const kabupatenCtx = document.getElementById('kabupatenChart').getContext('2d');
        new Chart(kabupatenCtx, {
            type: 'bar',
            data: { labels: chartLabels, datasets: [{ label: 'Jumlah LKS', data: chartData, backgroundColor: colors, borderRadius: 8 }] },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }, x: { ticks: { maxRotation: 45, minRotation: 45, font: { size: 9 } } } },
                plugins: { tooltip: { callbacks: { title: (ctx) => semuaKabupatenKota[ctx[0].dataIndex], label: (ctx) => `${ctx.raw} LKS` } } }
            }
        });
        @endif

        // Chart Status
        @if($totalLKS > 0)
        const statusData = @json($statusData);
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData),
                datasets: [{ data: Object.values(statusData), backgroundColor: ['#16a34a', '#eab308', '#dc2626', '#94a3b8'], borderWidth: 0 }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });

        // Trend Bulanan
        const monthlyTrend = @json($monthlyTrend);
        const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: Object.keys(monthlyTrend),
                datasets: [{ label: 'Pendaftaran', data: Object.values(monthlyTrend), borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,0.05)', fill: true, tension: 0.3, pointBackgroundColor: '#2563eb', pointBorderColor: '#fff', pointRadius: 4 }]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
        @endif
    });

    // Modal status (hanya sekali)
    @if(isset($latestLks) && auth()->check() && $latestLks->user_id === auth()->id() && in_array($latestLks->status_permohonan, ['Proses Verifikasi', 'Diterima untuk proses', 'Diterima', 'Ditolak', 'Dikembalikan']))
    if (!sessionStorage.getItem('statusModalShown')) {
        var modalEl = document.getElementById('statusModal');
        if (modalEl) {
            var modal = new bootstrap.Modal(modalEl);
            modal.show();
            sessionStorage.setItem('statusModalShown', '1');
        }
    }
    @endif
</script>
@endif
@endpush