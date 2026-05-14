@extends('layouts.app')

@section('title', 'Super Admin Panel - Tanda Pendaftaran Provinsi')
@section('page-title', 'Super Admin Panel')

@section('content')
<style>
    .card-modern { 
        border-radius:1.25rem; 
        border:1px solid #edf2f7; 
        background:#fff; 
        box-shadow:0 2px 8px rgba(0,0,0,0.02); 
        overflow:hidden; 
    }
    .card-header-custom { 
        background:#fff; 
        border-bottom:1px solid #eef2f6; 
        padding:0.9rem 1.25rem; 
        font-weight:600; 
        font-size:0.9rem; 
        display:flex; 
        align-items:center; 
        gap:0.5rem; 
    }
    .stat-card { 
        border-radius:1.25rem; 
        border:none; 
        transition:all 0.2s; 
        box-shadow:0 4px 15px rgba(0,0,0,0.1); 
    }
    .stat-card:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,0.15); }
    .stat-value { 
        font-size:1.7rem; 
        font-weight:700; 
        color:#fff; 
        line-height:1.1; 
    }
    .stat-label { color:rgba(255,255,255,0.85); font-size:.72rem; font-weight:600; text-transform:uppercase; }
    .stat-icon-sm { 
        width:36px; height:36px; border-radius:0.65rem;
        display:flex; align-items:center; justify-content:center;
        background:rgba(255,255,255,0.25); color:#fff; font-size:1rem; flex-shrink:0;
    }
    .badge-pill { 
        display:inline-flex; 
        align-items:center; 
        gap:0.25rem; 
        padding:0.2rem 0.65rem; 
        border-radius:2rem; 
        font-size:0.72rem; 
        font-weight:500; 
    }
    .s-menunggu { 
        background:#fef3c7; 
        color:#b45309; 
    }
    .s-proses { 
        background:#dbeafe; 
        color:#1d4ed8; 
    }
    .s-diterima { 
        background:#dcfce7; 
        color:#15803d; 
    }
    .s-terverifikasi { 
        background:#e0e7ff; 
        color:#4338ca; 
    }
    .s-ditolak { 
        background:#fee2e2; 
        color:#b91c1c; 
    }
    .s-dikembalikan { 
        background:#e0f2fe; 
        color:#0369a1; 
    }
    .table-doc th { 
        background:#f8fafc; 
        font-size:0.72rem; 
        text-transform:uppercase; 
        letter-spacing:0.04em; 
        color:#475569; 
        padding:0.7rem 1rem; 
        border-bottom:1px solid #e2e8f0; 
        white-space:nowrap; 
    }
    .table-doc td { 
        padding:0.75rem 1rem; 
        vertical-align:middle; 
        border-bottom:1px solid #f1f5f9; 
        font-size:0.83rem; 
    }
    .alur-box { 
        background:#eff6ff; 
        border:1px solid #bfdbfe; 
        border-radius:0.75rem; 
        padding:0.85rem 1.25rem; 
        font-size:0.83rem; 
    }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h4 class="fw-semibold mb-0"><i class="bi bi-shield-check me-2 text-primary"></i>Super Admin Panel — Upload Tanda Pendaftaran Provinsi</h4>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Dashboard
    </a>
</div>

{{-- Info Alur --}}
<div class="alur-box mb-4">
    <i class="bi bi-info-circle-fill text-primary me-2"></i>
    <strong>Alur Kewenangan Provinsi:</strong>
    User mendaftar LKS (Provinsi)
    → <span class="badge-pill s-menunggu">Admin</span> upload Surat Rekomendasi → Status: <strong>Terekomendasi</strong>
    → <span class="badge-pill s-proses">Super Admin</span> upload Tanda Pendaftaran → Status: <strong>Disetujui</strong>
    <br><small class="text-muted mt-1 d-block">Halaman ini hanya menampilkan LKS kewenangan <strong>Provinsi</strong> yang sudah diverifikasi Admin (status: Terekomendasi).</small>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Total Masuk</div><div class="stat-value">{{ $stats['total'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-buildings"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Menunggu Upload</div><div class="stat-value">{{ $stats['menunggu'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Sudah Upload</div><div class="stat-value">{{ $stats['with_sertifikat'] ?? 0 }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
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
        <form method="GET" action="{{ route('superadmin.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Kabupaten/Kota</label>
                <input type="text" class="form-control form-control-sm" name="kabupaten" value="{{ request('kabupaten') }}" placeholder="Cari kabupaten/kota...">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Tanda Pendaftaran</label>
                <select class="form-select form-select-sm" name="has_sertifikat">
                    <option value="">Semua</option>
                    <option value="no" {{ request('has_sertifikat') == 'no' ? 'selected' : '' }}>Belum Ada</option>
                    <option value="yes" {{ request('has_sertifikat') == 'yes' ? 'selected' : '' }}>Sudah Ada</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">Pencarian</label>
                <input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Cari nama LKS...">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary btn-sm rounded-pill w-100" type="submit"><i class="bi bi-search me-1"></i> Cari</button>
                <a href="{{ route('superadmin.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel --}}
<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-table text-primary"></i> Daftar LKS — Upload Tanda Pendaftaran Provinsi
    </div>
    @if($lks->count() > 0)
    <div class="table-responsive">
        <table class="table table-doc mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama LKS</th>
                    <th>Kabupaten/Kota</th>
                    <th>Status</th>
                    <th>Surat Rekomendasi</th>
                    <th>Tanda Pendaftaran Provinsi</th>
                    <th>Verifikator</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lks as $index => $lksItem)
                @php
                    $sc = match($lksItem->status_permohonan) {
                        'Menunggu','Menunggu kelengkapan data' => 's-menunggu',
                        'Terekomendasi' => 's-proses',
                        'Disetujui' => 's-diterima',
                        'Ditolak' => 's-ditolak',
                        'Dikembalikan' => 's-dikembalikan',
                        default => 's-menunggu',
                    };
                @endphp
                <tr>
                    <td class="text-muted">{{ $lks->firstItem() + $index }}</td>
                    <td>
                        <span class="fw-semibold">{{ $lksItem->nama_lks }}</span>
                        <br><small class="text-muted">{{ Str::limit($lksItem->alamat_lks, 50) }}</small>
                    </td>
                    <td>{{ $lksItem->kabupaten_kota ?? '-' }}</td>
                    <td><span class="badge-pill {{ $sc }}">{{ $lksItem->status_permohonan }}</span></td>
                    <td>
                        @if($lksItem->surat_rekomendasi_path)
                            <span class="badge-pill s-diterima"><i class="bi bi-check-circle me-1"></i>Ada</span>
                        @else
                            <span class="badge-pill s-menunggu">Belum Ada</span>
                        @endif
                    </td>
                    <td>
                        @if($lksItem->sertifikat_path)
                            <div class="d-flex gap-1">
                                <a href="{{ route('superadmin.preview-surat', $lksItem->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('superadmin.download-surat', $lksItem->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                                <form action="{{ route('superadmin.delete-surat', $lksItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tanda pendaftaran?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        @else
                            <span class="badge-pill s-menunggu">Belum Ada</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $lksItem->nama_verifikator ?? '-' }}</td>
                    <td>
                        <a href="{{ route('superadmin.verification', $lksItem->id) }}" class="btn btn-sm btn-primary rounded-pill px-3" title="Upload Tanda Pendaftaran">
                            <i class="bi bi-upload me-1"></i> Upload
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $lks->links() }}</div>
    @else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1"></i>
        <p class="mt-2">Belum ada data LKS yang siap diproses</p>
    </div>
    @endif
</div>

@endsection
