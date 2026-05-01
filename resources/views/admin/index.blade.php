@extends('layouts.app')

@section('title', 'Admin Panel - Verifikasi LKS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-gear-wide-connected"></i> Admin Panel - Verifikasi LKS
            </h1>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['total'] }}</h4>
                        <p class="mb-0 small">Total</p>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-file-text fs-4 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['kabkota'] }}</h4>
                        <p class="mb-0 small">Kab/Kota</p>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-building fs-4 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['provinsi'] }}</h4>
                        <p class="mb-0 small">Provinsi</p>
                    </div>
                    <div class="bg-success bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-map fs-4 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['menunggu'] }}</h4>
                        <p class="mb-0 small">Menunggu</p>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-clock-history fs-4 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['diterima'] + $stats['terverifikasi'] }}</h4>
                        <p class="mb-0 small">Diterima</p>
                    </div>
                    <div class="bg-success bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-check-circle fs-4 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-muted mb-0">{{ $stats['ditolak'] + $stats['dikembalikan'] }}</h4>
                        <p class="mb-0 small">Ditolak/Kembali</p>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-x-circle fs-4 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.lks.index') }}">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold mb-1">Status</label>
                    <select class="form-select form-select-sm" name="status">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label small fw-bold mb-1">Pencarian</label>
                    <input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Cari nama LKS...">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary btn-sm w-100" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ===== TABS PENDAFTARAN ===== -->
<ul class="nav nav-tabs" id="lksTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-kabkota" data-bs-toggle="tab" data-bs-target="#pane-kabkota" type="button" role="tab">
            <i class="bi bi-building"></i> Kewenangan Kab/Kota
            <span class="badge bg-primary ms-1">{{ $lksKabkota->total() }}</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-provinsi" data-bs-toggle="tab" data-bs-target="#pane-provinsi" type="button" role="tab">
            <i class="bi bi-map"></i> Kewenangan Provinsi
            <span class="badge bg-success ms-1">{{ $lksProvinsi->total() }}</span>
        </button>
    </li>
</ul>

