@extends('layouts.app')

@section('title', 'Detail RPTKA - ' . $rptka->nama_lks)
@section('page-title', 'Detail RPTKA')

@section('content')
<style>
    .card-modern { border-radius:1.25rem; border:1px solid #edf2f7; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.02); overflow:hidden; }
    .card-header-custom { background:#fff; border-bottom:1px solid #eef2f6; padding:0.9rem 1.25rem; font-weight:600; font-size:0.9rem; display:flex; align-items:center; gap:0.5rem; }
    .info-row { display:flex; padding:0.55rem 0; border-bottom:1px solid #f8fafc; font-size:0.85rem; }
    .info-row:last-child { border-bottom:none; }
    .info-label { width:42%; color:#64748b; font-weight:500; flex-shrink:0; }
    .info-value { color:#1e293b; flex:1; }
    .badge-pill { display:inline-flex; align-items:center; gap:0.25rem; padding:0.2rem 0.65rem; border-radius:2rem; font-size:0.72rem; font-weight:500; }
    .s-menunggu { background:#fef3c7; color:#b45309; }
    .s-proses { background:#dbeafe; color:#1d4ed8; }
    .s-diterima { background:#dcfce7; color:#15803d; }
    .s-terverifikasi { background:#e0e7ff; color:#4338ca; }
    .s-ditolak { background:#fee2e2; color:#b91c1c; }
    .s-dikembalikan { background:#e0f2fe; color:#0369a1; }
    .s-baru { background:#dcfce7; color:#15803d; }
    .s-ulang { background:#e0f2fe; color:#0369a1; }
    .doc-file-item { display:flex; align-items:center; justify-content:space-between; padding:0.5rem 0.75rem; border-radius:0.6rem; background:#f8fafc; border:1px solid #e2e8f0; margin-bottom:0.4rem; font-size:0.82rem; }
    .table-doc th { background:#f8fafc; font-size:0.72rem; text-transform:uppercase; letter-spacing:0.04em; color:#475569; padding:0.7rem 1rem; border-bottom:1px solid #e2e8f0; white-space:nowrap; }
    .table-doc td { padding:0.75rem 1rem; vertical-align:middle; border-bottom:1px solid #f1f5f9; font-size:0.83rem; }
    .alasan-box { background:#fff8f0; border:1px solid #fed7aa; border-radius:0.75rem; padding:0.85rem 1rem; font-size:0.83rem; color:#92400e; }
    .alasan-box.danger { background:#fff1f2; border-color:#fecdd3; color:#9f1239; }
    .sertifikat-box { border-radius:0.75rem; padding:1rem 1.25rem; display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; }
    .sertifikat-box.available { background:#f0fdf4; border:1px solid #bbf7d0; }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-semibold mb-1">{{ $rptka->nama_lks }}</h4>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @php
                $sc = match($rptka->status_permohonan) {
                    'Menunggu' => 's-menunggu',
                    'Diterima untuk proses' => 's-proses',
                    'Diterima' => 's-diterima',
                    'Terverifikasi' => 's-terverifikasi',
                    'Ditolak' => 's-ditolak',
                    'Dikembalikan' => 's-dikembalikan',
                    default => 's-menunggu',
                };
            @endphp
            <span class="badge-pill {{ $sc }}">{{ $rptka->status_permohonan }}</span>
            <span class="badge-pill {{ $rptka->permohonan_rptka == 'Baru' ? 's-baru' : 's-ulang' }}">
                {{ $rptka->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru' }}
            </span>
            <span class="text-muted small"><i class="bi bi-clock-history me-1"></i>Diperbarui {{ $rptka->updated_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        @if(in_array($rptka->status_permohonan, ['Menunggu', 'Dikembalikan']))
            <a href="{{ route('rptka.edit', $rptka->id) }}" class="btn btn-outline-warning btn-sm rounded-pill px-3">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        @endif
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

{{-- Alasan --}}
@if($rptka->alasan_penolakan)
<div class="alasan-box danger mb-4">
    <i class="bi bi-x-circle me-2"></i><strong>Alasan Penolakan:</strong> {{ $rptka->alasan_penolakan }}
</div>
@endif
@if($rptka->alasan_dikembalikan)
<div class="alasan-box mb-4">
    <i class="bi bi-arrow-counterclockwise me-2"></i><strong>Alasan Dikembalikan:</strong> {{ $rptka->alasan_dikembalikan }}
</div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <div class="card-modern mb-3">
            <div class="card-header-custom">
                <i class="bi bi-info-circle text-primary"></i> Informasi Permohonan
            </div>
            <div class="card-body p-3">
                <div class="info-row"><span class="info-label">Nama LKS</span><span class="info-value fw-semibold">{{ $rptka->nama_lks }}</span></div>
                <div class="info-row"><span class="info-label">Nama TKA Pemohon</span><span class="info-value">{{ $rptka->nama_tka_pemohon }}</span></div>
                <div class="info-row"><span class="info-label">Alamat LKS</span><span class="info-value">{{ $rptka->alamat_lks }}</span></div>
                <div class="info-row">
                    <span class="info-label">Jenis Permohonan</span>
                    <span class="info-value"><span class="badge-pill {{ $rptka->permohonan_rptka == 'Baru' ? 's-baru' : 's-ulang' }}">{{ $rptka->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru' }}</span></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value"><span class="badge-pill {{ $sc }}">{{ $rptka->status_permohonan }}</span></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Masuk</span>
                    <span class="info-value">{{ $rptka->tanggal_masuk_dokumen->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Lengkap</span>
                    <span class="info-value">
                        @if($rptka->tanggal_persyaratan_lengkap)
                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $rptka->tanggal_persyaratan_lengkap->format('d F Y') }}</span>
                        @else
                            <span class="text-muted">Belum lengkap</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="card-modern">
            <div class="card-header-custom">
                <i class="bi bi-clipboard-check text-primary"></i> Dokumen Persyaratan
                <span class="ms-auto text-muted small fw-normal">{{ $rptka->documentStatuses->where('is_ada', true)->count() }} / {{ $rptka->documentStatuses->count() }} tersedia</span>
            </div>
            <div class="table-responsive">
                <table class="table table-doc mb-0">
                    <thead>
                        <tr>
                            <th style="width:4%">No</th>
                            <th>Nama Dokumen</th>
                            <th style="width:10%">Status</th>
                            <th style="width:20%">File</th>
                            <th style="width:18%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rptka->documentStatuses->sortBy('masterDocument.urutan') as $status)
                        <tr>
                            <td class="text-muted">{{ $status->masterDocument->urutan }}</td>
                            <td>
                                <span class="fw-semibold">{{ $status->masterDocument->nama_dokumen }}</span>
                                @if($status->masterDocument->wajib)
                                    <span class="badge-pill s-ditolak ms-1" style="font-size:.65rem">Wajib</span>
                                @endif
                                @if($status->masterDocument->kategori == 'perpanjangan')
                                    <span class="badge-pill s-ulang ms-1" style="font-size:.65rem">Perpanjangan</span>
                                @endif
                            </td>
                            <td>
                                @if($status->is_ada)
                                    <span class="badge-pill s-diterima"><i class="bi bi-check-circle me-1"></i>Ada</span>
                                @else
                                    <span class="badge-pill s-ditolak"><i class="bi bi-x-circle me-1"></i>Belum</span>
                                @endif
                            </td>
                            <td>
                                @if($status->file_path)
                                    <div class="doc-file-item">
                                        <a href="{{ route('rptka.documents.preview', [$rptka->id, $status->master_document_id]) }}"
                                           target="_blank" class="text-decoration-none text-primary d-flex align-items-center gap-1">
                                            <i class="bi bi-file-earmark-text"></i><span>Lihat File</span>
                                        </a>
                                        <a href="{{ route('rptka.documents.download', [$rptka->id, $status->master_document_id]) }}"
                                           class="btn btn-sm btn-outline-success rounded-pill px-2" style="font-size:.72rem">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-muted small"><i class="bi bi-file-earmark-x me-1"></i>Tidak ada</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $status->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4"><i class="bi bi-inbox me-1"></i>Belum ada dokumen</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-modern mb-3">
            <div class="card-header-custom">
                <i class="bi bi-bar-chart text-primary"></i> Kelengkapan Dokumen
            </div>
            <div class="card-body p-3">
                @php $pct = $rptka->completionPercentage() @endphp
                <div class="progress mb-2" style="height:10px; border-radius:1rem;">
                    <div class="progress-bar {{ $pct == 100 ? 'bg-success' : 'bg-primary' }}" style="width:{{ $pct }}%; border-radius:1rem;"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    @php $total = $rptka->documentStatuses->count(); $ada = $rptka->documentStatuses->where('is_ada', true)->count(); @endphp
                    <small class="text-muted">{{ $ada }} dari {{ $total }} dokumen</small>
                    <small class="fw-semibold {{ $pct == 100 ? 'text-success' : 'text-primary' }}">{{ $pct }}%</small>
                </div>
                @if($rptka->tanggal_persyaratan_lengkap)
                    <div class="mt-3 p-2 rounded-3" style="background:#f0fdf4; border:1px solid #bbf7d0; font-size:0.82rem; color:#15803d;">
                        <i class="bi bi-check-circle me-1"></i> Semua dokumen lengkap
                    </div>
                @endif
            </div>
        </div>

        @if($rptka->surat_rekomendasi_rptka_final_path)
        <div class="card-modern mb-3">
            <div class="card-header-custom">
                <i class="bi bi-patch-check text-success"></i> Surat Rekomendasi RPTKA
            </div>
            <div class="card-body p-3">
                <div class="sertifikat-box available">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
                        <div>
                            <div class="fw-semibold small">Surat Rekomendasi Final</div>
                            <div class="text-muted" style="font-size:.75rem">Diterbitkan oleh Admin</div>
                        </div>
                    </div>
                    <a href="{{ route('rptka.download-surat-final', $rptka->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                        <i class="bi bi-download me-1"></i> Download
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="card-modern">
            <div class="card-header-custom">
                <i class="bi bi-gear text-primary"></i> Aksi
            </div>
            <div class="card-body p-3 d-flex flex-column gap-2">
                @if(in_array($rptka->status_permohonan, ['Menunggu', 'Dikembalikan']))
                <a href="{{ route('rptka.edit', $rptka->id) }}" class="btn btn-warning btn-sm rounded-pill">
                    <i class="bi bi-pencil me-1"></i> Edit Permohonan
                </a>
                @endif
                <form action="{{ route('rptka.destroy', $rptka->id) }}" method="POST" onsubmit="return confirm('Hapus permohonan RPTKA ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm rounded-pill w-100">
                        <i class="bi bi-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
