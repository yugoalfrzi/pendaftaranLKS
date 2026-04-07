@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-house"></i> Dashboard
            </h1>
            <a href="{{ route('lks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Pendaftaran Baru
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <!-- Kewenangan total (LKS Se-JABAR) -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text muted mb-0">{{ $totalLKSJabar }}</h4>
                        <small>Total LKS Se-JABAR</small>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-buildings fs-3 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kewenangan Kab/Kota -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-0">{{ $kewenanganKabkota }}</h4>
                        <small>Kabupaten/Kota</small>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-geo-alt fs-3 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kewenangan Provinsi -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-0">{{ $kewenanganProvinsi }}</h4>
                        <small>Provinsi</small>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-building fs-3 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kewenangan Kemensos -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-0">{{ $kewenanganKemensos }}</h4>
                        <small>Kemensos</small>
                    </div>
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-bank2 fs-3 text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Charts Row -->
@if($totalLKSJabar > 0 || $totalLKS > 0)
<div class="row g-3">
    <!-- Diagram Lingkaran Kewenangan -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pie-chart"></i> Distribusi Kewenangan LKS
                </h5>
            </div>
            <div class="card-body">
                @if($kewenanganChartData['total'] > 0)
                    <div class="chart-container" style="height: 375px;">
                        <canvas id="kewenanganChart"></canvas>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <div class="text-primary fw-bold">{{ $kewenanganKabkota }}</div>
                                <small class="text-muted">Kab/Kota</small>
                                <br>
                                <small class="text-muted">{{ $kewenanganChartData['percentages'][0] }}%</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <div class="text-success fw-bold">{{ $kewenanganProvinsi }}</div>
                                <small class="text-muted">Provinsi</small>
                                <br>
                                <small class="text-muted">{{ $kewenanganChartData['percentages'][1] }}%</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <div class="text-info fw-bold">{{ $kewenanganKemensos }}</div>
                                <small class="text-muted">Kemensos</small>
                                <br>
                                <small class="text-muted">{{ $kewenanganChartData['percentages'][2] }}%</small>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-pie-chart fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada data kewenangan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Distribusi Kabupaten/Kota -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">
                        <i class="bi bi-map"></i> Distribusi LKS per Kabupaten/Kota
                    </h5>
                    <small class="text-muted">Data dari Kewenangan Kab/Kota, Provinsi, dan Kemensos</small>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block">{{ count(array_filter($kabupatenData)) }} dari 27 Kab/Kota</small>
                    <small class="text-muted">Total: {{ $totalLKSJabar }} LKS</small>
                </div>
            </div>
            <div class="card-body">
                @if($totalLKSJabar > 0)
                    <div class="chart-container" style="height: 375px;">
                        <canvas id="kabupatenChart"></canvas>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <div class="text-primary fw-bold">{{ $kewenanganKabkota }}</div>
                                <small class="text-muted">Kab/Kota</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <div class="text-success fw-bold">{{ $kewenanganProvinsi }}</div>
                                <small class="text-muted">Provinsi</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <div class="text-info fw-bold">{{ $kewenanganKemensos }}</div>
                                <small class="text-muted">Kemensos</small>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-map fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada data LKS dari kewenangan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions untuk Kewenangan -->
<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> Akses Cepat ke Data Kewenangan
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-4">
                        <a href="{{ route('kewenangan-kabkota.index') }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center py-3">
                            <i class="bi bi-building fs-4 me-2"></i>
                            <div class="text-start">
                                <div class="fw-bold">Kabupaten/Kota</div>
                                <small class="text-muted">{{ $kewenanganKabkota }} data</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('kewenangan-provinsi.index') }}" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center py-3">
                            <i class="bi bi-building-fill fs-4 me-2"></i>
                            <div class="text-start">
                                <div class="fw-bold">Provinsi</div>
                                <small class="text-muted">{{ $kewenanganProvinsi }} data</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('kewenangan-kemensos.index') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center py-3">
                            <i class="bi bi-house-gear fs-4 me-2"></i>
                            <div class="text-start">
                                <div class="fw-bold">Kemensos</div>
                                <small class="text-muted">{{ $kewenanganKemensos }} data</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Total LKS Baru -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $totalLKS }}</h4>
                        <small>Total Pendaftaran Baru</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-file-earmark-text fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LKS Lengkap -->
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $lengkapLKS }}</h4>
                        <small>Pendaftaran Lengkap</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menunggu Verifikasi -->
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $menungguLKS }}</h4>
                        <small>Menunggu Verifikasi</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Diterima -->
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $diterimaLKS }}</h4>
                        <small>Diterima</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-lg fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Permohonan dan Trend -->
