@extends('layouts.app')

@section('title', 'Perlu Tindakan')
@section('page-title', 'Perlu Tindakan')

@section('content')
<style>
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .stat-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .stat-label {
        color: rgba(255,255,255,0.85);
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .stat-value {
        font-size: 1.7rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.1;
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
        padding: 0.75rem 1rem;
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
    .s-ditolak { background:#fee2e2; color:#b91c1c; }
    .s-dikembalikan { background:#e0f2fe; color:#0369a1; }
    .s-proses { background:#dbeafe; color:#1d4ed8; }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h4 class="fw-semibold mb-0"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Perlu Tindakan</h4>
</div>

<div class="alert alert-warning border-0 mb-4" role="alert">
    <i class="bi bi-info-circle me-2"></i>
    Daftar ini menampilkan LKS yang masih memerlukan revisi, penolakan, atau pengembalian dari proses verifikasi.
    Data ini tidak termasuk LKS yang sudah teregistrasi.
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card p-3" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Perlu Tindakan</div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                </div>
                <div class="stat-icon" style="width:40px;height:40px;border-radius:0.8rem;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.25);color:#fff;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Ditolak</div>
                    <div class="stat-value">{{ $stats['ditolak'] }}</div>
                </div>
                <div class="stat-icon" style="width:40px;height:40px;border-radius:0.8rem;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.25);color:#fff;">
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3" style="background: linear-gradient(135deg, #0891b2, #0e7490);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Dikembalikan</div>
                    <div class="stat-value">{{ $stats['dikembalikan'] }}</div>
                </div>
                <div class="stat-icon" style="width:40px;height:40px;border-radius:0.8rem;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.25);color:#fff;">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-table text-primary"></i> Daftar LKS yang Perlu Tindakan
    </div>

    @if($lks->count() > 0)
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th>Nama LKS</th>
                    <th>Pendaftar</th>
                    <th>Kewenangan</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th style="width:10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lks as $index => $item)
                <tr>
                    <td class="text-muted">{{ $lks->firstItem() + $index }}</td>
                    <td class="fw-semibold">{{ $item->nama_lks }}</td>
                    <td>{{ $item->user?->name ?? '-' }}</td>
                    <td>
                        @if($item->kewenangan_type === 'provinsi')
                            <span class="badge-pill s-proses">Provinsi</span>
                        @else
                            <span class="badge-pill s-proses">Kab/Kota</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge-pill {{ $item->status_permohonan === 'Ditolak' ? 's-ditolak' : 's-dikembalikan' }}">
                            {{ $item->status_permohonan }}
                        </span>
                    </td>
                    <td>
                        @if($item->status_permohonan === 'Ditolak' && $item->alasan_penolakan)
                            <span class="text-danger">{{ Str::limit($item->alasan_penolakan, 80) }}</span>
                        @elseif($item->status_permohonan === 'Dikembalikan' && $item->alasan_dikembalikan)
                            <span class="text-info">{{ Str::limit($item->alasan_dikembalikan, 80) }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('lks.show', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $lks->appends(request()->query())->links() }}</div>
    @else
    <div class="p-4 text-center text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        Tidak ada LKS yang memerlukan tindakan saat ini.
    </div>
    @endif
</div>
@endsection
