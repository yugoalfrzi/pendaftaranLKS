@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<style>
    .stat-card {
        background: #fff; 
        border-radius: 1.25rem;
        border: 1px solid rgba(203,213,225,0.4);
        transition: all 0.2s; 
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }
    .stat-card:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 10px 20px -10px rgba(0,0,0,0.1); }
    .stat-icon {
        width: 44px;
        height: 44px; 
        border-radius: 1rem;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 1.2rem;
    }
    .stat-value { 
        font-size: 1.7rem; 
        font-weight: 700; 
        color: #0f172a; 
        line-height: 1.1; 
    }
    .card-modern {
        border-radius: 1.25rem; 
        border: 1px solid #edf2f7;
        background: #fff; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.02); 
        overflow: hidden;
    }
    .card-header-custom {
        background: #fff; 
        border-bottom: 1px solid #eef2f6;
        padding: 0.9rem 1.25rem; 
        font-weight: 600; 
        font-size: 0.9rem;
    }
    .table-modern th {
        background: #f8fafc; 
        font-size: 0.72rem; 
        text-transform: uppercase;
        letter-spacing: 0.04em; 
        color: #475569; 
        padding: 0.7rem 1rem;
        border-bottom: 1px solid #e2e8f0; 
        white-space: nowrap;
    }
    .table-modern td {
        padding: 0.7rem 1rem; 
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9; 
        font-size: 0.83rem;
    }
    .badge-pill {
        display: inline-flex; 
        align-items: center; 
        gap: 0.25rem;
        padding: 0.2rem 0.65rem; 
        border-radius: 2rem;
        font-size: 0.7rem; 
        font-weight: 500;
    }
    .s-menunggu     { 
        background:#fef3c7; 
        color:#b45309; 
    }
    .s-proses       { 
        background:#dbeafe; 
        color:#1d4ed8; 
    }
    .s-diterima     { 
        background:#dcfce7; 
        color:#15803d; }
    .s-terverifikasi{ 
        background:#e0e7ff; 
        color:#4338ca; 
    }
    .s-ditolak      { 
        background:#fee2e2; 
        color:#b91c1c; 
    }
    .s-dikembalikan { 
        background:#e0f2fe; 
        color:#0369a1; 
    }
    .quick-action {
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center;
        gap: 0.5rem; 
        padding: 1.2rem 0.5rem; 
        border-radius: 1rem;
        border: 1.5px solid #e2e8f0; 
        background: #fff; 
        text-decoration: none;
        color: #334155; 
        transition: all 0.2s; 
        font-size: 0.82rem; 
        font-weight: 500;
    }
    .quick-action:hover { 
        border-color: #2563eb; 
        background: #eef2ff; 
        color: #1e40af; 
    }
    .quick-action i { 
        font-size: 1.5rem; 
    }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-semibold mb-1">
            <i class="bi bi-house-door me-2 text-primary"></i>Dashboard
        </h1>
        <p class="text-muted small mb-0">Selamat datang, <strong>{{ auth()->user()->name }}</strong>
            @if(auth()->user()->kabupaten_kota)
                &mdash; <span class="text-primary">{{ auth()->user()->kabupaten_kota }}</span>
            @endif
        </p>
    </div>
    <a href="{{ route('lks.create') }}" class="btn btn-primary rounded-pill px-4 btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Pendaftaran LKS Baru
    </a>
</div>

{{-- Stat Cards LKS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted fw-semibold text-uppercase" style="font-size:.68rem">Total LKS Saya</div>
                    <div class="stat-value">{{ $totalLks }}</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-buildings"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted fw-semibold text-uppercase" style="font-size:.68rem">Menunggu</div>
                    <div class="stat-value text-warning">{{ $menunggu }}</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted fw-semibold text-uppercase" style="font-size:.68rem">Diterima</div>
                    <div class="stat-value text-success">{{ $diterima }}</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted fw-semibold text-uppercase" style="font-size:.68rem">Dikembalikan</div>
                    <div class="stat-value text-info">{{ $dikembalikan }}</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-arrow-counterclockwise"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Akses Cepat --}}
<div class="card-modern mb-4">
    <div class="card-header-custom"><i class="bi bi-lightning me-2"></i>Akses Cepat</div>
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-6 col-md-3">
                <a href="{{ route('lks.create') }}" class="quick-action">
                    <i class="bi bi-plus-circle text-primary"></i>
                    <span>Daftar LKS</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('rptka.index') }}" class="quick-action">
                    <i class="bi bi-file-earmark-person text-indigo" style="color:#4338ca"></i>
                    <span>Permohonan RPTKA</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('lks.terdaftar') }}" class="quick-action">
                    <i class="bi bi-patch-check text-success"></i>
                    <span>Tanda Pendaftaran</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('announcements.regulasi') }}" class="quick-action">
                    <i class="bi bi-megaphone text-warning"></i>
                    <span>Pengumuman</span>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Status Terkini Verifikasi --}}
