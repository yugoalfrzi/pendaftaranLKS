@extends('layouts.app')

@section('title', 'Dashboard Super Admin')
@section('page-title', 'Dashboard')

@section('content')
<style>
    .stat-card {
        background: #fff; 
        border-radius: 1.25rem;
        border: 1px solid rgba(203,213,225,0.4);
        transition: all 0.2s; 
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }
    .stat-card:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 10px 20px -10px rgba(0,0,0,0.1); 
    }
    .stat-icon {
        width: 44px; 
        height: 44px; 
        border-radius: 1rem;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 1.2rem;
    }
    .stat-value { 
        font-size: 1.7rem; 
        font-weight: 700; 
        color: #0f172a; 
        line-height: 1.1; 
    }
    .stat-label { 
        font-size: .68rem; 
        font-weight: 600; 
        text-transform: uppercase; 
        letter-spacing: .04em; 
    }
    .card-modern {
        border-radius: 1.25rem; 
        border: 1px solid #edf2f7;
        background: #fff; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.02); 
        overflow: hidden;
    }
    .card-header-custom {
        background: #fff; 
        border-bottom: 1px solid #eef2f6;
        padding: 0.9rem 1.25rem; 
        font-weight: 600; 
        font-size: 0.9rem;
    }
    .chart-wrap { 
        position: relative; 
        width: 100%; 
        min-height: 280px; }
    .quick-action {
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center;
        gap: 0.5rem; 
        padding: 1.2rem 0.5rem; 
        border-radius: 1rem;
        border: 1.5px solid #e2e8f0; 
        background: #fff; 
        text-decoration: none;
        color: #334155; 
        transition: all 0.2s; 
        font-size: 0.82rem; 
        font-weight: 500;
    }
    .quick-action:hover { 
        border-color: #2563eb; 
        background: #eef2ff; 
        color: #1e40af; }
    .quick-action i { 
        font-size: 1.5rem; }
    @media (max-width: 768px) {
        .stat-value { 
            font-size: 1.4rem; 
        }
        .chart-wrap { 
            min-height: 220px; 
        }
    }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-semibold mb-1">
            <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard Super Admin
        </h1>
        <p class="text-muted small mb-0">Selamat datang, <strong>{{ auth()->user()->name }}</strong> &mdash; Sistem Pendaftaran LKS Jawa Barat</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('superadmin.index') }}" class="btn btn-primary rounded-pill px-4 btn-sm">
            <i class="bi bi-shield-check me-1"></i> Panel Verifikasi
        </a>
        <a href="{{ route('superadmin.pending-users') }}" class="btn btn-outline-warning rounded-pill px-4 btn-sm">
            <i class="bi bi-person-check me-1"></i> Persetujuan Akun
        </a>
    </div>
</div>

