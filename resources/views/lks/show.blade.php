@extends('layouts.app')

@section('title', 'Detail LKS - {{ $lks->nama_lks }}')
@section('page-title', 'Detail LKS')

@section('content')
<style>
    .card-modern {
        border-radius: 1.25rem; border: 1px solid #edf2f7;
        background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.02); overflow: hidden;
    }
    .card-header-custom {
        background: #fff; border-bottom: 1px solid #eef2f6;
        padding: 0.9rem 1.25rem; font-weight: 600; font-size: 0.9rem;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .info-row {
        display: flex; padding: 0.55rem 0;
        border-bottom: 1px solid #f8fafc; font-size: 0.85rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label {
        width: 42%; color: #64748b; font-weight: 500; flex-shrink: 0;
    }
    .info-value { color: #1e293b; flex: 1; }
    .badge-pill {
        display: inline-flex; align-items: center; gap: 0.25rem;
        padding: 0.2rem 0.65rem; border-radius: 2rem;
        font-size: 0.72rem; font-weight: 500;
    }
    .s-menunggu     { background:#fef3c7; color:#b45309; }
    .s-proses       { background:#dbeafe; color:#1d4ed8; }
    .s-diterima     { background:#dcfce7; color:#15803d; }
    .s-terverifikasi{ background:#e0e7ff; color:#4338ca; }
    .s-ditolak      { background:#fee2e2; color:#b91c1c; }
    .s-dikembalikan { background:#e0f2fe; color:#0369a1; }
    .s-baru         { background:#dcfce7; color:#15803d; }
    .s-ulang        { background:#e0f2fe; color:#0369a1; }
    .doc-file-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.5rem 0.75rem; border-radius: 0.6rem;
        background: #f8fafc; border: 1px solid #e2e8f0;
        margin-bottom: 0.4rem; font-size: 0.82rem;
    }
    .doc-file-item:last-child { margin-bottom: 0; }
    .table-doc th {
        background: #f8fafc; font-size: 0.72rem; text-transform: uppercase;
        letter-spacing: 0.04em; color: #475569; padding: 0.7rem 1rem;
        border-bottom: 1px solid #e2e8f0; white-space: nowrap;
    }
    .table-doc td {
        padding: 0.75rem 1rem; vertical-align: middle;
        border-bottom: 1px solid #f1f5f9; font-size: 0.83rem;
    }
    .sertifikat-box {
        border-radius: 0.75rem; padding: 1rem 1.25rem;
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem; flex-wrap: wrap;
    }
    .sertifikat-box.available { background: #f0fdf4; border: 1px solid #bbf7d0; }
    .sertifikat-box.unavailable { background: #f8fafc; border: 1px solid #e2e8f0; }
    .alasan-box {
        background: #fff8f0; border: 1px solid #fed7aa;
        border-radius: 0.75rem; padding: 0.85rem 1rem;
        font-size: 0.83rem; color: #92400e;
    }
    .alasan-box.danger { background: #fff1f2; border-color: #fecdd3; color: #9f1239; }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-semibold mb-1">{{ $lks->nama_lks }}</h1>
        <div class="d-flex align-items-center gap-2 flex-wrap">
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
            <span class="badge-pill {{ $lks->kewenangan_type === 'kabkota' ? 's-proses' : 's-terverifikasi' }}">
                {{ $lks->kewenangan_type === 'kabkota' ? 'Kewenangan Kab/Kota' : 'Kewenangan Provinsi' }}
            </span>
            <span class="text-muted small"><i class="bi bi-clock-history me-1"></i>Diperbarui {{ $lks->updated_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.verification', $lks->id) }}" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="bi bi-clipboard-check me-1"></i> Verifikasi
            </a>
        @endif
        @if(auth()->user()->hasRole(['user','admin']))
            <a href="{{ route('lks.edit', $lks->id) }}" class="btn btn-outline-warning btn-sm rounded-pill px-3">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        @endif
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

{{-- Alasan Penolakan / Dikembalikan --}}
@if($lks->status_permohonan === 'Ditolak' && $lks->alasan_penolakan)
<div class="alasan-box danger mb-4">
    <i class="bi bi-x-circle me-2"></i><strong>Alasan Penolakan:</strong> {{ $lks->alasan_penolakan }}
</div>
@endif
@if($lks->status_permohonan === 'Dikembalikan' && $lks->alasan_dikembalikan)
<div class="alasan-box mb-4">
    <i class="bi bi-arrow-counterclockwise me-2"></i><strong>Alasan Dikembalikan:</strong> {{ $lks->alasan_dikembalikan }}
</div>
@endif

<div class="row g-3 mb-3">
    {{-- Informasi Umum --}}
    <div class="col-md-6">
        <div class="card-modern h-100">
            <div class="card-header-custom">
                <i class="bi bi-info-circle text-primary"></i> Informasi Umum
            </div>
            <div class="card-body p-3">
                <div class="info-row"><span class="info-label">Nama LKS</span><span class="info-value fw-semibold">{{ $lks->nama_lks ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Alamat</span><span class="info-value">{{ $lks->alamat_lks ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Kabupaten/Kota</span><span class="info-value">{{ $lks->kabupaten_kota ?? $lks->lokasi_lks ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Nama Ketua</span><span class="info-value">{{ $lks->nama_ketua_lks ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Jenis Pelayanan</span><span class="info-value">{{ $lks->jenis_pelayanan ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Binaan Dalam Panti</span><span class="info-value">{{ $lks->jumlah_binaan_dalam_panti ?? '0' }} orang</span></div>
                <div class="info-row"><span class="info-label">Binaan Luar Panti</span><span class="info-value">{{ $lks->jumlah_binaan_luar_panti ?? '0' }} orang</span></div>
                <div class="info-row"><span class="info-label">Nomor Kontak</span><span class="info-value">{{ $lks->nomor_kontak ?? '-' }}</span></div>
                @if($lks->kewenangan_type === 'provinsi')
                <div class="info-row"><span class="info-label">Pusat LKS</span><span class="info-value">{{ $lks->pusat_lks ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Cabang LKS</span><span class="info-value">{{ $lks->cabang_lks ?? '-' }}</span></div>
                @endif
            </div>
        </div>
    </div>

    {{-- Informasi Pendaftaran & Verifikasi --}}
    <div class="col-md-6">
        <div class="card-modern mb-3">
            <div class="card-header-custom">
                <i class="bi bi-file-earmark-text text-primary"></i> Pendaftaran
            </div>
            <div class="card-body p-3">
                <div class="info-row">
                    <span class="info-label">Tanda Pendaftaran</span>
                    <span class="info-value">
                        <span class="badge-pill {{ $lks->tanda_pendaftaran === 'Baru' ? 's-baru' : 's-ulang' }}">
                            {{ $lks->tanda_pendaftaran ?? '-' }}
                        </span>
                    </span>
                </div>
                <div class="info-row"><span class="info-label">Tgl Masuk Dokumen</span><span class="info-value">{{ optional($lks->tanggal_masuk_dokumen)->format('d/m/Y') ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Tgl Persyaratan</span><span class="info-value">{{ optional($lks->tanggal_persyaratan)->format('d/m/Y') ?? '-' }}</span></div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value"><span class="badge-pill {{ $sc }}">{{ $lks->status_permohonan }}</span></span>
                </div>
                @if($lks->nama_verifikator)
                <div class="info-row"><span class="info-label">Verifikator</span><span class="info-value">{{ $lks->nama_verifikator }}</span></div>
                @endif
            </div>
        </div>

        {{-- Sertifikat & Dokumen --}}
        <div class="card-modern">
            <div class="card-header-custom">
                <i class="bi bi-file-earmark-pdf text-primary"></i> Dokumen Resmi
            </div>
            <div class="card-body p-3 d-flex flex-column gap-2">

                {{-- Sertifikat Kab/Kota --}}
                @if($lks->kewenangan_type === 'kabkota')
                    @if($lks->sertifikat_kabkota_path)
                        <div class="sertifikat-box available">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
                                <div>
                                    <div class="fw-semibold small">Tanda Pendaftaran Kab/Kota</div>
                                    <div class="text-muted" style="font-size:.75rem">Diterbitkan oleh Admin</div>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <a href="{{ route('lks.preview-sertifikat-kabkota', $lks->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                    <i class="bi bi-eye"></i> Preview
                                </a>
                                <a href="{{ route('lks.download-sertifikat-kabkota', $lks->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('admin.verification.delete-sertifikat-kabkota', $lks->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus sertifikat?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-pill px-2"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="sertifikat-box unavailable">
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <i class="bi bi-file-earmark-x fs-5"></i>
                                <div>
                                    <div class="fw-semibold small">Tanda Pendaftaran Kab/Kota</div>
                                    <div style="font-size:.75rem">Belum diterbitkan</div>
                                </div>
                            </div>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.verification', $lks->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                    <i class="bi bi-upload me-1"></i> Upload
                                </a>
                            @endif
                        </div>
                    @endif
                @endif

                {{-- Surat Rekomendasi (Provinsi dari Admin) --}}
                @if($lks->surat_rekomendasi_path)
                    <div class="sertifikat-box available">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
                            <div>
                                <div class="fw-semibold small">Surat Rekomendasi</div>
                                <div class="text-muted" style="font-size:.75rem">Diterbitkan oleh Admin</div>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('lks.preview-surat-rekomendasi', $lks->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                <i class="bi bi-eye"></i> Preview
                            </a>
                            <a href="{{ route('lks.download-surat-rekomendasi', $lks->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Sertifikat Provinsi (dari Super Admin) --}}
                @if($lks->sertifikat_path)
                    <div class="sertifikat-box available">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
                            <div>
                                <div class="fw-semibold small">Sertifikat Provinsi</div>
                                <div class="text-muted" style="font-size:.75rem">Diterbitkan oleh Super Admin</div>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('lks.preview-sertifikat-provinsi', $lks->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                <i class="bi bi-eye"></i> Preview
                            </a>
                            <a href="{{ route('lks.download-sertifikat-provinsi', $lks->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    </div>
                @endif

                @if(!$lks->sertifikat_kabkota_path && !$lks->surat_rekomendasi_path && !$lks->sertifikat_path)
                    <div class="sertifikat-box unavailable">
                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="bi bi-file-earmark-x fs-5"></i>
                            <div>
                                <div class="fw-semibold small">Belum Ada Dokumen Resmi</div>
                                <div style="font-size:.75rem">Akan tersedia setelah proses verifikasi selesai</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Checklist Dokumen --}}
<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-check2-square text-primary"></i> Checklist Dokumen
        <span class="ms-auto text-muted small fw-normal">{{ $lks->checklists->where('kelengkapan','Ada')->count() }} / {{ $lks->checklists->count() }} dokumen tersedia</span>
    </div>
    <div class="table-responsive">
        <table class="table table-doc mb-0">
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th style="width:22%">Nama Dokumen</th>
                    <th style="width:10%">Status</th>
                    <th>File</th>
                    <th style="width:15%">Keterangan</th>
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
                        @if($checklist->kelengkapan == 'Ada')
                            <span class="badge-pill s-diterima"><i class="bi bi-check-circle me-1"></i>Ada</span>
                        @else
                            <span class="badge-pill s-ditolak"><i class="bi bi-x-circle me-1"></i>Tidak Ada</span>
                        @endif
                    </td>
                    <td>
                        @if($checklist->has_files)
                            @foreach($checklist->getFilesInfo() as $fileIndex => $file)
                            <div class="doc-file-item">
                                <a href="{{ route('lks.files.show', [$lks->id, $checklist->id, $file['index']]) }}" target="_blank" class="text-decoration-none text-primary d-flex align-items-center gap-1">
                                    <i class="bi bi-file-earmark-text"></i>
                                    <span>{{ $file['name'] }}</span>
                                </a>
                                <form action="{{ route('lks.files.destroy', [$lks->id, $checklist->id, $file['index']]) }}" method="POST" onsubmit="return confirm('Hapus file ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2" style="font-size:.72rem">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
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

@endsection