@if($totalLKS > 0)
<div class="row g-3 mt-4">
    <!-- Status Permohonan -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pie-chart"></i> Status Permohonan Pendaftaran
                </h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Trend Pendaftaran -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i> Trend Pendaftaran 6 Bulan Terakhir
                </h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyTrendChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
@endif

@else
<!-- Empty State -->
<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-graph-up fs-1 text-muted mb-3"></i>
                <h4 class="text-muted">Belum Ada Data</h4>
                <p class="text-muted">Data chart akan muncul setelah ada pendaftaran LKS</p>
                <a href="{{ route('lks.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Mulai Pendaftaran Pertama
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Quick Actions dan Informasi Sistem -->
<div class="row g-3">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('lks.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Pendaftaran LKS Baru
                    </a>
                    <a href="{{ route('lks.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-list"></i> Lihat Data LKS Yang Baru Didaftarkan
                    </a>
                    <a href="{{ route('announcements.panduan') }}" class="btn btn-outline-success">
                        <i class="bi bi-journal-text"></i> Panduan LKS
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Informasi Sistem
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-0">
                    <h6><i class="bi bi-building"></i> Sistem Pendaftaran LKS</h6>
                    <p class="mb-2">Provinsi Jawa Barat - 27 Kabupaten/Kota</p>
                    <small class="text-muted">
                        Berdasarkan Permensos RI Nomor 5 Tahun 2024<br>
                        Tentang Lembaga Kesejahteraan Sosial
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent LKS -->
@if($totalLKS > 0)
<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i> Pendaftaran Terbaru
                </h5>
                <a href="{{ route('lks.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($recentLKS->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama LKS</th>
                                    <th>Kabupaten/Kota</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
                                    <th>Kelengkapan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentLKS as $lks)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $lks->nama_lks }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $lks->kabupaten_kota ?: $lks->lokasi_lks }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($lks->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge {{ $lks->status_badge ?? 'bg-secondary' }}">
                                            {{ $lks->status_permohonan ?? 'Menunggu' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $lks->pendaftaran_lengkap ? 'bg-success' : 'bg-warning' }} text-dark">
                                            {{ $lks->pendaftaran_lengkap ? 'Lengkap' : 'Tidak Lengkap' }}
                                        </span>
                                    </td>
                                    @if(Auth::user() && Auth::user()->role === 'admin')
                                        <td>
                                            <a href="{{ route('lks.show', $lks->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada data LKS</p>
                        <a href="{{ route('lks.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah LKS Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@if(isset($latestLks) && auth()->check() && isset($latestLks->user_id) && $latestLks->user_id === auth()->id() && in_array($latestLks->status_permohonan, ['Proses Verifikasi', 'Diterima untuk proses', 'Diterima', 'Ditolak', 'Dikembalikan']))
<!-- Modal Status Permohonan -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      @php
        $status = $latestLks->status_permohonan;
        $isAccepted = $status === 'Diterima untuk proses';
        $isRejected = $status === 'Ditolak';
        $isReturned = $status === 'Dikembalikan';
        $headerClass = $isAccepted ? 'bg-success text-white' : ($isRejected ? 'bg-danger text-white' : 'bg-warning');
        $icon = $isAccepted ? 'bi-check-circle' : ($isRejected ? 'bi-x-circle' : 'bi-arrow-counterclockwise');
      @endphp
      <div class="modal-header {{ $headerClass }}">
        <h5 class="modal-title" id="statusModalLabel">
          <i class="bi {{ $icon }}"></i>
          Status Permohonan: {{ $status }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if($isAccepted)
          <div class="alert alert-success mb-3">
            Permohonan Anda telah diterima untuk proses. Tim verifikasi akan melanjutkan pemeriksaan dokumen.
          </div>
        @elseif($isRejected)
          <div class="alert alert-danger mb-3">
            Permohonan Anda ditolak.
          </div>
          <div class="mb-2">
            <strong>Alasan penolakan:</strong>
            <div class="border rounded p-2 bg-light mt-1">
              {{ $latestLks->alasan_penolakan ?? 'Tidak ada alasan yang diberikan.' }}
            </div>
          </div>
        @elseif($isReturned)
          <div class="alert alert-warning mb-3">
            Permohonan Anda dikembalikan untuk perbaikan.
          </div>
          <div class="mb-2">
            <strong>Alasan pengembalian:</strong>
            <div class="border rounded p-2 bg-light mt-1">
              {{ $latestLks->alasan_dikembalikan ?? 'Tidak ada alasan yang diberikan.' }}
            </div>
          </div>
        @endif
        <small class="text-muted d-block mt-2">
          Terakhir diperbarui: {{ optional($latestLks->updated_at)->format('d/m/Y H:i') }}
        </small>
      </div>
      <div class="modal-footer">
        <a href="{{ route('lks.show', $latestLks->id) }}" class="btn btn-outline-primary">
          <i class="bi bi-eye"></i> Lihat Detail LKS
        </a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endif

@endsection

@push('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.04);
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.bg-primary { 
    background: linear-gradient(135deg, hsl(210, 80%, 60%), hsl(210, 80%, 50%)) !important; 
}
.bg-success { 
    background: linear-gradient(135deg, hsl(145, 70%, 60%), hsl(145, 70%, 50%)) !important; 
}
.bg-warning { 
    background: linear-gradient(135deg, hsl(45, 85%, 65%), hsl(45, 85%, 55%)) !important; 
}
.bg-info { 
    background: linear-gradient(135deg, hsl(190, 75%, 65%), hsl(190, 75%, 55%)) !important; 
}
.bg-secondary { 
    background: linear-gradient(135deg, hsl(220, 25%, 65%), hsl(220, 25%, 55%)) !important; 
}
.bg-danger { 
    background: linear-gradient(135deg, hsl(355, 75%, 65%), hsl(355, 75%, 55%)) !important; 
}

.chart-container {
    position: relative;
    width: 100%;
}

/* Efek halus untuk chart bars */
.chart-container canvas {
    transition: all 0.3s ease;
}

/* Smooth transitions untuk semua interaksi */
* {
    transition: all 0.2s ease-in-out;
}

/* Custom scrollbar untuk chart container */
.chart-container::-webkit-scrollbar {
    height: 6px;
}

.chart-container::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.05);
    border-radius: 3px;
}

.chart-container::-webkit-scrollbar-thumb {
    background: rgba(0,0,0,0.2);
    border-radius: 3px;
}

.chart-container::-webkit-scrollbar-thumb:hover {
    background: rgba(0,0,0,0.3);
}

/* Responsif untuk mobile */
@media (max-width: 768px) {
    .chart-container {
        height: 300px !important;
    }
    
    .card-body .row.text-center .col-4 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}

/* Badge styling */
.badge {
    font-size: 0.75rem;
}

/* Table hover effect */
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.025);
}