@if($statusTerkini->count() > 0)
<div class="card-modern mb-4">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-bell me-2 text-primary"></i>Update Status Verifikasi</span>
        @if($perluPerhatian > 0)
            <span class="badge bg-danger rounded-pill" style="font-size:.72rem">
                {{ $perluPerhatian }} perlu tindakan
            </span>
        @endif
    </div>
    <div class="card-body p-3 d-flex flex-column gap-2">
        @foreach($statusTerkini as $lks)
        @php
            $sc = match($lks->status_permohonan) {
                'Diterima untuk proses' => ['class' => 's-proses', 'icon' => 'bi-hourglass-split', 'bg' => '#eff6ff'],
                'Diterima'              => ['class' => 's-diterima', 'icon' => 'bi-check-circle-fill', 'bg' => '#f0fdf4'],
                'Terverifikasi'         => ['class' => 's-terverifikasi', 'icon' => 'bi-patch-check-fill', 'bg' => '#eef2ff'],
                'Ditolak'               => ['class' => 's-ditolak', 'icon' => 'bi-x-circle-fill', 'bg' => '#fff1f2'],
                'Dikembalikan'          => ['class' => 's-dikembalikan', 'icon' => 'bi-arrow-counterclockwise', 'bg' => '#f0f9ff'],
                default                 => ['class' => 's-menunggu', 'icon' => 'bi-clock', 'bg' => '#fffbeb'],
            };
        @endphp
        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 gap-3"
             style="background:{{ $sc['bg'] }}; border:1px solid rgba(0,0,0,0.05);">
            <div class="d-flex align-items-center gap-3 flex-1 min-w-0">
                <i class="bi {{ $sc['icon'] }} fs-5 flex-0 badge-pill {{ $sc['class'] }}" style="padding:.4rem; border-radius:.6rem;"></i>
                <div class="min-w-0">
                    <div class="fw-semibold text-truncate" style="font-size:.85rem;">{{ $lks->nama_lks }}</div>
                    <div class="text-muted" style="font-size:.75rem;">
                        Diperbarui {{ $lks->updated_at->diffForHumans() }}
                        @if($lks->status_permohonan === 'Ditolak' && $lks->alasan_penolakan)
                            &mdash; <span class="text-danger">{{ Str::limit($lks->alasan_penolakan, 60) }}</span>
                        @elseif($lks->status_permohonan === 'Dikembalikan' && $lks->alasan_dikembalikan)
                            &mdash; <span class="text-info">{{ Str::limit($lks->alasan_dikembalikan, 60) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-0">
                <span class="badge-pill {{ $sc['class'] }}">{{ $lks->status_permohonan }}</span>
                <a href="{{ route('lks.show', $lks->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2" style="font-size:.72rem;">
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Tabel RPTKA Terbaru --}}
@if($totalRptka > 0)
<div class="card-modern">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-file-earmark-person me-2"></i>Permohonan RPTKA Terbaru</span>
        <a href="{{ route('rptka.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.78rem">
            Lihat Semua <i class="bi bi-arrow-right-short"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama LKS</th>
                    <th>Nama TKA</th>
                    <th>Jenis</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRptka as $rptka)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $rptka->nama_lks }}</td>
                    <td>{{ $rptka->nama_tka_pemohon }}</td>
                    <td><span class="badge-pill s-proses">{{ $rptka->permohonan_rptka }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($rptka->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $sc = match($rptka->status_permohonan) {
                                'Menunggu' => 's-menunggu',
                                'Diterima' => 's-diterima',
                                'Terverifikasi' => 's-terverifikasi',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        @endphp
                        <span class="badge-pill {{ $sc }}">{{ $rptka->status_permohonan }}</span>
                    </td>
                    <td>
                        <a href="{{ route('rptka.show', $rptka->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.75rem">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
