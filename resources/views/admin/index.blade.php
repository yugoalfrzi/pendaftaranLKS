@extends('layouts.app')

@section('title', 'Admin Panel - Verifikasi LKS')
@section('page-title', 'Admin Panel')

@section('content')
<style>
    .card-modern { border-radius:1.25rem; border:1px solid #edf2f7; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.02); overflow:hidden; }
    .card-header-custom { background:#fff; border-bottom:1px solid #eef2f6; padding:0.9rem 1.25rem; font-weight:600; font-size:0.9rem; display:flex; align-items:center; gap:0.5rem; }
    .stat-card { border-radius:1.25rem; border:none; transition:all 0.2s; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
    .stat-card:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,0.15); }
    .stat-value { font-size:1.7rem; font-weight:700; color:#fff; line-height:1.1; }
    .stat-label { color:rgba(255,255,255,0.85); font-size:.7rem; font-weight:600; text-transform:uppercase; }
    .stat-icon-sm { width:36px; height:36px; border-radius:0.65rem; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.25); color:#fff; font-size:1rem; flex-shrink:0; }
    .badge-pill { display:inline-flex; align-items:center; gap:0.25rem; padding:0.2rem 0.65rem; border-radius:2rem; font-size:0.72rem; font-weight:500; }
    .s-menunggu { background:#fef3c7; color:#b45309; }
    .s-proses { background:#dbeafe; color:#1d4ed8; }
    .s-diterima { background:#dcfce7; color:#15803d; }
    .s-terverifikasi { background:#e0e7ff; color:#4338ca; }
    .s-ditolak { background:#fee2e2; color:#b91c1c; }
    .s-dikembalikan { background:#e0f2fe; color:#0369a1; }
    .table-doc th { background:#f8fafc; font-size:0.72rem; text-transform:uppercase; letter-spacing:0.04em; color:#475569; padding:0.7rem 1rem; border-bottom:1px solid #e2e8f0; white-space:nowrap; }
    .table-doc td { padding:0.75rem 1rem; vertical-align:middle; border-bottom:1px solid #f1f5f9; font-size:0.83rem; }
    .nav-tabs-modern { border-bottom:2px solid #eef2f6; gap:0.25rem; }
    .nav-tabs-modern .nav-link { border:none; border-radius:0.5rem 0.5rem 0 0; color:#64748b; font-size:0.85rem; font-weight:500; padding:0.6rem 1rem; }
    .nav-tabs-modern .nav-link.active { color:#1d4ed8; background:#eff6ff; border-bottom:2px solid #1d4ed8; margin-bottom:-2px; }
    .nav-tabs-modern .nav-link:hover:not(.active) { background:#f8fafc; color:#334155; }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-semibold mb-1"><i class="bi bi-shield-check me-2 text-primary"></i>Admin Panel — Verifikasi LKS</h4>
        @if(auth()->user()->kabupaten_kota)
            <span class="badge-pill s-proses"><i class="bi bi-geo-alt me-1"></i>{{ auth()->user()->kabupaten_kota }}</span>
        @endif
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Dashboard
    </a>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Total</div><div class="stat-value">{{ $stats['total'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-buildings"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#0891b2,#0e7490);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Kab/Kota</div><div class="stat-value">{{ $stats['kabkota'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-building"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Provinsi</div><div class="stat-value">{{ $stats['provinsi'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-map"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Menunggu</div><div class="stat-value">{{ $stats['menunggu'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Diterima</div><div class="stat-value">{{ $stats['diterima'] + $stats['terverifikasi'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#dc2626,#b91c1c);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Ditolak/Kembali</div><div class="stat-value">{{ $stats['ditolak'] + $stats['dikembalikan'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-x-circle"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card-modern mb-4">
    <div class="card-header-custom"><i class="bi bi-funnel text-primary"></i> Filter & Pencarian</div>
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.lks.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select class="form-select form-select-sm" name="status">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diterima untuk proses" {{ request('status') == 'Diterima untuk proses' ? 'selected' : '' }}>Diterima untuk Proses</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-semibold mb-1">Pencarian</label>
                <input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Cari nama LKS...">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary btn-sm rounded-pill w-100" type="submit"><i class="bi bi-search me-1"></i> Cari</button>
                <a href="{{ route('admin.lks.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Tabs --}}
<div class="card-modern">
    <div class="card-header-custom p-0 px-3 pt-3 pb-0 d-block">
        <ul class="nav nav-tabs-modern nav-tabs" id="lksTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-kabkota" data-bs-toggle="tab" data-bs-target="#pane-kabkota" type="button" role="tab">
                    <i class="bi bi-building me-1"></i> Kewenangan Kab/Kota
                    <span class="badge-pill s-proses ms-1">{{ $lksKabkota->total() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-provinsi" data-bs-toggle="tab" data-bs-target="#pane-provinsi" type="button" role="tab">
                    <i class="bi bi-map me-1"></i> Kewenangan Provinsi
                    <span class="badge-pill s-terverifikasi ms-1">{{ $lksProvinsi->total() }}</span>
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="lksTabContent">

        {{-- TAB KAB/KOTA --}}
        <div class="tab-pane fade show active" id="pane-kabkota" role="tabpanel">
            <div class="px-3 pt-3 pb-1">
                <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>
                    LKS kewenangan Kab/Kota — Admin upload <strong>Tanda Pendaftaran Kab/Kota</strong>. Proses selesai di sini.
                </p>
            </div>
            @if($lksKabkota->count() > 0)
            <div class="table-responsive">
                <table class="table table-doc mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama LKS</th>
                            <th>Tgl Masuk</th>
                            <th>Status</th>
                            <th>Tanda Pendaftaran Kab/Kota</th>
                            <th>Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lksKabkota as $index => $item)
                        @php
                            $sc = match($item->status_permohonan) {
                                'Menunggu','Menunggu kelengkapan data' => 's-menunggu',
                                'Diterima untuk proses' => 's-proses',
                                'Diterima' => 's-diterima',
                                'Terverifikasi' => 's-terverifikasi',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        @endphp
                        <tr>
                            <td class="text-muted">{{ $lksKabkota->firstItem() + $index }}</td>
                            <td>
                                <span class="fw-semibold">{{ $item->nama_lks }}</span>
                                <br><small class="text-muted">{{ $item->kabupaten_kota ?? $item->lokasi_lks }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                            <td><span class="badge-pill {{ $sc }}">{{ $item->status_permohonan }}</span></td>
                            <td>
                                @if($item->sertifikat_kabkota_path)
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.verification.preview-sertifikat-kabkota', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('admin.verification.download-sertifikat-kabkota', $item->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                                        <form action="{{ route('admin.verification.delete-sertifikat-kabkota', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tanda pendaftaran kab/kota?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-2"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                @else
                                    <span class="badge-pill s-menunggu">Belum Ada</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $item->nama_verifikator ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.verification', $item->id) }}" class="btn btn-sm btn-primary rounded-pill px-3" title="Upload Tanda Pendaftaran">
                                    <i class="bi bi-upload me-1"></i> Upload
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2">{{ $lksKabkota->appends(request()->query())->links() }}</div>
            @else
            <div class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1"></i><p class="mt-2">Belum ada pendaftaran LKS kewenangan Kab/Kota.</p></div>
            @endif
        </div>

        {{-- TAB PROVINSI --}}
        <div class="tab-pane fade" id="pane-provinsi" role="tabpanel">
            <div class="px-3 pt-3 pb-1">
                <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>
                    LKS kewenangan Provinsi — Admin upload <strong>Surat Rekomendasi</strong>, kemudian diteruskan ke <strong>Super Admin</strong> untuk upload Tanda Pendaftaran.
                </p>
            </div>
            @if($lksProvinsi->count() > 0)
            <div class="table-responsive">
                <table class="table table-doc mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama LKS</th>
                            <th>Tgl Masuk</th>
                            <th>Status</th>
                            <th>Surat Rekomendasi</th>
                            <th>Tanda Pendaftaran</th>
                            <th>Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lksProvinsi as $index => $item)
                        @php
                            $sc = match($item->status_permohonan) {
                                'Menunggu','Menunggu kelengkapan data' => 's-menunggu',
                                'Diterima untuk proses' => 's-proses',
                                'Diterima' => 's-diterima',
                                'Terverifikasi' => 's-terverifikasi',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        @endphp
                        <tr>
                            <td class="text-muted">{{ $lksProvinsi->firstItem() + $index }}</td>
                            <td>
                                <span class="fw-semibold">{{ $item->nama_lks }}</span>
                                <br><small class="text-muted">{{ $item->kabupaten_kota ?? $item->lokasi_lks }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                            <td><span class="badge-pill {{ $sc }}">{{ $item->status_permohonan }}</span></td>
                            <td>
                                @if($item->surat_rekomendasi_path)
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.verification.preview-sertifikat', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('admin.verification.download-sertifikat', $item->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                                        <form action="{{ route('admin.verification.delete-sertifikat', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus surat rekomendasi?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-2"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                @else
                                    <span class="badge-pill s-menunggu">Belum Ada</span>
                                @endif
                            </td>
                            <td>
                                @if($item->sertifikat_path)
                                    <span class="badge-pill s-diterima"><i class="bi bi-check-circle me-1"></i>Sudah Ada</span>
                                @else
                                    <span class="badge-pill s-menunggu">Menunggu Super Admin</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $item->nama_verifikator ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.verification', $item->id) }}" class="btn btn-sm btn-primary rounded-pill px-3" title="Upload Surat Rekomendasi">
                                    <i class="bi bi-upload me-1"></i> Upload
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2">{{ $lksProvinsi->appends(request()->query())->links() }}</div>
            @else
            <div class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1"></i><p class="mt-2">Belum ada pendaftaran LKS kewenangan Provinsi.</p></div>
            @endif
        </div>

    </div>
</div>

<script>
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
});
</script>
@endsection
