@extends('layouts.app')

@section('title', 'Semua Pendaftaran LKS')
@section('page-title', 'Semua Pendaftaran LKS')

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
    .badge-pill { 
        display:inline-flex; 
        align-items:center; 
        gap:0.25rem; 
        padding:0.2rem 0.65rem; 
        border-radius:2rem; 
        font-size:0.72rem; 
        font-weight:500; 
    }
    .s-menunggu { background:#fef3c7; color:#b45309; }
    .s-proses { background:#dbeafe; color:#1d4ed8; }
    .s-diterima { background:#dcfce7; color:#15803d; }
    .s-terverifikasi { background:#e0e7ff; color:#4338ca; }
    .s-ditolak { background:#fee2e2; color:#b91c1c; }
    .s-dikembalikan { background:#e0f2fe; color:#0369a1; }
    .s-baru { background:#dcfce7; color:#15803d; }
    .s-ulang { background:#e0f2fe; color:#0369a1; }
    .stat-card { background:none; border-radius:1.25rem; border:none; box-shadow:0 4px 15px rgba(0,0,0,0.1); transition:all 0.2s; }
    .stat-card:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,0.15); }
    .stat-value { font-size:1.5rem; font-weight:700; color:#fff; line-height:1.1; }
    .stat-label { color:rgba(255,255,255,0.85); font-size:.7rem; font-weight:600; text-transform:uppercase; }
    .stat-icon-sm { width:34px; height:34px; border-radius:0.6rem; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.25); color:#fff; font-size:0.95rem; flex-shrink:0; }
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
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h4 class="fw-semibold mb-0"><i class="bi bi-list-check me-2 text-primary"></i>Semua Pendaftaran LKS</h4>
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
                <div><div class="stat-label">Diterima</div><div class="stat-value">{{ $stats['diterima'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#dc2626,#b91c1c);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Ditolak</div><div class="stat-value">{{ $stats['ditolak'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-x-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#0891b2,#0e7490);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Dikembalikan</div><div class="stat-value">{{ $stats['dikembalikan'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-arrow-counterclockwise"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card-modern mb-3">
    <div class="card-header-custom"><i class="bi bi-funnel text-primary"></i> Filter & Pencarian</div>
    <div class="card-body p-3">
        <form method="GET" action="{{ route('lks.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">Cari LKS</label>
                <input type="text" class="form-control form-control-sm" name="search"
                       value="{{ request('search') }}" placeholder="Nama LKS, alamat, kab/kota...">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select class="form-select form-select-sm" name="status">
                    <option value="">Semua Status</option>
                    @foreach(['Menunggu','Terekomendasi','Disetujui','Ditolak','Dikembalikan'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Kewenangan</label>
                <select class="form-select form-select-sm" name="kewenangan">
                    <option value="">Semua</option>
                    <option value="kabkota" {{ request('kewenangan') == 'kabkota' ? 'selected' : '' }}>Kab/Kota</option>
                    <option value="provinsi" {{ request('kewenangan') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary btn-sm rounded-pill w-100" type="submit"><i class="bi bi-search me-1"></i> Cari</button>
                <a href="{{ route('lks.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-table text-primary"></i> Daftar Pendaftaran LKS
        <span class="ms-auto text-muted" style="font-size:.78rem; font-weight:400;">{{ $lks->total() }} data</span>
    </div>
    @if($lks->count() > 0)
    <div class="table-responsive">
        <table class="table table-doc mb-0">
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th>Nama LKS</th>
                    <th>Pendaftar</th>
                    <th>Kab/Kota</th>
                    <th>Kewenangan</th>
                    <th>Tanda Daftar</th>
                    <th>Status</th>
                    <th style="width:8%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lks as $index => $lksItem)
                <tr>
                    <td class="text-muted">{{ $lks->firstItem() + $index }}</td>
                    <td><span class="fw-semibold">{{ $lksItem->nama_lks }}</span></td>
                    <td>
                        <span class="text-muted" style="font-size:.78rem;">{{ $lksItem->user?->name ?? '-' }}</span>
                    </td>
                    <td class="text-muted">{{ $lksItem->kabupaten_kota ?? '-' }}</td>
                    <td>
                        <span class="badge-pill {{ $lksItem->kewenangan_type == 'kabkota' ? 's-proses' : 's-terverifikasi' }}">
                            {{ $lksItem->kewenangan_type == 'kabkota' ? 'Kab/Kota' : 'Provinsi' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-pill {{ $lksItem->tanda_pendaftaran == 'Baru' ? 's-baru' : 's-ulang' }}">
                            {{ $lksItem->tanda_pendaftaran }}
                        </span>
                    </td>
                    <td>
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
                        <span class="badge-pill {{ $sc }}">{{ $lksItem->status_permohonan }}</span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('lks.show', $lksItem->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Detail"><i class="bi bi-eye"></i></a>
                            @if(auth()->user()->role === 'user')
                            <a href="{{ route('lks.edit', $lksItem->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-2" title="Edit"><i class="bi bi-pencil"></i></a>
                            @endif
                            <form action="{{ route('lks.destroy', $lksItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $lks->appends(request()->query())->links() }}</div>
    @else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1"></i>
        <p class="mt-2">Tidak ada data pendaftaran LKS yang ditemukan.</p>
    </div>
    @endif
</div>
@endsection
