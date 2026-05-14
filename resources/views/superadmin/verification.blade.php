@extends('layouts.app')

@section('title', 'Verifikasi LKS - Super Admin')
@section('page-title', 'Verifikasi LKS')

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
        border-bottom:1px solid #e2e8f0; w
        hite-space:nowrap; 
    }
    .table-doc td { 
        padding:0.75rem 1rem; 
        vertical-align:middle; 
        border-bottom:1px solid #f1f5f9; 
        font-size:0.83rem; 
    }
    .alasan-box { 
        background:#fff8f0; 
        border:1px solid #fed7aa; 
        border-radius:0.75rem; 
        padding:0.85rem 1rem; 
        font-size:0.83rem; 
        color:#92400e; 
    }
    .alasan-box.danger { 
        background:#fff1f2; 
        border-color:#fecdd3; 
        color:#9f1239; 
    }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-semibold mb-1">Upload tanda pendaftaran LKS</h4>
        <p class="text-muted small mb-0">{{ $lks->nama_lks }}</p>
    </div>
    <a href="{{ route('superadmin.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Super Admin Panel
    </a>
</div>

@if($lks->alasan_penolakan)
<div class="alasan-box danger mb-4">
    <i class="bi bi-x-circle me-2"></i><strong>Alasan Penolakan:</strong> {{ $lks->alasan_penolakan }}
</div>
@endif
@if($lks->alasan_dikembalikan)
<div class="alasan-box mb-4">
    <i class="bi bi-arrow-counterclockwise me-2"></i><strong>Alasan Dikembalikan:</strong> {{ $lks->alasan_dikembalikan }}
