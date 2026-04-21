@extends('layouts.app')

@section('title', 'Super Admin Panel - Surat Rekomendasi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-shield-check"></i> Super Admin Panel - Upload Sertifikat
            </h1>
            <div class="justify-content-end btn-group">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
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
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-1">{{ $stats['total'] }}</h4>
                        <p class="mb-0">Total LKS</p>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-building fs-3 text-primary"></i>
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
                        <p class="mb-0">Menunggu Upload Sertifikat</p>
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
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['with_sertifikat'] ?? 0 }}</h4>
                        <p class="mb-0">Sudah Upload Sertifikat</p>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-file-earmark-check fs-3 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
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
</div>

<!-- Filter Options -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-funnel"></i> Filter Data
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('superadmin.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diterima untuk proses" {{ request('status') == 'Diterima untuk proses' ? 'selected' : '' }}>Diterima untuk Proses</option>
                        <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kabupaten/Kota</label>
                    <input type="text" class="form-control" name="kabupaten" value="{{ request('kabupaten') }}" placeholder="Cari kabupaten/kota...">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pencarian</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama LKS...">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-table"></i> Daftar LKS - Upload Sertifikat
        </h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($lks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama LKS</th>
                            <th>Kabupaten/Kota</th>
                            <th>Status</th>
                            <th>Surat Rekomendasi</th>
                            <th>Sertifikat</th>
                            <th>Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lks as $index => $lksItem)
                            <tr>
                                <td>{{ $lks->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $lksItem->nama_lks }}</strong><br>
                                    <small class="text-muted">{{ $lksItem->alamat_lks }}</small>
                                </td>
                                <td>{{ $lksItem->kabupaten_kota ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $lksItem->status_badge }}">
                                        {{ $lksItem->status_permohonan }}
                                    </span>
                                </td>
                                <td>
                                    @if($lksItem->surat_rekomendasi_path)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Ada
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle"></i> Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($lksItem->sertifikat_path)
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('superadmin.download-surat', $lksItem->id) }}"
                                               class="btn btn-outline-success"
                                               title="Download"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <a href="{{ route('superadmin.preview-surat', $lksItem->id) }}"
                                               class="btn btn-outline-info"
                                               title="Preview"
                                               target="_blank"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('superadmin.delete-surat', $lksItem->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Hapus sertifikat?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-file-earmark"></i> Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $lksItem->nama_verifikator ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('superadmin.verification', $lksItem->id) }}"
                                           class="btn btn-primary"
                                           title="Upload Sertifikat">
                                            <i class="bi bi-upload"></i> Upload
                                        </a>
                                        <a href="{{ route('superadmin.edit', $lksItem->id) }}"
                                           class="btn btn-warning"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.destroy', $lksItem->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus data LKS ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $lks->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2">Belum ada data LKS</p>
            </div>
        @endif
    </div>
</div>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

<style>
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
}
.table td {
    vertical-align: middle;
}
</style>
@endsection
