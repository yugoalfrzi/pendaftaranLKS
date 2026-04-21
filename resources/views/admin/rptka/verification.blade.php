@extends('layouts.app')
@section('title', 'Verifikasi RPTKA - ' . $rptka->nama_lks)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-shield-check"></i> Verifikasi RPTKA</h1>
    <a href="{{ route('admin.rptka.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Info -->
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Informasi Permohonan</h5></div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td width="35%"><strong>Nama LKS</strong></td><td>{{ $rptka->nama_lks }}</td></tr>
                    <tr><td><strong>Nama TKA</strong></td><td>{{ $rptka->nama_tka_pemohon }}</td></tr>
                    <tr><td><strong>Alamat</strong></td><td>{{ $rptka->alamat_lks }}</td></tr>
                    <tr><td><strong>Jenis</strong></td><td><span class="badge {{ $rptka->permohonan_rptka == 'Baru' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $rptka->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru' }}</span></td></tr>
                    <tr><td><strong>Tgl Masuk</strong></td><td>{{ $rptka->tanggal_masuk_dokumen->format('d F Y') }}</td></tr>
                    <tr><td><strong>Status</strong></td><td><span class="badge {{ $rptka->status_badge }}">{{ $rptka->status_permohonan }}</span></td></tr>
                </table>
            </div>
        </div>

        <!-- Dokumen -->
        <div class="card">
            <div class="card-header bg-info text-white"><h5 class="mb-0">Dokumen Persyaratan</h5></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr><th width="5%">No</th><th>Nama Dokumen</th><th width="12%">Status</th><th width="15%">File</th></tr>
                        </thead>
                        <tbody>
                            @foreach($rptka->documentStatuses->sortBy('masterDocument.urutan') as $status)
                            <tr>
                                <td class="text-center">{{ $status->masterDocument->urutan }}</td>
                                <td><strong>{{ $status->masterDocument->nama_dokumen }}</strong></td>
                                <td class="text-center">
                                    @if($status->is_ada)<span class="badge bg-success"><i class="bi bi-check"></i> Ada</span>
                                    @else<span class="badge bg-danger"><i class="bi bi-x"></i> Belum</span>@endif
                                </td>
                                <td>
                                    @if($status->file_path)
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('rptka.documents.preview', [$rptka->id, $status->master_document_id]) }}" class="btn btn-outline-info" target="_blank"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('rptka.documents.download', [$rptka->id, $status->master_document_id]) }}" class="btn btn-outline-success"><i class="bi bi-download"></i></a>
                                        </div>
                                    @else<span class="text-muted small">-</span>@endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Verifikasi -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white"><h5 class="mb-0">Form Verifikasi</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.rptka.verification.process', $rptka->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_permohonan') is-invalid @enderror" name="status_permohonan" id="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                            <option value="Dikembalikan">Dikembalikan</option>
                        </select>
                        @error('status_permohonan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3" id="suratDiv" style="display:none;">
                        <label class="form-label">Upload Surat Rekomendasi RPTKA</label>
                        <input type="file" class="form-control @error('surat_rekomendasi_rptka') is-invalid @enderror" name="surat_rekomendasi_rptka" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">PDF/JPG/PNG, maks 5MB</small>
                        @error('surat_rekomendasi_rptka')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if($rptka->surat_rekomendasi_rptka_path)
                        <div class="alert alert-info p-2 mt-2 mb-0">
                            <i class="bi bi-file-earmark-check"></i> Surat sudah ada
                            <a href="{{ route('admin.rptka.preview-surat', $rptka->id) }}" target="_blank" class="btn btn-sm btn-outline-info ms-2"><i class="bi bi-eye"></i></a>
                        </div>
                        @endif
                    </div>

                    <div class="mb-3" id="tolakDiv" style="display:none;">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="alasan_penolakan" rows="3"></textarea>
                    </div>

                    <div class="mb-3" id="kembaliDiv" style="display:none;">
                        <label class="form-label">Alasan Dikembalikan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="alasan_dikembalikan" rows="3"></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Simpan Verifikasi</button>
                        <a href="{{ route('admin.rptka.index') }}" class="btn btn-outline-secondary">Batal</a>
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
