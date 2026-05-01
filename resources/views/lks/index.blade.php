@extends('layouts.app')

@section('title', 'Data LKS')
@section('page-title', 'Data LKS')

@section('content')
<style>
    .card-modern { border-radius:1.25rem; border:1px solid #edf2f7; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.02); overflow:hidden; }
    .card-header-custom { background:#fff; border-bottom:1px solid #eef2f6; padding:0.9rem 1.25rem; font-weight:600; font-size:0.9rem; display:flex; align-items:center; gap:0.5rem; }
    .badge-pill { display:inline-flex; align-items:center; gap:0.25rem; padding:0.2rem 0.65rem; border-radius:2rem; font-size:0.72rem; font-weight:500; }
    .s-menunggu { background:#fef3c7; color:#b45309; }
    .s-proses { background:#dbeafe; color:#1d4ed8; }
    .s-diterima { background:#dcfce7; color:#15803d; }
    .s-terverifikasi { background:#e0e7ff; color:#4338ca; }
    .s-ditolak { background:#fee2e2; color:#b91c1c; }
    .s-dikembalikan { background:#e0f2fe; color:#0369a1; }
    .s-baru { background:#dcfce7; color:#15803d; }
    .s-ulang { background:#e0f2fe; color:#0369a1; }
    .table-doc th { background:#f8fafc; font-size:0.72rem; text-transform:uppercase; letter-spacing:0.04em; color:#475569; padding:0.7rem 1rem; border-bottom:1px solid #e2e8f0; white-space:nowrap; }
    .table-doc td { padding:0.75rem 1rem; vertical-align:middle; border-bottom:1px solid #f1f5f9; font-size:0.83rem; }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h4 class="fw-semibold mb-0"><i class="bi bi-list-check me-2 text-primary"></i>Data LKS</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-house-door me-1"></i> Dashboard
        </a>
        @if(auth()->user()->hasRole(['super_admin', 'admin']))
            <a href="{{ route('lks.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="bi bi-plus-circle me-1"></i> Pendaftaran Baru
            </a>
        @endif
    </div>
</div>

<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-table text-primary"></i> Daftar Pendaftaran LKS
    </div>
    @if($lks->count() > 0)
    <div class="table-responsive">
        <table class="table table-doc mb-0">
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th>Nama LKS</th>
                    <th>Tanda Pendaftaran</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Sertifikat</th>
                    <th style="width:12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lks as $index => $lksItem)
                <tr>
                    <td class="text-muted">{{ $index + 1 }}</td>
                    <td><span class="fw-semibold">{{ $lksItem->nama_lks }}</span></td>
                    <td>
                        <span class="badge-pill {{ $lksItem->tanda_pendaftaran == 'Baru' ? 's-baru' : 's-ulang' }}">
                            {{ $lksItem->tanda_pendaftaran }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($lksItem->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $sc = match($lksItem->status_permohonan) {
                                'Menunggu','Menunggu kelengkapan data' => 's-menunggu',
                                'Diterima untuk proses' => 's-proses',
                                'Diterima' => 's-diterima',
                                'Terverifikasi' => 's-terverifikasi',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        @endphp
                        <span class="badge-pill {{ $sc }}">{{ $lksItem->status_permohonan }}</span>
                    </td>
                    <td>
                        @if($lksItem->sertifikat_path)
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('lks.download-sertifikat-provinsi', $lksItem->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-2" title="Download"><i class="bi bi-download"></i></a>
                                <a href="{{ route('lks.preview-sertifikat-provinsi', $lksItem->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Preview" target="_blank"><i class="bi bi-eye"></i></a>
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('admin.verification.delete-sertifikat', $lksItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus sertifikat ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <span class="text-muted small"><i class="bi bi-file-earmark-x me-1"></i>Tidak Ada</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('lks.show', $lksItem->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Detail"><i class="bi bi-eye"></i></a>
                            @if(auth()->user()->hasRole(['super_admin', 'admin']))
                                <a href="{{ route('lks.edit', $lksItem->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-2" title="Edit"><i class="bi bi-pencil"></i></a>
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.verification', $lksItem->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="Verifikasi"><i class="bi bi-clipboard-check"></i></a>
                                @endif
                                <form action="{{ route('lks.destroy', $lksItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2"><i class="bi bi-trash"></i></button>
                                </form>
                            @endif
                        </div>
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
        <p class="mt-2">Belum ada data LKS yang terdaftar.</p>
    </div>
    @endif
</div>
@endsection
