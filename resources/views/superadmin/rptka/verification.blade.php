@extends('layouts.app')
@section('title', 'Verval RPTKA - ' . $rptka->nama_lks)
@section('page-title', 'Verval RPTKA')

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
    .s-menunggu { 
        background:#fef3c7; 
        color:#b45309; 
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
    .doc-file-item { 
        display:flex; 
        align-items:center; 
        justify-content:space-between; 
        padding:0.5rem 0.75rem; 
        border-radius:0.6rem; 
        background:#f8fafc; 
        border:1px solid #e2e8f0; 
        margin-bottom:0.4rem; 
        font-size:0.82rem; 
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
    .sertifikat-box { 
        border-radius:0.75rem; 
        padding:1rem 1.25rem; 
        display:flex; 
        align-items:center; 
        justify-content:space-between; 
        gap:1rem; 
        flex-wrap:wrap; 
    }
    .sertifikat-box.available { 
        background:#f0fdf4; 
        border:1px solid #bbf7d0; 
    }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-semibold mb-1"><i class="bi bi-patch-check me-2 text-primary"></i>Verifikasi & Validasi RPTKA</h4>
        <p class="text-muted small mb-0">{{ $rptka->nama_lks }} — {{ $rptka->nama_tka_pemohon }}</p>
    </div>
    <a href="{{ route('superadmin.rptka.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row g-3">
    <div class="col-md-8">
        {{-- Info Permohonan --}}
        <div class="card-modern mb-3">
            <div class="card-header-custom"><i class="bi bi-info-circle text-primary"></i> Informasi Permohonan</div>
            <div class="card-body p-3">
                <div class="info-row"><span class="info-label">Nama LKS</span><span class="info-value fw-semibold">{{ $rptka->nama_lks }}</span></div>
                <div class="info-row"><span class="info-label">Nama TKA Pemohon</span><span class="info-value">{{ $rptka->nama_tka_pemohon }}</span></div>
                <div class="info-row"><span class="info-label">Alamat LKS</span><span class="info-value">{{ $rptka->alamat_lks }}</span></div>
                <div class="info-row">
                    <span class="info-label">Jenis Permohonan</span>
                    <span class="info-value"><span class="badge-pill {{ $rptka->permohonan_rptka == 'Baru' ? 's-baru' : 's-ulang' }}">{{ $rptka->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru' }}</span></span>
                </div>
                <div class="info-row"><span class="info-label">Tanggal Masuk</span><span class="info-value">{{ $rptka->tanggal_masuk_dokumen->format('d F Y') }}</span></div>
                <div class="info-row"><span class="info-label">Verifikator Admin</span><span class="info-value">{{ $rptka->nama_verifikator ?? '-' }}</span></div>
            </div>
        </div>

        {{-- Surat Rekomendasi dari Admin --}}
        <div class="card-modern mb-3">
            <div class="card-header-custom"><i class="bi bi-file-earmark-check text-primary"></i> Surat Rekomendasi dari Admin</div>
            <div class="card-body p-3">
                <div class="sertifikat-box available">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
                        <div>
                            <div class="fw-semibold small">Surat Rekomendasi RPTKA</div>
                            <div class="text-muted" style="font-size:.75rem">Diterbitkan oleh Admin</div>
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.rptka.preview-surat', $rptka->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3"><i class="bi bi-eye"></i> Preview</a>
                        <a href="{{ route('admin.rptka.download-surat', $rptka->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3"><i class="bi bi-download"></i> Download</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dokumen Persyaratan --}}
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
                            <th style="width:15%">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rptka->documentStatuses->sortBy('masterDocument.urutan') as $status)
                        <tr>
                            <td class="text-muted">{{ $status->masterDocument->urutan }}</td>
                            <td>
                                <span class="fw-semibold">{{ $status->masterDocument->nama_dokumen }}</span>
                                @if($status->masterDocument->wajib)
                                    <span class="badge-pill s-ditolak ms-1" style="font-size:.65rem">Wajib</span>
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
                                    <a href="{{ route('rptka.documents.preview', [$rptka->id, $status->master_document_id]) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2"><i class="bi bi-eye"></i></a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Form Verval --}}
    <div class="col-md-4">
        @if($rptka->surat_rekomendasi_rptka_final_path)
        <div class="card-modern mb-3">
            <div class="card-header-custom"><i class="bi bi-patch-check text-success"></i> Surat Final Sudah Ada</div>
            <div class="card-body p-3">
                <div class="sertifikat-box available">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
                        <div>
                            <div class="fw-semibold small">Surat Rekomendasi Final</div>
                            <div class="text-muted" style="font-size:.75rem">Verifikator: {{ $rptka->nama_verifikator_superadmin }}</div>
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('superadmin.rptka.preview-final', $rptka->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('superadmin.rptka.download-final', $rptka->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="card-modern">
            <div class="card-header-custom"><i class="bi bi-patch-check text-primary"></i> Form Verval</div>
            <div class="card-body p-3">
                <form action="{{ route('superadmin.rptka.verification.process', $rptka->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Upload Surat Rekomendasi Final <span class="text-danger">*</span></label>
                        <input type="file" class="form-control form-control-sm @error('surat_rekomendasi_rptka_final') is-invalid @enderror"
                               name="surat_rekomendasi_rptka_final" accept=".pdf" required>
                        <div class="form-text small">Format PDF, maks 5MB</div>
                        @error('surat_rekomendasi_rptka_final')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Verifikator <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm bg-light @error('nama_verifikator_superadmin') is-invalid @enderror"
                               name="nama_verifikator_superadmin"
                               value="{{ old('nama_verifikator_superadmin', auth()->user()->name) }}" readonly>
                        <div class="form-text small">Otomatis diisi sesuai akun yang login</div>
                        @error('nama_verifikator_superadmin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="p-2 rounded-3 mb-3" style="background:#fffbeb; border:1px solid #fde68a; font-size:.8rem; color:#92400e;">
                        <i class="bi bi-info-circle me-1"></i>
                        Setelah verval, status berubah menjadi <strong>Disetujui</strong> dan surat final dapat didownload pemohon.
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill">
                            <i class="bi bi-patch-check me-1"></i> Proses Verval
                        </button>
                        <a href="{{ route('superadmin.rptka.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