<div class="tab-content border border-top-0 rounded-bottom bg-white shadow-sm mb-4" id="lksTabContent">

    {{-- ===== TAB KAB/KOTA ===== --}}
    <div class="tab-pane fade show active p-3" id="pane-kabkota" role="tabpanel">
        <p class="text-muted small mb-3">
            <i class="bi bi-info-circle"></i>
            LKS kewenangan Kab/Kota — Admin upload <strong>Sertifikat Kab/Kota</strong>. Proses selesai di sini.
        </p>

        @if($lksKabkota->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama LKS</th>
                        <th>Tgl Masuk</th>
                        <th>Status</th>
                        <th>Kelengkapan</th>
                        <th>Tanda Pendaftaran Kab/kota</th>
                        <th>Verifikator</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lksKabkota as $index => $item)
                    <tr>
                        <td>{{ $lksKabkota->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $item->nama_lks }}</strong>
                            <br><small class="text-muted">{{ $item->kabupaten_kota ?? $item->lokasi_lks }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $item->status_badge }}">{{ $item->status_permohonan }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $item->pendaftaran_lengkap ? 'bg-success' : 'bg-warning' }}">
                                {{ $item->pendaftaran_lengkap ? 'Lengkap' : 'Belum' }}
                            </span>
                        </td>
                        {{-- Sertifikat Kab/Kota --}}
                        <td>
                            @if($item->sertifikat_kabkota_path)
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.verification.preview-sertifikat-kabkota', $item->id) }}" target="_blank" class="btn btn-outline-info btn-sm" title="Preview"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.verification.download-sertifikat-kabkota', $item->id) }}" class="btn btn-outline-success btn-sm" title="Download"><i class="bi bi-download"></i></a>
                                    <form action="{{ route('admin.verification.delete-sertifikat-kabkota', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus sertifikat kab/kota?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            @else
                                <span class="badge bg-secondary">Belum Ada</span>
                            @endif
                        </td>
                        <td>{{ $item->nama_verifikator ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.verification', $item->id) }}" class="btn btn-primary btn-sm" title="Verifikasi & Upload">
                                    <i class="bi bi-upload"></i>
                                </a>
                                <a href="{{ route('admin.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $lksKabkota->appends(request()->query())->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1"></i>
            <p class="mt-2">Belum ada pendaftaran LKS kewenangan Kab/Kota.</p>
        </div>
        @endif
    </div>

    {{-- ===== TAB PROVINSI ===== --}}
    <div class="tab-pane fade p-3" id="pane-provinsi" role="tabpanel">
        <p class="text-muted small mb-3">
            <i class="bi bi-info-circle"></i>
            LKS kewenangan Provinsi — Admin upload <strong>Surat Rekomendasi</strong>, kemudian diteruskan ke <strong>Super Admin</strong> untuk upload Sertifikat.
        </p>

        @if($lksProvinsi->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama LKS</th>
                        <th>Tgl Masuk</th>
                        <th>Status</th>
                        <th>Kelengkapan</th>
                        <th>Surat Rekomendasi</th>
                        <th>Sertifikat (Super Admin)</th>
                        <th>Verifikator</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lksProvinsi as $index => $item)
                    <tr>
                        <td>{{ $lksProvinsi->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $item->nama_lks }}</strong>
                            <br><small class="text-muted">{{ $item->kabupaten_kota ?? $item->lokasi_lks }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $item->status_badge }}">{{ $item->status_permohonan }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $item->pendaftaran_lengkap ? 'bg-success' : 'bg-warning' }}">
                                {{ $item->pendaftaran_lengkap ? 'Lengkap' : 'Belum' }}
                            </span>
                        </td>
                        {{-- Surat Rekomendasi --}}
                        <td>
                            @if($item->surat_rekomendasi_path)
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.verification.preview-sertifikat', $item->id) }}" target="_blank" class="btn btn-outline-info btn-sm" title="Preview"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.verification.download-sertifikat', $item->id) }}" class="btn btn-outline-success btn-sm" title="Download"><i class="bi bi-download"></i></a>
                                    <form action="{{ route('admin.verification.delete-sertifikat', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus surat rekomendasi?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            @else
                                <span class="badge bg-secondary">Belum Ada</span>
                            @endif
                        </td>
                        {{-- Sertifikat dari Super Admin (read-only) --}}
                        <td>
                            @if($item->sertifikat_path)
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Sudah Ada</span>
                            @else
                                <span class="badge bg-secondary">Menunggu Super Admin</span>
                            @endif
                        </td>
                        <td>{{ $item->nama_verifikator ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.verification', $item->id) }}" class="btn btn-primary btn-sm" title="Verifikasi & Upload">
                                    <i class="bi bi-upload"></i>
                                </a>
                                <a href="{{ route('admin.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $lksProvinsi->appends(request()->query())->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1"></i>
            <p class="mt-2">Belum ada pendaftaran LKS kewenangan Provinsi.</p>
        </div>
        @endif
    </div>
</div>


<style>
.table td { vertical-align: middle; }
.nav-tabs .nav-link { font-size: 0.9rem; }
</style>

<script>
// Preserve active tab on page reload
document.addEventListener('DOMContentLoaded', function () {
    const activeTab = localStorage.getItem('adminLksActiveTab');
    if (activeTab) {
        const tab = document.querySelector('#lksTabs button[data-bs-target="' + activeTab + '"]');
        if (tab) new bootstrap.Tab(tab).show();
    }
    document.querySelectorAll('#lksTabs button').forEach(btn => {
        btn.addEventListener('shown.bs.tab', e => {
            localStorage.setItem('adminLksActiveTab', e.target.getAttribute('data-bs-target'));
        });
    });

    // Tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
});
</script>
@endsection
