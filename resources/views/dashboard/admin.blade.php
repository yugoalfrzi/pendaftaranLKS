@extends('layouts.app')

@section('title', 'Dashboard Admin')
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
        width: 44px; height: 44px; 
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
    .table-modern th {
        background: #f8fafc; 
        font-size: 0.72rem; 
        text-transform: uppercase;
        letter-spacing: 0.04em; 
        color: #475569; 
        padding: 0.7rem 1rem;
        border-bottom: 1px solid #e2e8f0; 
        white-space: nowrap;
    }
    .table-modern td {
        padding: 0.7rem 1rem; 
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9; 
        font-size: 0.83rem;
    }
    .badge-pill {
        display: inline-flex; 
        align-items: center; 
        gap: 0.25rem;
        padding: 0.2rem 0.65rem; 
        border-radius: 2rem;
        font-size: 0.7rem; 
        font-weight: 500;
    }
    .s-menunggu    { 
        background:#fef3c7; 
        color:#b45309; 
    }
    .s-proses      { 
        background:#dbeafe; 
        color:#1d4ed8; 
    }
    .s-diterima    { 
        background:#dcfce7; 
        color:#15803d; 
    }
    .s-terverifikasi { 
        background:#e0e7ff; 
        color:#4338ca; 
    }
    .s-ditolak     { 
        background:#fee2e2; 
        color:#b91c1c; 
    }
    .s-dikembalikan{ 
        background:#e0f2fe; 
        color:#0369a1; 
    }
    .chart-wrap { 
        position:relative; 
        width:100%; 
        min-height:260px; 
    }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-semibold mb-1">
            <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard Admin
        </h1>
        <p class="text-muted small mb-0">
            {{ auth()->user()->name }}
            @if($kabkota)
                &mdash; <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold">
                    <i class="bi bi-geo-alt me-1"></i>{{ $kabkota }}
                </span>
            @endif
        </p>
    </div>
    <a href="{{ route('admin.lks.index') }}" class="btn btn-primary rounded-pill px-4 btn-sm">
        <i class="bi bi-list-check me-1"></i> Panel Verifikasi
    </a>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size:.7rem">Total LKS</div>
                    <div class="stat-value">{{ $totalLKS }}</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-buildings"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size:.7rem">Menunggu</div>
                    <div class="stat-value text-warning">{{ $menunggu }}</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size:.7rem">Diterima</div>
                    <div class="stat-value text-success">{{ $diterima + $terverifikasi }}</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size:.7rem">Ditolak</div>
                    <div class="stat-value text-danger">{{ $ditolak }}</div>
                </div>
                <div class="stat-icon bg-danger bg-opacity-10 text-danger"><i class="bi bi-x-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size:.7rem">Dikembalikan</div>
                    <div class="stat-value text-info">{{ $dikembalikan }}</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-arrow-counterclockwise"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size:.7rem">Diterima Proses</div>
                    <div class="stat-value text-primary">{{ $diterimaProses }}</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="row g-3 mb-4">
    <div class="col-md-5">
        <div class="card-modern h-100">
            <div class="card-header-custom"><i class="bi bi-pie-chart me-2"></i>Status Permohonan LKS</div>
            <div class="card-body p-3">
                @if($totalLKS > 0)
                    <div class="chart-wrap"><canvas id="statusChart"></canvas></div>
                @else
                    <div class="text-center py-5 text-muted"><i class="bi bi-pie-chart fs-1"></i><p class="mt-2 small">Belum ada data</p></div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card-modern h-100">
            <div class="card-header-custom"><i class="bi bi-graph-up me-2"></i>Trend Pendaftaran LKS (6 Bulan)</div>
            <div class="card-body p-3">
                <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel LKS Terbaru --}}
<div class="card-modern mb-4">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2"></i>Pendaftaran LKS Terbaru</span>
        <a href="{{ route('admin.lks.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.78rem">
            Lihat Semua <i class="bi bi-arrow-right-short"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama LKS</th>
                    <th>Pemohon</th>
                    <th>Kewenangan</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLKS as $lks)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $lks->nama_lks }}</td>
                    <td>{{ $lks->user?->name ?? '—' }}</td>
                    <td>
                        <span class="badge-pill {{ $lks->kewenangan_type === 'kabkota' ? 's-proses' : 's-terverifikasi' }}">
                            {{ $lks->kewenangan_type === 'kabkota' ? 'Kab/Kota' : 'Provinsi' }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($lks->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $sc = match($lks->status_permohonan) {
                                'Menunggu','Menunggu kelengkapan data' => 's-menunggu',
                                'Diterima untuk proses' => 's-proses',
                                'Diterima' => 's-diterima',
                                'Terverifikasi' => 's-terverifikasi',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        @endphp
                        <span class="badge-pill {{ $sc }}">{{ $lks->status_permohonan }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.show', $lks->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.75rem">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pendaftaran LKS</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Tabel RPTKA Terbaru --}}
@if($totalRptka > 0)
<div class="card-modern">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-file-earmark-person me-2"></i>Permohonan RPTKA Terbaru</span>
        <a href="{{ route('admin.rptka.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.78rem">
            Lihat Semua <i class="bi bi-arrow-right-short"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama LKS</th>
                    <th>Pemohon TKA</th>
                    <th>Jenis</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRptka as $rptka)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $rptka->nama_lks }}</td>
                    <td>{{ $rptka->nama_tka_pemohon }}</td>
                    <td><span class="badge-pill s-proses">{{ $rptka->permohonan_rptka }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($rptka->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $sc = match($rptka->status_permohonan) {
                                'Menunggu' => 's-menunggu',
                                'Diterima' => 's-diterima',
                                'Terverifikasi' => 's-terverifikasi',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        @endphp
                        <span class="badge-pill {{ $sc }}">{{ $rptka->status_permohonan }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.rptka.verification', $rptka->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.75rem">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Status Chart
    @if($totalLKS > 0)
    const statusData = @json($statusData);
    const statusColors = {
        'Menunggu': '#fbbf24', 'Menunggu kelengkapan data': '#fcd34d',
        'Diterima untuk proses': '#60a5fa', 'Diterima': '#34d399',
        'Terverifikasi': '#818cf8', 'Ditolak': '#f87171', 'Dikembalikan': '#38bdf8',
    };
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: Object.keys(statusData).map(k => statusColors[k] || '#94a3b8'),
                borderWidth: 2, borderColor: '#fff', hoverOffset: 10,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '58%',
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 11 } } } }
        }
    });
    @endif

    // Trend Chart
    const trendData = @json($monthlyTrend);
    new Chart(document.getElementById('trendChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(trendData),
            datasets: [{
                label: 'Pendaftaran LKS',
                data: Object.values(trendData),
                backgroundColor: 'rgba(37,99,235,0.15)',
                borderColor: '#2563eb',
                borderWidth: 2,
                borderRadius: 8,
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
});
</script>
@endpush
