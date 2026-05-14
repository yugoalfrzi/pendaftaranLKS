@extends('layouts.app')

@section('title', 'Daftar Permohonan RPTKA')
@section('page-title', 'Permohonan RPTKA')

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
    .s-baru { 
        background:#dcfce7; 
        color:#15803d; 
    }
    .s-ulang { 
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
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h4 class="fw-semibold mb-0"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Permohonan RPTKA</h4>
    @if(auth()->user()->role === 'user')
    <a href="{{ route('rptka.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
        <i class="bi bi-plus-circle me-1"></i> Daftar RPTKA Baru
    </a>
    @endif
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Total Permohonan</div><div class="stat-value">{{ $stats['total'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-folder2-open"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Menunggu Verifikasi</div><div class="stat-value">{{ $stats['menunggu'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Terekomendasi</div><div class="stat-value">{{ $stats['diterima'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#7c3aed,#6d28d9);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Disetujui</div><div class="stat-value">{{ $stats['terverifikasi'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-patch-check"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="card-modern mb-3">
    <div class="card-header-custom">
        <i class="bi bi-funnel text-primary"></i> Filter & Pencarian
    </div>
    <div class="card-body p-3">
        <form method="GET" action="{{ route('rptka.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-semibold mb-1">Pencarian</label>
                <input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Cari nama LKS atau nama TKA...">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">Jenis Permohonan</label>
                <select class="form-select form-select-sm" name="jenis">
                    <option value="">Semua Jenis</option>
                    <option value="Baru" {{ request('jenis') == 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Ulang" {{ request('jenis') == 'Ulang' ? 'selected' : '' }}>Perpanjangan</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-pill w-100"><i class="bi bi-search me-1"></i> Cari</button>
                <a href="{{ route('rptka.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-table text-primary"></i> Daftar Permohonan
    </div>
    @if($rptkas->count() > 0)
    <div class="table-responsive">
        <table class="table table-doc mb-0">
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th>Nama LKS</th>
                    <th>Nama TKA Pemohon</th>
                    <th style="width:10%">Jenis</th>
                    <th style="width:10%">Tgl Masuk</th>
                    <th style="width:10%">Status</th>
                    <th style="width:10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rptkas as $i => $item)
                <tr>
                    <td class="text-muted">{{ $rptkas->firstItem() + $i }}</td>
                    <td>
                        <span class="fw-semibold">{{ $item->nama_lks }}</span><br>
                        <small class="text-muted">{{ Str::limit($item->alamat_lks, 50) }}</small>
                    </td>
                    <td>{{ $item->nama_tka_pemohon }}</td>
                    <td>
                        <span class="badge-pill {{ $item->permohonan_rptka == 'Baru' ? 's-baru' : 's-ulang' }}">
                            {{ $item->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru' }}
                        </span>
                    </td>
                    <td>{{ $item->tanggal_masuk_dokumen->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $sc = match($item->status_permohonan) {
                                'Menunggu' => 's-menunggu',
                                'Terekomendasi' => 's-proses',
                                'Disetujui' => 's-diterima',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        @endphp
                        <span class="badge-pill {{ $sc }}">{{ $item->status_permohonan }}</span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('rptka.show', $item->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Detail"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('rptka.edit', $item->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-2" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('rptka.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data RPTKA ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $rptkas->links() }}</div>
    @else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1"></i>
        <p class="mt-2">Belum ada data permohonan RPTKA</p>
        @if(auth()->user()->role === 'user')
        <a href="{{ route('rptka.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
            <i class="bi bi-plus-circle me-1"></i> Daftar Sekarang
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
