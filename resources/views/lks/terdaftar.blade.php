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
        background:#fff; 
        border-radius:1.25rem; 
        border:1px solid rgba(203,213,225,0.4); 
        transition:all 0.2s; 
        box-shadow:0 2px 6px rgba(0,0,0,0.02); 
    }
    .stat-value { 
        font-size:1.7rem; 
        font-weight:700; 
        color:#0f172a; 
        line-height:1.1; 
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

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small">Total LKS Terdaftar</span>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#eff6ff;">
                    <i class="bi bi-patch-check text-primary"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['kabkota'] + $stats['provinsi'] }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small">Kewenangan Kab/Kota</span>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#eff6ff;">
                    <i class="bi bi-building text-primary"></i>
                </div>
            </div>
            <div class="stat-value" style="color:#1d4ed8;">{{ $stats['kabkota'] }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small">Kewenangan Provinsi</span>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#f0fdf4;">
                    <i class="bi bi-map text-success"></i>
                </div>
            </div>
            <div class="stat-value" style="color:#15803d;">{{ $stats['provinsi'] }}</div>
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
                <p class="mt-2">Belum ada LKS kewenangan Kab/Kota yang sudah bersertifikat.</p>
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
                <p class="mt-2">Belum ada LKS kewenangan Provinsi yang sudah bersertifikat.</p>
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
