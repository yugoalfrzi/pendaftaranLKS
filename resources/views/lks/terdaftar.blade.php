@extends('layouts.app')

@section('title', 'LKS Terdaftar')
@section('page-title', 'LKS Terdaftar')

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
    .s-baru { 
        background:#dcfce7; 
        color:#15803d; 
    }
    .s-ulang { 
        background:#e0f2fe; 
        color:#0369a1; 
    }
    .s-proses { 
        background:#dbeafe; 
        color:#1d4ed8; 
    }
    .s-terverifikasi { 
        background:#e0e7ff; 
        color:#4338ca; 
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
    .nav-tabs-modern { 
        border-bottom:2px solid #eef2f6; 
        gap:0.25rem; 
    }
    .nav-tabs-modern .nav-link { 
        border:none; 
        border-radius:0.5rem 0.5rem 0 0; 
        color:#64748b; 
        font-size:0.85rem; 
        font-weight:500; 
        padding:0.6rem 1rem; 
    }
    .nav-tabs-modern .nav-link.active { 
        color:#1d4ed8; 
        background:#eff6ff; 
        border-bottom:2px solid #1d4ed8; 
        margin-bottom:-2px; 
    }
    .nav-tabs-modern .nav-link:hover:not(.active) 
    { 
        background:#f8fafc; 
        color:#334155; 
    }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h4 class="fw-semibold mb-0"><i class="bi bi-patch-check me-2 text-primary"></i>LKS Terdaftar</h4>
</div>

{{-- Notifikasi LKS Ditolak/Dikembalikan (hanya untuk user) --}}
@if($lksPerluPerhatian && $lksPerluPerhatian->count() > 0)
<div class="card-modern mb-4" style="border-left:4px solid #f87171;">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Pendaftaran Perlu Tindakan</span>
        <span class="badge bg-danger rounded-pill" style="font-size:.72rem;">{{ $lksPerluPerhatian->count() }} perlu tindakan</span>
    </div>
    <div class="card-body p-3 d-flex flex-column gap-2">
        @foreach($lksPerluPerhatian as $lks)
        @php
            $isDitolak = $lks->status_permohonan === 'Ditolak';
            $bg  = $isDitolak ? '#fff1f2' : '#fff8f0';
            $bc  = $isDitolak ? '#fecdd3' : '#fed7aa';
            $cls = $isDitolak ? 's-ditolak' : 's-dikembalikan';
            $ico = $isDitolak ? 'bi-x-circle-fill' : 'bi-arrow-counterclockwise';
        @endphp
        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 gap-3"
             style="background:{{ $bg }}; border:1px solid {{ $bc }};">
            <div class="d-flex align-items-center gap-3 flex-1 min-w-0">
                <i class="bi {{ $ico }} fs-5 flex-0 badge-pill {{ $cls }}" style="padding:.4rem; border-radius:.6rem;"></i>
                <div class="min-w-0">
                    <div class="fw-semibold text-truncate" style="font-size:.85rem;">{{ $lks->nama_lks }}</div>
                    <div class="text-muted" style="font-size:.75rem;">
                        {{ $lks->updated_at->diffForHumans() }}
                        @if($isDitolak && $lks->alasan_penolakan)
                            &mdash; <span class="text-danger">{{ Str::limit($lks->alasan_penolakan, 70) }}</span>
                        @elseif(!$isDitolak && $lks->alasan_dikembalikan)
                            &mdash; <span style="color:#b45309;">{{ Str::limit($lks->alasan_dikembalikan, 70) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-0">
                <span class="badge-pill {{ $cls }}">{{ $lks->status_permohonan }}</span>
                <a href="{{ route('lks.show', $lks->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2" style="font-size:.72rem;">
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Total LKS Terdaftar</div><div class="stat-value">{{ $stats['kabkota'] + $stats['provinsi'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-patch-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#0891b2,#0e7490);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Kewenangan Kab/Kota</div><div class="stat-value">{{ $stats['kabkota'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-building"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Kewenangan Provinsi</div><div class="stat-value">{{ $stats['provinsi'] }}</div></div>
                <div class="stat-icon-sm"><i class="bi bi-map"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card-modern mb-3">
    <div class="card-header-custom">
        <i class="bi bi-funnel text-primary"></i> Pencarian
    </div>
    <div class="card-body p-3">
        <form method="GET" action="{{ route('lks.terdaftar') }}">
            <div class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label small fw-semibold mb-1">Cari LKS</label>
                    <input type="text" class="form-control form-control-sm" name="search"
                           value="{{ request('search') }}" placeholder="Cari nama LKS atau kabupaten/kota...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm rounded-pill w-100" type="submit">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('lks.terdaftar') }}" class="btn btn-outline-secondary btn-sm rounded-pill w-100">
                        <i class="bi bi-x-circle me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tabs --}}
<div class="card-modern">
    <div class="card-header-custom p-0 px-3 pt-3 pb-0 d-block">
        <ul class="nav nav-tabs-modern nav-tabs" id="terdaftarTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-kabkota" data-bs-toggle="tab"
                        data-bs-target="#pane-kabkota" type="button" role="tab">
                    <i class="bi bi-building me-1"></i> Kewenangan Kab/Kota
                    <span class="badge-pill s-proses ms-1">{{ $lksKabkota->total() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-provinsi" data-bs-toggle="tab"
                        data-bs-target="#pane-provinsi" type="button" role="tab">
                    <i class="bi bi-map me-1"></i> Kewenangan Provinsi
                    <span class="badge-pill s-terverifikasi ms-1">{{ $lksProvinsi->total() }}</span>
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="terdaftarTabContent">

        {{-- TAB KAB/KOTA --}}
        <div class="tab-pane fade show active" id="pane-kabkota" role="tabpanel">
            <div class="px-3 pt-3 pb-1">
                <p class="text-muted small mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    LKS kewenangan Kab/Kota yang telah mendapatkan <strong>Tanda pendaftaran Kab/Kota</strong> dari {{ auth()->user()->name }}.
                </p>
            </div>

            @if($lksKabkota->count() > 0)
            <div class="table-responsive">
                <table class="table table-doc mb-0">
                    <thead>
                        <tr>
                            <th style="width:4%">No</th>
                            <th>Nama LKS</th>
                            <th>Kabupaten/Kota</th>
                            <th>Tanda Daftar</th>
                            <th>Verifikator</th>
                            <th>Tanda Pendaftaran Kab/Kota</th>
                            <th style="width:6%">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lksKabkota as $index => $item)
                        <tr>
                            <td class="text-muted">{{ $lksKabkota->firstItem() + $index }}</td>
                            <td>
                                <span class="fw-semibold">{{ $item->nama_lks }}</span>
                                @if($item->nama_ketua_lks)
                                    <br><small class="text-muted">Ketua: {{ $item->nama_ketua_lks }}</small>
                                @endif
                            </td>
                            <td>{{ $item->kabupaten_kota ?? $item->lokasi_lks ?? '-' }}</td>
                            <td>
                                <span class="badge-pill {{ $item->tanda_pendaftaran == 'Baru' ? 's-baru' : 's-ulang' }}">
                                    {{ $item->tanda_pendaftaran }}
                                </span>
                            </td>
                            <td>{{ $item->nama_verifikator ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <a href="{{ route('lks.preview-sertifikat-kabkota', $item->id) }}"
                                       target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Preview">
                                        <i class="bi bi-eye"></i> Preview
                                    </a>
                                    <a href="{{ route('lks.download-sertifikat-kabkota', $item->id) }}"
                                       class="btn btn-sm btn-outline-success rounded-pill px-2" title="Download">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('lks.show', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2">{{ $lksKabkota->appends(request()->query())->links() }}</div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Belum ada LKS kewenangan Kab/Kota yang sudah memiliki tanda pendaftaran.</p>
            </div>
            @endif
        </div>

        {{-- TAB PROVINSI --}}
        <div class="tab-pane fade" id="pane-provinsi" role="tabpanel">
            <div class="px-3 pt-3 pb-1">
                <p class="text-muted small mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    LKS kewenangan Provinsi yang telah mendapatkan <strong>Tanda pendaftaran<strong> dari {{ auth()->user()->name }}.
                </p>
            </div>

            @if($lksProvinsi->count() > 0)
            <div class="table-responsive">
                <table class="table table-doc mb-0">
                    <thead>
                        <tr>
                            <th style="width:4%">No</th>
                            <th>Nama LKS</th>
                            <th>Kabupaten/Kota</th>
                            <th>Tanda Daftar</th>
                            <th>Verifikator</th>
                            <th>Tanda Pendaftaran Provinsi</th>
                            <th style="width:6%">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lksProvinsi as $index => $item)
                        <tr>
                            <td class="text-muted">{{ $lksProvinsi->firstItem() + $index }}</td>
                            <td>
                                <span class="fw-semibold">{{ $item->nama_lks }}</span>
                                @if($item->nama_ketua_lks)
                                    <br><small class="text-muted">Ketua: {{ $item->nama_ketua_lks }}</small>
                                @endif
                            </td>
                            <td>{{ $item->kabupaten_kota ?? $item->lokasi_lks ?? '-' }}</td>
                            <td>
                                <span class="badge-pill {{ $item->tanda_pendaftaran == 'Baru' ? 's-baru' : 's-ulang' }}">
                                    {{ $item->tanda_pendaftaran }}
                                </span>
                            </td>
                            <td>{{ $item->nama_verifikator ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <a href="{{ route('lks.preview-sertifikat-provinsi', $item->id) }}"
                                       target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Preview">
                                        <i class="bi bi-eye"></i> Preview
                                    </a>
                                    <a href="{{ route('lks.download-sertifikat-provinsi', $item->id) }}"
                                       class="btn btn-sm btn-outline-success rounded-pill px-2" title="Download">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('lks.show', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2">{{ $lksProvinsi->appends(request()->query())->links() }}</div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Belum ada LKS kewenangan Provinsi yang sudah memiliki tanda pendaftaran.</p>
            </div>
            @endif
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Preserve active tab on page reload
    const activeTab = localStorage.getItem('terdaftarActiveTab');
    if (activeTab) {
        const tab = document.querySelector('#terdaftarTabs button[data-bs-target="' + activeTab + '"]');
        if (tab) new bootstrap.Tab(tab).show();
    }
    document.querySelectorAll('#terdaftarTabs button').forEach(btn => {
        btn.addEventListener('shown.bs.tab', e => {
            localStorage.setItem('terdaftarActiveTab', e.target.getAttribute('data-bs-target'));
        });
    });
});
</script>

@endsection