/* Button styling */
.btn {
    transition: all 0.2s ease-in-out;
}

.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-outline-info:hover {
    transform: translateY(-1px);
}

/* Chart bar hover effects */
.chart-bar-hover {
    transition: all 0.3s ease;
}

.chart-bar-hover:hover {
    opacity: 0.8;
    transform: translateY(-1px);
}
</style>
@endpush

@push('scripts')
@if($totalLKSJabar > 0 || $totalLKS > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== DIAGRAM LINGKARAN KEWENANGAN =====
    @if($kewenanganChartData['total'] > 0)
    const kewenanganData = @json($kewenanganChartData);
    
    const kewenanganCtx = document.getElementById('kewenanganChart').getContext('2d');
    const kewenanganChart = new Chart(kewenanganCtx, {
        type: 'doughnut',
        data: {
            labels: kewenanganData.labels,
            datasets: [{
                data: kewenanganData.data,
                backgroundColor: kewenanganData.colors,
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const percentage = kewenanganData.percentages[context.dataIndex];
                            return `${label}: ${value} data (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    @endif

    // ===== DIAGRAM BATANG KABUPATEN/KOTA =====
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

    const chartLabels = [];
    const chartData = [];

    // TAMPILKAN SEMUA 27 KABUPATEN/KOTA
    semuaKabupatenKota.forEach(kabupaten => {
        chartLabels.push(kabupaten.replace('Kabupaten ', 'Kab. ').replace('Kota ', ''));
        chartData.push(kabupatenData[kabupaten] || 0);
    });

    // GENERATE WARNA CERAH TAPI TIDAK TERLALU MENCOLOK
    const generateBrightSubtleColors = (data) => {
        // Palet warna cerah tapi soft dengan saturation yang dikontrol
        const baseColors = [
            {h: 200, s: 70, l: 75},  // Soft blue
            {h: 150, s: 65, l: 75},  // Soft mint
            {h: 280, s: 60, l: 78},  // Soft lavender
            {h: 350, s: 65, l: 75},  // Soft pink
            {h: 30, s: 70, l: 75},   // Soft peach
            {h: 60, s: 65, l: 78},   // Soft yellow
            {h: 180, s: 60, l: 75},  // Soft cyan
            {h: 120, s: 55, l: 75},  // Soft green
            {h: 45, s: 70, l: 75},   // Soft gold
            {h: 320, s: 60, l: 75},  // Soft magenta
            {h: 90, s: 60, l: 75},   // Soft lime
            {h: 270, s: 55, l: 78},  // Soft purple
            {h: 210, s: 65, l: 75},  // Soft sky blue
            {h: 330, s: 60, l: 75},  // Soft rose
            {h: 40, s: 70, l: 75},   // Soft orange
            {h: 100, s: 55, l: 75},  // Soft chartreuse
            {h: 220, s: 60, l: 75},  // Soft cornflower
            {h: 140, s: 60, l: 75},  // Soft jade
            {h: 10, s: 65, l: 75},   // Soft coral
            {h: 300, s: 55, l: 78},  // Soft orchid
            {h: 170, s: 60, l: 75},  // Soft turquoise
            {h: 50, s: 70, l: 75},   // Soft mustard
            {h: 240, s: 55, l: 75},  // Soft periwinkle
            {h: 130, s: 60, l: 75},  // Soft emerald
            {h: 20, s: 70, l: 75},   // Soft apricot
            {h: 190, s: 65, l: 75},  // Soft teal
            {h: 340, s: 60, l: 75}   // Soft raspberry
        ];

        return data.map((value, index) => {
            if (value === 0) return 'rgba(220, 220, 220, 0.5)'; // Abu-abu medium untuk data 0
            
            const baseColor = baseColors[index % baseColors.length];
            const intensity = value / Math.max(...data.filter(v => v > 0));
            
            // Adjust lightness berdasarkan nilai (semakin tinggi nilai, sedikit lebih gelap)
            const lightness = baseColor.l - (intensity * 15); // 60-75 range
            
            return `hsl(${baseColor.h}, ${baseColor.s}%, ${lightness}%)`;
        });
    };

    const colors = generateBrightSubtleColors(chartData);

    const kabupatenCtx = document.getElementById('kabupatenChart').getContext('2d');
    const kabupatenChart = new Chart(kabupatenCtx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah LKS',
                data: chartData,
                backgroundColor: colors,
                borderColor: colors.map(color => color.replace('hsl', 'hsla').replace(')', ', 0.8)')),
                borderWidth: 1.5,
                borderRadius: 6,
                borderSkipped: false,
                hoverBackgroundColor: colors.map(color => {
                    // Buat sedikit lebih terang saat hover
                    const match = color.match(/hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)/);
                    if (match) {
                        const h = match[1];
                        const s = match[2];
                        let l = parseInt(match[3]);
                        l = Math.min(l + 8, 95); // Tambah lightness maksimal 95%
                        return `hsl(${h}, ${s}%, ${l}%)`;
                    }
                    return color;
                }),
                hoverBorderColor: colors.map(color => color.replace('hsl', 'hsla').replace(')', ', 1)')),
                hoverBorderWidth: 2
            }]
        },
        options: {
            indexAxis: 'x',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#2c3e50',
                    bodyColor: '#34495e',
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    padding: 12,
                    callbacks: {
                        title: function(tooltipItems) {
                            const shortName = tooltipItems[0].label;
                            const fullName = semuaKabupatenKota[tooltipItems[0].dataIndex];
                            return fullName;
                        },
                        label: function(context) {
                            const value = context.raw;
                            const total = {{ $totalLKSJabar }};
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `Jumlah LKS: ${value} (${percentage}%)`;
                        },
                        labelColor: function(context) {
                            return {
                                borderColor: colors[context.dataIndex],
                                backgroundColor: colors[context.dataIndex],
                                borderWidth: 3,
                                borderRadius: 2
                            };
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        color: '#5d6d7e',
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.06)'
                    },
                    title: {
                        display: true,
                        text: 'Jumlah LKS',
                        color: '#5d6d7e',
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45,
                        font: {
                            size: 10
                        },
                        color: '#5d6d7e'
                    }
                }
            },
            animation: {
                duration: 800,
                easing: 'easeOutQuart'
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            onHover: (event, chartElement) => {
                event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
            }
        }
    });

    // Fitur klik pada bar chart
    kabupatenChart.canvas.onclick = function(evt) {
        const points = kabupatenChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
        if (points.length) {
            const firstPoint = points[0];
            const label = semuaKabupatenKota[firstPoint.index];
            const value = kabupatenChart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
            
            if (value > 0) {
                showKabupatenDetail(label, value);
            }
        }
    };

    function showKabupatenDetail(kabupaten, total) {
        // Anda bisa menambahkan modal atau redirect ke halaman detail
        alert(`Detail ${kabupaten}: ${total} LKS`);
        // Contoh: window.location.href = `/kewenangan?kabupaten=${encodeURIComponent(kabupaten)}`;
    }
    @endif

    // ===== CHART LAINNYA =====
    @if($totalLKS > 0)
    // Chart Status Permohonan
    const statusData = @json($statusData);
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: [
                    'hsl(145, 65%, 65%)',   // Diterima - Hijau cerah
                    'hsl(45, 85%, 65%)',    // Menunggu - Kuning cerah
                    'hsl(355, 75%, 65%)',   // Ditolak - Merah cerah
                    'hsl(220, 25%, 70%)'    // Lainnya - Abu-abu cerah
                ],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // Chart Trend Bulanan
    const monthlyTrend = @json($monthlyTrend);
    const monthlyTrendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    const monthlyTrendChart = new Chart(monthlyTrendCtx, {
        type: 'line',
        data: {
            labels: Object.keys(monthlyTrend),
            datasets: [{
                label: 'Jumlah Pendaftaran',
                data: Object.values(monthlyTrend),
                backgroundColor: 'hsla(210, 70%, 70%, 0.15)',
                borderColor: 'hsl(210, 70%, 60%)',
                borderWidth: 3,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: 'hsl(210, 80%, 60%)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: 'hsl(210, 80%, 50%)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    @endif
});

// Auto refresh data setiap 5 menit
setInterval(function() {
    fetch('/api/dashboard/chart-data')
        .then(response => response.json())
        .then(data => {
            console.log('Data dashboard diperbarui:', data);
        })
        .catch(error => console.error('Error refreshing data:', error));
}, 300000);
</script>
@endif

@if(isset($latestLks) && auth()->check() && isset($latestLks->user_id) && $latestLks->user_id === auth()->id() && in_array($latestLks->status_permohonan, ['Proses Verifikasi', 'Diterima untuk proses', 'Diterima', 'Ditolak', 'Dikembalikan']))
<script>
document.addEventListener('DOMContentLoaded', function() {
  try {
    var modalEl = document.getElementById('statusModal');
    if (modalEl) {
      // Tampilkan modal hanya sekali per kombinasi LKS dan status selama sesi browser
      var key = 'statusModalShown_' + ({{ $latestLks->id ?? '0' }}) + '_' + '{{ $latestLks->status_permohonan ?? '' }}';
      if (!sessionStorage.getItem(key)) {
        var modal = new bootstrap.Modal(modalEl);
        modal.show();
        sessionStorage.setItem(key, '1');
      }
    }
  } catch (e) {
    console.warn('Modal bootstrap tidak dapat ditampilkan:', e);
  }
});
</script>
@endif
@endpush