</div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <div class="card-modern mb-3">
            <div class="card-header-custom">
                <i class="bi bi-info-circle text-primary"></i> Informasi Pendaftaran
            </div>
            <div class="card-body p-3">
                <div class="row g-0">
                    <div class="col-md-6 pe-md-3">
                        <div class="info-row"><span class="info-label">Nama LKS</span><span class="info-value fw-semibold">{{ $lks->nama_lks }}</span></div>
                        <div class="info-row"><span class="info-label">Alamat LKS</span><span class="info-value">{{ $lks->alamat_lks }}</span></div>
                        <div class="info-row"><span class="info-label">Nama Ketua</span><span class="info-value">{{ $lks->nama_ketua_lks ?? '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Jenis Pelayanan</span><span class="info-value">{{ $lks->jenis_pelayanan ?? '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Binaan Dalam Panti</span><span class="info-value">{{ $lks->jumlah_binaan_dalam_panti ?? '0' }}</span></div>
                        <div class="info-row"><span class="info-label">Binaan Luar Panti</span><span class="info-value">{{ $lks->jumlah_binaan_luar_panti ?? '0' }}</span></div>
                        <div class="info-row"><span class="info-label">Nomor Kontak</span><span class="info-value">{{ $lks->nomor_kontak ?? '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Kabupaten/Kota</span><span class="info-value">{{ $lks->kabupaten_kota ?? '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Lokasi LKS</span><span class="info-value">{{ $lks->lokasi_lks ?? '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Pusat LKS</span><span class="info-value">{{ $lks->pusat_lks ?? '-' }}</span></div>
                        <div class="info-row"><span class="info-label">Cabang LKS</span><span class="info-value">{{ $lks->cabang_lks ?? '-' }}</span></div>
                    </div>
                    <div class="col-md-6 ps-md-3" style="border-left:1px solid #f1f5f9;">
                        <div class="info-row">
                            <span class="info-label">Tanda Pendaftaran</span>
                            <span class="info-value"><span class="badge-pill {{ $lks->tanda_pendaftaran == 'Baru' ? 's-baru' : 's-ulang' }}">{{ $lks->tanda_pendaftaran }}</span></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Kewenangan</span>
                            <span class="info-value">
                                @if($lks->kewenangan_type == 'kabkota')
                                    <span class="badge-pill s-proses"><i class="bi bi-building"></i> Kab/Kota</span>
                                @elseif($lks->kewenangan_type == 'provinsi')
                                    <span class="badge-pill s-terverifikasi"><i class="bi bi-map"></i> Provinsi</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-row"><span class="info-label">Tanggal Masuk</span><span class="info-value">{{ \Carbon\Carbon::parse($lks->tanggal_masuk_dokumen)->format('d/m/Y') }}</span></div>
                        <div class="info-row">
                            <span class="info-label">Status Saat Ini</span>
                            <span class="info-value">
                                @php
                                    $sc = match($lks->status_permohonan) {
                                        'Menunggu','Menunggu kelengkapan data' => 's-menunggu',
                                        'Diterima untuk proses' => 's-proses',
                                        'Diterima' => 's-diterima',
                                        'Terverifikasi' => 's-terverifikasi',
                                        'Ditolak' => 's-ditolak',
                                        'Dikembalikan' => 's-dikembalikan',
                                        default => 's-menunggu',
                                    };
                                @endphp
                                <span class="badge-pill {{ $sc }}">{{ $lks->status_permohonan }}</span>
                            </span>
                        </div>
                        <div class="info-row"><span class="info-label">Verifikator Admin</span><span class="info-value">{{ $lks->nama_verifikator ?? '-' }}</span></div>
                        @if($lks->user)
                        <div class="info-row"><span class="info-label">Email Pendaftar</span><span class="info-value">{{ $lks->user->email }}</span></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($lks->checklists && $lks->checklists->count() > 0)
        <div class="card-modern">
            <div class="card-header-custom">
                <i class="bi bi-clipboard-check text-primary"></i> Kelengkapan Dokumen
            </div>
            <div class="table-responsive">
                <table class="table table-doc mb-0">
                    <thead>
                        <tr>
                            <th style="width:4%">No</th>
                            <th style="width:28%">Nama Dokumen</th>
                            <th>File Dokumen</th>
                            <th style="width:14%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lks->checklists as $index => $checklist)
                        <tr>
                            <td class="text-muted">{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-semibold">{{ $checklist->document->nama_dokumen }}</span>
                                @if($checklist->document->wajib)
                                    <span class="badge-pill s-ditolak ms-1" style="font-size:.65rem">Wajib</span>
                                @endif
                            </td>
                            <td>
                                @if($checklist->has_files)
                                    @foreach($checklist->getFilesInfo() as $fileIndex => $file)
                                    <div class="doc-file-item">
                                        @php $fileUrl = $file['url'] ?? null; @endphp
                                        <a href="{{ $fileUrl ?? route('lks.files.show', ['lks' => $lks->id, 'document' => $checklist->id, 'file' => $file['index']]) }}" target="_blank" class="text-decoration-none text-primary d-flex align-items-center gap-1">
                                            <i class="bi bi-file-earmark-pdf text-danger"></i>
                                            <span>{{ $file['name'] }}</span>
                                        </a>
                                        <a href="{{ route('lks.files.show', ['lks' => $lks->id, 'document' => $checklist->id, 'file' => $file['index']]) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-2" style="font-size:.72rem">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </div>
                                    @endforeach
                                @else
                                    <span class="text-muted small"><i class="bi bi-file-earmark-x me-1"></i>Tidak ada file</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $checklist->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card-modern">
            <div class="card-header-custom">
                <i class="bi bi-clipboard-check text-primary"></i> Form Upload Tanda Pendaftaran
            </div>
            <div class="card-body p-3">
                <form action="{{ route('superadmin.verification.process', $lks->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="status_permohonan" class="form-label small fw-semibold">Status Verifikasi <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm @error('status_permohonan') is-invalid @enderror" id="status_permohonan" name="status_permohonan" required>
                            <option value="">Pilih Status</option>
                            <option value="Diterima untuk proses" {{ old('status_permohonan', $lks->status_permohonan) == 'Diterima untuk proses' ? 'selected' : '' }}>
                                Upload Tanda Pendaftaran (Otomatis → Diterima)
                            </option>
                            <option value="Ditolak" {{ old('status_permohonan', $lks->status_permohonan) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Dikembalikan" {{ old('status_permohonan', $lks->status_permohonan) == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                        @error('status_permohonan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3" id="sertifikat_div" style="display:none;">
                        <label for="sertifikat" class="form-label small fw-semibold">Upload Tanda Pendaftaran (PDF) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control form-control-sm @error('sertifikat') is-invalid @enderror" id="sertifikat" name="sertifikat" accept=".pdf">
                        <div class="form-text small">Format: PDF. Maks: 5MB</div>
                        @error('sertifikat')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        @if($lks->surat_rekomendasi_path)
                        <div class="doc-file-item mt-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-file-earmark-check text-success"></i>
                                <span class="fw-semibold">Surat Rekomendasi (dari Admin)</span>
                            </div>
                            <div class="d-flex gap-1">
                                <a href="{{ route('superadmin.download-rekomendasi', $lks->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                                <a href="{{ route('superadmin.preview-rekomendasi', $lks->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-2" target="_blank"><i class="bi bi-eye"></i></a>
                            </div>
                        </div>
                        @endif

                        @if($lks->sertifikat_path)
                        <div class="doc-file-item mt-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-file-earmark-pdf text-danger"></i>
                                <span class="fw-semibold">Tanda Pendaftaran sudah diupload</span>
                            </div>
                            <div class="d-flex gap-1">
                                <a href="{{ route('superadmin.download-surat', $lks->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2"><i class="bi bi-download"></i></a>
                                <a href="{{ route('superadmin.preview-surat', $lks->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-2" target="_blank"><i class="bi bi-eye"></i></a>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="verifikator" class="form-label small fw-semibold">ID Verifikator</label>
                        <input type="text" class="form-control form-control-sm bg-light" id="verifikator" name="verifikator" value="{{ auth()->user()->id }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="nama_verifikator" class="form-label small fw-semibold">Nama Verifikator</label>
                        <input type="text" class="form-control form-control-sm bg-light" id="nama_verifikator" name="nama_verifikator" value="{{ auth()->user()->name }}" readonly>
                        <div class="form-text small">Otomatis diisi sesuai akun yang login</div>
                    </div>

                    <div class="mb-3" id="alasan_penolakan_div" style="display:none;">
                        <label for="alasan_penolakan" class="form-label small fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm @error('alasan_penolakan') is-invalid @enderror" id="alasan_penolakan" name="alasan_penolakan" rows="3" placeholder="Masukkan alasan penolakan...">{{ old('alasan_penolakan', $lks->alasan_penolakan) }}</textarea>
                        @error('alasan_penolakan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3" id="alasan_dikembalikan_div" style="display:none;">
                        <label for="alasan_dikembalikan" class="form-label small fw-semibold">Alasan Dikembalikan <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm @error('alasan_dikembalikan') is-invalid @enderror" id="alasan_dikembalikan" name="alasan_dikembalikan" rows="3" placeholder="Masukkan alasan dikembalikan...">{{ old('alasan_dikembalikan', $lks->alasan_dikembalikan) }}</textarea>
                        @error('alasan_dikembalikan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-success btn-sm rounded-pill">
                            <i class="bi bi-check-circle me-1"></i> Simpan Verifikasi
                        </button>
                        <a href="{{ route('superadmin.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status_permohonan');
    const sertifikatDiv = document.getElementById('sertifikat_div');
    const alasanPenolakanDiv = document.getElementById('alasan_penolakan_div');
    const alasanDikembalikanDiv = document.getElementById('alasan_dikembalikan_div');
    const alasanPenolakan = document.getElementById('alasan_penolakan');
    const alasanDikembalikan = document.getElementById('alasan_dikembalikan');
    const sertifikatInput = document.getElementById('sertifikat');

    function toggleFields() {
        const status = statusSelect.value;
        sertifikatDiv.style.display = 'none';
        alasanPenolakanDiv.style.display = 'none';
        alasanDikembalikanDiv.style.display = 'none';
        alasanPenolakan.required = false;
        alasanDikembalikan.required = false;
        sertifikatInput.required = false;
        if (status === 'Diterima untuk proses') {
            sertifikatDiv.style.display = 'block';
            if (!{{ $lks->sertifikat_path ? 'true' : 'false' }}) sertifikatInput.required = true;
        } else if (status === 'Ditolak') {
            alasanPenolakanDiv.style.display = 'block';
            alasanPenolakan.required = true;
        } else if (status === 'Dikembalikan') {
            alasanDikembalikanDiv.style.display = 'block';
            alasanDikembalikan.required = true;
        }
    }

    toggleFields();
    statusSelect.addEventListener('change', toggleFields);

    sertifikatInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.type !== 'application/pdf') { alert('Hanya file PDF yang diizinkan!'); e.target.value = ''; return; }
            if (file.size > 5 * 1024 * 1024) { alert('Ukuran file maksimal 5MB!'); e.target.value = ''; }
        }
    });
});
</script>
@endsection