{{-- Stat Cards Kewenangan --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted stat-label">Total LKS Se-JABAR</div>
                    <div class="stat-value">{{ number_format($totalLKSJabar) }}</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-buildings"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted stat-label">Kewenangan Kab/Kota</div>
                    <div class="stat-value">{{ number_format($kewenanganKabkota) }}</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-geo-alt"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted stat-label">Kewenangan Provinsi</div>
                    <div class="stat-value">{{ number_format($kewenanganProvinsi) }}</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-building"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted stat-label">Kewenangan Kemensos</div>
                    <div class="stat-value">{{ number_format($kewenanganKemensos) }}</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-bank2"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Stat Cards Pendaftaran --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="border-left: 4px solid #2563eb;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted stat-label">Total Pendaftaran</div>
                    <div class="stat-value text-primary">{{ number_format($totalLKS) }}</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-file-earmark-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="border-left: 4px solid #16a34a;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted stat-label">Dokumen Lengkap</div>
                    <div class="stat-value text-success">{{ number_format($lengkapLKS) }}</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="border-left: 4px solid #eab308;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted stat-label">Menunggu Verifikasi</div>
                    <div class="stat-value text-warning">{{ number_format($menungguLKS) }}</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="border-left: 4px solid #0891b2;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted stat-label">Diterima</div>
                    <div class="stat-value text-info">{{ number_format($diterimaLKS) }}</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-patch-check"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
@if($totalLKSJabar > 0 || $totalLKS > 0)
<div class="row g-3 mb-4">
    {{-- Donut Kewenangan --}}
    <div class="col-md-4">
        <div class="card-modern h-100">
            <div class="card-header-custom"><i class="bi bi-pie-chart me-2"></i>Distribusi Kewenangan</div>
            <div class="card-body p-3">
                @if($kewenanganChartData['total'] > 0)
                    <div class="chart-wrap"><canvas id="kewenanganChart"></canvas></div>
                    <div class="row mt-3 text-center g-0">
                        <div class="col-4">
                            <div class="fw-bold text-primary small">{{ number_format($kewenanganKabkota) }}</div>
                            <div class="text-muted" style="font-size:.7rem">Kab/Kota</div>
                            <div class="text-muted" style="font-size:.68rem">{{ $kewenanganChartData['percentages'][0] }}%</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-success small">{{ number_format($kewenanganProvinsi) }}</div>
                            <div class="text-muted" style="font-size:.7rem">Provinsi</div>
                            <div class="text-muted" style="font-size:.68rem">{{ $kewenanganChartData['percentages'][1] }}%</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-info small">{{ number_format($kewenanganKemensos) }}</div>
                            <div class="text-muted" style="font-size:.7rem">Kemensos</div>
                            <div class="text-muted" style="font-size:.68rem">{{ $kewenanganChartData['percentages'][2] }}%</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5 text-muted"><i class="bi bi-pie-chart fs-1"></i><p class="mt-2 small">Belum ada data</p></div>
                @endif
            </div>
        </div>
    </div>

    {{-- Donut Status + Trend --}}
    <div class="col-md-8">
        <div class="row g-3 h-100">
            <div class="col-12">
                <div class="card-modern">
                    <div class="card-header-custom"><i class="bi bi-graph-up me-2"></i>Trend Pendaftaran 6 Bulan Terakhir</div>
                    <div class="card-body p-3">
                        <div class="chart-wrap" style="min-height:220px"><canvas id="trendChart"></canvas></div>
                    </div>
                </div>
            </div>
            @if($totalLKS > 0)
            <div class="col-12">
                <div class="card-modern">
                    <div class="card-header-custom"><i class="bi bi-bar-chart me-2"></i>Status Permohonan Pendaftaran</div>
                    <div class="card-body p-3">
                        <div class="chart-wrap" style="min-height:180px"><canvas id="statusChart"></canvas></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Bar Chart Distribusi Kab/Kota --}}
@if($totalLKSJabar > 0)
<div class="card-modern mb-4">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-map me-2"></i>Distribusi LKS per Kabupaten/Kota <small class="text-muted ms-1">(27 Kab/Kota)</small></span>
        <small class="text-muted">Total: {{ number_format($totalLKSJabar) }} LKS</small>
    </div>
    <div class="card-body p-3">
        <div class="chart-wrap" style="min-height:260px"><canvas id="kabupatenChart"></canvas></div>
    </div>
</div>
@endif

@else
<div class="card-modern text-center py-5 mb-4">
    <i class="bi bi-graph-up fs-1 text-muted"></i>
    <h5 class="text-muted mt-3">Belum Ada Data</h5>
    <p class="text-muted small">Data chart akan muncul setelah ada pendaftaran LKS</p>
</div>
@endif

