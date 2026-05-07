@extends('layouts.app')

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
    .info-row { 
        display:flex; 
        padding:0.55rem 0; 
        border-bottom:1px solid #f8fafc; 
        font-size:0.85rem; 
    }
    .info-row:last-child { 
        border-bottom:none; 
    }
    .info-label { 
        width:42%; 
        color:#64748b; 
        font-weight:500; 
        flex-shrink:0; 
    }
    .info-value { 
        color:#1e293b; 
        flex:1; 
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
    .s-tersedia  { 
        background:#dcfce7; 
        color:#15803d; 
    }
    .s-belum     { 
        background:#fef3c7; 
        color:#b45309; 
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
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-semibold mb-1">Detail Hibah LKS</h4>
        <p class="text-muted small mb-0">{{ $hibah->nama_lks ?? '-' }} &mdash; Tahun {{ $hibah->tahun ?? '-' }}</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        @if(Auth::user() && Auth::user()->role === 'admin')
        <a href="{{ route('hibah.documents', $hibah) }}" class="btn btn-dark btn-sm rounded-pill px-3">
            <i class="bi bi-folder2-open me-1"></i> Kelola Dokumen
        </a>
        @endif
        <a href="{{ route('hibah.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-5">
        <div class="card-modern h-100">
            <div class="card-header-custom">
                <i class="bi bi-info-circle text-primary"></i> Informasi Hibah
            </div>
            <div class="card-body p-3">
                <div class="info-row">
                    <span class="info-label">Nama LKS</span>
                    <span class="info-value fw-semibold">{{ $hibah->nama_lks ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tahun</span>
                    <span class="info-value">{{ $hibah->tahun ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Proposal</span>
                    <span class="info-value">
                        @if($hibah->proposal_path)
                            <span class="badge-pill s-tersedia"><i class="bi bi-check-circle"></i> Tersedia</span>
                        @else
                            <span class="badge-pill s-belum"><i class="bi bi-clock"></i> Belum ada</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">LPJ</span>
                    <span class="info-value">
                        @if($hibah->lpj_path)
                            <span class="badge-pill s-tersedia"><i class="bi bi-check-circle"></i> Tersedia</span>
                        @else
                            <span class="badge-pill s-belum"><i class="bi bi-clock"></i> Belum ada</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card-modern h-100">
            <div class="card-header-custom">
                <i class="bi bi-folder2 text-primary"></i> Dokumen Pendukung
                @php
                    $files = [
                        'Hasil Verifikasi'       => $hibah->hasil_verifikasi_path ?? null,
                        'Pergub Penjabaran APBD' => $hibah->pergub_penjabaran_apbd_path ?? null,
                        'DPA'                    => $hibah->dpa_path ?? null,
                        'Hasil Identifikasi'     => $hibah->hasil_identifikasi_path ?? null,
                        'Data Penerima Hibah'    => $hibah->data_penerima_hibah_path ?? null,
                        'SPM'                    => $hibah->spm_path ?? null,
                        'SP2D'                   => $hibah->sp2d_path ?? null,
                        'Petunjuk Teknis'        => $hibah->petunjuk_teknis_path ?? null,
                    ];
                    $uploaded = collect($files)->filter()->count();
                @endphp
                <span class="ms-auto text-muted small fw-normal">{{ $uploaded }} / {{ count($files) }} tersedia</span>
            </div>
            <div class="table-responsive">
                <table class="table table-doc mb-0">
                    <thead>
                        <tr>
                            <th>Dokumen</th>
                            <th style="width:12%">Status</th>
                            <th style="width:10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($files as $label => $path)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                    <span class="fw-semibold">{{ $label }}</span>
                                </div>
                            </td>
                            <td>
                                @if($path)
                                    <span class="badge-pill s-tersedia"><i class="bi bi-check-circle"></i> Ada</span>
                                @else
                                    <span class="badge-pill s-belum"><i class="bi bi-clock"></i> Belum</span>
                                @endif
                            </td>
                            <td>
                                @if($path)
                                    <a href="{{ route('files.local', ['path' => $path]) }}" target="_blank"
                                       class="btn btn-sm btn-outline-primary rounded-pill px-2">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
