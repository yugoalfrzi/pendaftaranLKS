@extends('layouts.app')

@section('title', 'Detail RPTKA - ' . $rptka->nama_lks)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0"><i class="bi bi-file-earmark-text"></i> Detail Permohonan RPTKA</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('rptka.edit', $rptka->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('rptka.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <!-- Info Permohonan -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-info-circle"></i> Informasi Permohonan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="35%"><strong>Nama LKS</strong></td>
                        <td>{{ $rptka->nama_lks }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama TKA Pemohon</strong></td>
                        <td>{{ $rptka->nama_tka_pemohon }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat LKS</strong></td>
                        <td>{{ $rptka->alamat_lks }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Permohonan</strong></td>
                        <td>
                            <span class="badge {{ $rptka->permohonan_rptka == 'Baru' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $rptka->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status Permohonan</strong></td>
                        <td><span class="badge {{ $rptka->status_badge }}">{{ $rptka->status_permohonan }}</span></td>
                    </tr>
                    @if($rptka->alasan_penolakan)
                    <tr><td><strong>Alasan Penolakan</strong></td><td class="text-danger">{{ $rptka->alasan_penolakan }}</td></tr>
                    @endif
                    @if($rptka->alasan_dikembalikan)
                    <tr><td><strong>Alasan Dikembalikan</strong></td><td class="text-info">{{ $rptka->alasan_dikembalikan }}</td></tr>
                    @endif
                    <tr>
                        <td><strong>Tanggal Lengkap</strong></td>
                        <td>
                            @if($rptka->tanggal_persyaratan_lengkap)
                                <span class="text-success">
                                    <i class="bi bi-check-circle"></i>
                                    {{ $rptka->tanggal_persyaratan_lengkap->format('d F Y') }}
                                </span>
                            @else
                                <span class="text-muted">Belum lengkap</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Dokumen Persyaratan -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0"><i class="bi bi-clipboard-check"></i> Dokumen Persyaratan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Dokumen</th>
                                <th width="12%">Status</th>
                                <th width="20%">File</th>
                                <th width="20%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rptka->documentStatuses->sortBy('masterDocument.urutan') as $status)
                            <tr>
                                <td class="text-center">{{ $status->masterDocument->urutan }}</td>
                                <td>
                                    <strong>{{ $status->masterDocument->nama_dokumen }}</strong>
                                    @if($status->masterDocument->wajib)
                                        <span class="badge bg-danger ms-1">Wajib</span>
                                    @endif
                                    @if($status->masterDocument->kategori == 'perpanjangan')
                                        <span class="badge bg-warning text-dark ms-1">Perpanjangan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($status->is_ada)
                                        <span class="badge bg-success"><i class="bi bi-check"></i> Ada</span>
                                    @else
                                        <span class="badge bg-danger"><i class="bi bi-x"></i> Belum</span>
                                    @endif
                                </td>
                                <td>
                                    @if($status->file_path)
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('rptka.documents.preview', [$rptka->id, $status->master_document_id]) }}"
                                               class="btn btn-outline-info" target="_blank" title="Preview">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('rptka.documents.download', [$rptka->id, $status->master_document_id]) }}"
                                               class="btn btn-outline-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td><small>{{ $status->keterangan ?? '-' }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada dokumen</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><h6 class="mb-0">Kelengkapan Dokumen</h6></div>
            <div class="card-body">
                @php $pct = $rptka->completionPercentage() @endphp
                <div class="progress mb-2" style="height:14px;">
                    <div class="progress-bar {{ $pct == 100 ? 'bg-success' : 'bg-primary' }}"
                         style="width:{{ $pct }}%">{{ $pct }}%</div>
                </div>
                @php
                    $total = $rptka->documentStatuses->count();
                    $ada   = $rptka->documentStatuses->where('is_ada', true)->count();
                @endphp
                <small class="text-muted">{{ $ada }} dari {{ $total }} dokumen dilengkapi</small>

                @if($rptka->tanggal_persyaratan_lengkap)
                    <div class="alert alert-success mt-3 mb-0 p-2">
                        <i class="bi bi-check-circle"></i> Semua dokumen lengkap
                    </div>
                @endif
            </div>
        </div>

        <div class="d-grid gap-2">
            @if($rptka->surat_rekomendasi_rptka_final_path)
            <div class="card border-success mb-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-patch-check"></i> Surat Rekomendasi RPTKA</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-2">Surat rekomendasi RPTKA final telah diterbitkan. Silakan download.</p>
                    <a href="{{ route('rptka.download-surat-final', $rptka->id) }}" class="btn btn-success w-100">
                        <i class="bi bi-download"></i> Download Surat Rekomendasi
                    </a>
                </div>
            </div>
            @endif

            @if(in_array($rptka->status_permohonan, ['Menunggu', 'Dikembalikan']))
            <a href="{{ route('rptka.edit', $rptka->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Permohonan
            </a>
            @endif
            <form action="{{ route('rptka.destroy', $rptka->id) }}" method="POST"
                  onsubmit="return confirm('Hapus permohonan RPTKA ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger w-100">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
