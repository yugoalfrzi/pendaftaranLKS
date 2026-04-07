@extends('layouts.app')

@section('title', 'Admin Panel - Data LKS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-gear"></i> Admin Panel - Pendaftaran LKS
            </h1>
            <div class="justify-content-end btn-group">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Kembali ke User View
                </a>
                <a href="{{ route('documents.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-file-text"></i> Dokumen Tanda Pendaftaran
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h4 class="text-muted mb-1">{{ $stats['total'] }}</h4>
                        <p class="mb-0">Total Pendaftaran</p>
                    </div>
                     <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-file-text fs-3 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['menunggu'] }}</h4>
                        <p class="mb-0">Menunggu Verifikasi</p>
                    </div>
                     <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-clock-history fs-3 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['diterima_proses'] }}</h4>
                        <p class="mb-0">Diterima Proses</p>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-arrow-repeat fs-3 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['diterima'] + $stats['terverifikasi'] }}</h4>
                        <p class="mb-0">Diterima/Terverifikasi</p>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-check-circle fs-3 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['ditolak'] + $stats['dikembalikan'] }}</h4>
                        <p class="mb-0">Ditolak/Dikembalikan</p>
                    </div>
                     <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-x-circle fs-3 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['with_sertifikat'] ?? 0 }}</h4>
                        <p class="mb-0">Dengan Sertifikat</p>
                    </div>
                     <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-award fs-3 text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Options -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-funnel"></i> Filter Data
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Diterima untuk proses">Diterima untuk Proses</option>
                    <option value="Terverifikasi">Terverifikasi</option>
                    <option value="Ditolak">Ditolak</option>
                    <option value="Dikembalikan">Dikembalikan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Sertifikat</label>
                <select class="form-select" id="sertifikatFilter">
                    <option value="">Semua Sertifikat</option>
                    <option value="ada">Dengan Sertifikat</option>
                    <option value="tidak">Tanpa Sertifikat</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Pencarian</label>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari nama LKS...">
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-table"></i> Daftar Semua Pendaftaran LKS
        </h5>
    </div>
    <div class="card-body">
        @if($lks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="lksTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama LKS</th>
                            <th>Tanda Pendaftaran</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Kelengkapan</th>
                            <th>Sertifikat</th>
                            <th>Nama Verifikator</th>
                            <th>ID Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lks as $index => $lksItem)
                            <tr data-status="{{ $lksItem->status_permohonan }}" 
                                data-name="{{ strtolower($lksItem->nama_lks) }}"
                                data-sertifikat="{{ $lksItem->sertifikat_path ? 'ada' : 'tidak' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $lksItem->nama_lks }}</td>
                                <td>
                                    <span class="badge {{ $lksItem->tanda_pendaftaran == 'Baru' ? 'bg-success' : 'bg-info' }}">
                                        {{ $lksItem->tanda_pendaftaran }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($lksItem->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $lksItem->status_badge }}">
                                        {{ $lksItem->status_permohonan }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $lksItem->pendaftaran_lengkap ? 'bg-success' : 'bg-warning' }}">
                                        {{ $lksItem->pendaftaran_lengkap ? 'Lengkap' : 'Tidak Lengkap' }}
                                    </span>
                                </td>
                                <td>
                                    @if($lksItem->sertifikat_path)
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.verification.download-sertifikat', $lksItem->id) }}" 
                                               class="btn btn-outline-success" 
                                               title="Download Sertifikat"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <a href="{{ route('admin.verification.preview-sertifikat', $lksItem->id) }}" 
                                               class="btn btn-outline-info" 
                                               title="Preview Sertifikat"
                                               target="_blank"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.verification.delete-sertifikat', $lksItem->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus Sertifikat">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary" data-bs-toggle="tooltip" title="Belum ada sertifikat">
                                            <i class="bi bi-file-earmark-pdf"></i> Tidak Ada
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $lksItem->nama_verifikator ?? '-' }}</td>
                                <td>{{ $lksItem->verifikator_id ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if($lksItem->status_permohonan == 'Menunggu')
                                            <a href="{{ route('admin.verification', $lksItem->id) }}" class="btn btn-success" title="Verifikasi">
                                                <i class="bi bi-check-circle"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.verification', $lksItem->id) }}" class="btn btn-primary" title="Edit Verifikasi">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('lks.show', $lksItem->id) }}" class="btn btn-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('lks.destroy', $lksItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $lks->links() }}
            </div>
        @else
            <p class="text-muted">Belum ada data LKS yang terdaftar.</p>
        @endif
    </div>
</div>

<script>
function applyFilters() {
    const statusFilter = document.getElementById('statusFilter').value;
    const sertifikatFilter = document.getElementById('sertifikatFilter').value;
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#lksTable tbody tr');
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        const name = row.getAttribute('data-name');
        const sertifikat = row.getAttribute('data-sertifikat');
        
        let showRow = true;
        
        // Filter by status
        if (statusFilter && status !== statusFilter) {
            showRow = false;
        }
        
        // Filter by sertifikat
        if (sertifikatFilter && sertifikat !== sertifikatFilter) {
            showRow = false;
        }
        
        // Filter by search
        if (searchInput && !name.includes(searchInput)) {
            showRow = false;
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}

// Auto filter on input
document.getElementById('searchInput').addEventListener('input', applyFilters);
document.getElementById('statusFilter').addEventListener('change', applyFilters);
document.getElementById('sertifikatFilter').addEventListener('change', applyFilters);

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

<style>
.btn-group .btn {
    margin-right: 2px;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
.table td {
    vertical-align: middle;
}
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection