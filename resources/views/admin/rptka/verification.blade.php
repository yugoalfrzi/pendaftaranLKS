@extends('layouts.app')
@section('title', 'Verifikasi RPTKA - ' . $rptka->nama_lks)
@section('page-title', 'Verifikasi RPTKA')

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
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-semibold mb-1"><i class="bi bi-shield-check me-2 text-primary"></i>Verifikasi RPTKA</h4>
        <p class="text-muted small mb-0">{{ $rptka->nama_lks }} — {{ $rptka->nama_tka_pemohon }}</p>
    </div>
    <a href="{{ route('admin.rptka.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
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
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @php
                            $sc = match($rptka->status_permohonan) {
                                'Menunggu' => 's-menunggu', 'Terekomendasi' => 's-proses',
                                'Disetujui' => 's-diterima', 'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan', default => 's-menunggu',
                            };
                        @endphp
                        <span class="badge-pill {{ $sc }}">{{ $rptka->status_permohonan }}</span>
                    </span>
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
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('rptka.documents.preview', [$rptka->id, $status->master_document_id]) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('rptka.documents.download', [$rptka->id, $status->master_document_id]) }}" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                                    </div>
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

    {{-- Form Verifikasi --}}
    <div class="col-md-4">
        <div class="card-modern">
            <div class="card-header-custom"><i class="bi bi-clipboard-check text-primary"></i> Form Verifikasi</div>
            <div class="card-body p-3">
                <form action="{{ route('admin.rptka.verification.process', $rptka->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Status Verifikasi <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm @error('status_permohonan') is-invalid @enderror" name="status_permohonan" id="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                            <option value="Dikembalikan">Dikembalikan</option>
                        </select>
                        @error('status_permohonan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3" id="suratDiv" style="display:none;">
                        <label class="form-label small fw-semibold">Upload Surat Rekomendasi RPTKA</label>
                        <input type="file" class="form-control form-control-sm @error('surat_rekomendasi_rptka') is-invalid @enderror" name="surat_rekomendasi_rptka" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text small">PDF/JPG/PNG, maks 5MB</div>
                        @error('surat_rekomendasi_rptka')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if($rptka->surat_rekomendasi_rptka_path)
                        <div class="doc-file-item mt-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-file-earmark-check text-success"></i>
                                <span>Surat sudah ada</span>
                            </div>
                            <a href="{{ route('admin.rptka.preview-surat', $rptka->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2"><i class="bi bi-eye"></i></a>
                        </div>
                        @endif
                    </div>

                    <div class="mb-3" id="tolakDiv" style="display:none;">
                        <label class="form-label small fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" name="alasan_penolakan" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>

                    <div class="mb-3" id="kembaliDiv" style="display:none;">
                        <label class="form-label small fw-semibold">Alasan Dikembalikan <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" name="alasan_dikembalikan" rows="3" placeholder="Masukkan alasan dikembalikan..."></textarea>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-success btn-sm rounded-pill">
                            <i class="bi bi-check-circle me-1"></i> Simpan Verifikasi
                        </button>
                        <a href="{{ route('admin.rptka.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('status').addEventListener('change', function() {
    const val = this.value;
    document.getElementById('suratDiv').style.display = val === 'Diterima' ? 'block' : 'none';
    document.getElementById('tolakDiv').style.display = val === 'Ditolak' ? 'block' : 'none';
    document.getElementById('kembaliDiv').style.display = val === 'Dikembalikan' ? 'block' : 'none';
});
</script>
@endsection