{{-- Akses Cepat --}}
<div class="card-modern">
    <div class="card-header-custom"><i class="bi bi-lightning me-2"></i>Akses Cepat</div>
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-6 col-md-3">
                <a href="{{ route('superadmin.index') }}" class="quick-action">
                    <i class="bi bi-shield-check text-primary"></i>
                    <span>Panel Verifikasi</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('superadmin.pending-users') }}" class="quick-action">
                    <i class="bi bi-person-check text-warning"></i>
                    <span>Persetujuan Akun</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('superadmin.rptka.index') }}" class="quick-action">
                    <i class="bi bi-file-earmark-person" style="color:#4338ca"></i>
                    <span>Verval RPTKA</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('kewenangan-kabkota.index') }}" class="quick-action">
                    <i class="bi bi-database text-info"></i>
                    <span>Data LKS JABAR</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Kewenangan Donut
    @if($kewenanganChartData['total'] > 0)
    new Chart(document.getElementById('kewenanganChart'), {
        type: 'doughnut',
        data: {
            labels: @json($kewenanganChartData['labels']),
            datasets: [{
                data: @json($kewenanganChartData['data']),
                backgroundColor: @json($kewenanganChartData['colors']),
                borderColor: '#fff', borderWidth: 3, hoverOffset: 12,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '60%',
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 11 } } } }
        }
    });
    @endif

    // Trend Chart
    const trendData = @json($monthlyTrend);
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: Object.keys(trendData),
            datasets: [{
                label: 'Pendaftaran LKS',
                data: Object.values(trendData),
                borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,0.07)',
                fill: true, tension: 0.35,
                pointBackgroundColor: '#2563eb', pointBorderColor: '#fff', pointRadius: 4,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // Status Donut
    @if($totalLKS > 0)
    const statusColors = {
        'Menunggu': '#fbbf24', 'Menunggu kelengkapan data': '#fcd34d',
        'Diterima untuk proses': '#60a5fa', 'Diterima': '#34d399',
        'Terverifikasi': '#818cf8', 'Ditolak': '#f87171', 'Dikembalikan': '#38bdf8',
    };
    const statusData = @json($statusData);
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: Object.keys(statusData).map(k => statusColors[k] || '#94a3b8'),
                borderRadius: 6, borderWidth: 0,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, indexAxis: 'y',
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, grid: { color: '#f1f5f9' } },
                y: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        }
    });
    @endif

    // Kabupaten Bar Chart
    @if($totalLKSJabar > 0)
    const kabupatenData = @json($kabupatenData);
    const semuaKab = [
        'Kabupaten Bogor','Kabupaten Sukabumi','Kabupaten Cianjur','Kabupaten Bandung',
        'Kabupaten Garut','Kabupaten Tasikmalaya','Kabupaten Ciamis','Kabupaten Kuningan',
        'Kabupaten Cirebon','Kabupaten Majalengka','Kabupaten Sumedang','Kabupaten Indramayu',
        'Kabupaten Subang','Kabupaten Purwakarta','Kabupaten Karawang','Kabupaten Bekasi',
        'Kabupaten Bandung Barat','Kabupaten Pangandaran','Kota Bogor','Kota Sukabumi',
        'Kota Bandung','Kota Cirebon','Kota Bekasi','Kota Depok','Kota Cimahi',
        'Kota Tasikmalaya','Kota Banjar',
    ];
    const kabLabels = semuaKab.map(k => k.replace('Kabupaten ', 'Kab. '));
    const kabValues = semuaKab.map(k => kabupatenData[k] || 0);
    new Chart(document.getElementById('kabupatenChart'), {
        type: 'bar',
        data: {
            labels: kabLabels,
            datasets: [{
                label: 'Jumlah LKS',
                data: kabValues,
                backgroundColor: kabValues.map((v, i) => v > 0 ? `hsl(${210 + (i * 8) % 120}, 65%, 65%)` : '#e2e8f0'),
                borderRadius: 6, borderWidth: 0,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, grid: { color: '#f1f5f9' } },
                x: { ticks: { maxRotation: 45, minRotation: 45, font: { size: 9 } }, grid: { display: false } }
            },
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { title: ctx => semuaKab[ctx[0].dataIndex], label: ctx => `${ctx.raw} LKS` } }
            }
        }
    });
    @endif
});
</script>
@endpush
