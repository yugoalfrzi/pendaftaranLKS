@extends('layouts.app')

@section('title', 'Edit RPTKA - ' . $rptka->nama_lks)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0"><i class="bi bi-pencil"></i> Edit Permohonan RPTKA</h1>
            <a href="{{ route('rptka.show', $rptka->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('rptka.update', $rptka->id) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="row">
        <div class="col-md-8">
            <!-- Informasi Umum -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-info-circle"></i> Informasi Permohonan</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama LKS <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lks"
                                   class="form-control @error('nama_lks') is-invalid @enderror"
                                   value="{{ old('nama_lks', $rptka->nama_lks) }}" required>
                            @error('nama_lks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama TKA Pemohon <span class="text-danger">*</span></label>
                            <input type="text" name="nama_tka_pemohon"
                                   class="form-control @error('nama_tka_pemohon') is-invalid @enderror"
                                   value="{{ old('nama_tka_pemohon', $rptka->nama_tka_pemohon) }}" required>
                            @error('nama_tka_pemohon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat LKS <span class="text-danger">*</span></label>
                            <textarea name="alamat_lks" rows="3"
                                      class="form-control @error('alamat_lks') is-invalid @enderror"
                                      required>{{ old('alamat_lks', $rptka->alamat_lks) }}</textarea>
                            @error('alamat_lks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Permohonan <span class="text-danger">*</span></label>
                            <select name="permohonan_rptka" id="permohonan_rptka"
                                    class="form-select @error('permohonan_rptka') is-invalid @enderror" required>
                                <option value="Baru" {{ old('permohonan_rptka', $rptka->permohonan_rptka) == 'Baru' ? 'selected' : '' }}>Baru</option>
                                <option value="Ulang" {{ old('permohonan_rptka', $rptka->permohonan_rptka) == 'Ulang' ? 'selected' : '' }}>Perpanjangan (Ulang)</option>
                            </select>
                            @error('permohonan_rptka')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk Dokumen <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_masuk_dokumen"
                                   class="form-control @error('tanggal_masuk_dokumen') is-invalid @enderror"
                                   value="{{ old('tanggal_masuk_dokumen', $rptka->tanggal_masuk_dokumen->format('Y-m-d')) }}" required>
                            @error('tanggal_masuk_dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
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
                                    <th width="30%">Nama Dokumen</th>
                                    <th width="8%">Ada</th>
                                    <th width="30%">Upload File</th>
                                    <th width="27%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $statusMap = $rptka->documentStatuses->keyBy('master_document_id');
                                    $jenis = old('permohonan_rptka', $rptka->permohonan_rptka);
                                    $docs = \App\Models\MasterDocument::when($jenis == 'Baru', fn($q) => $q->where('kategori', 'utama'))
                                                ->when($jenis == 'Ulang', fn($q) => $q->whereIn('kategori', ['utama', 'perpanjangan']))
                                                ->orderBy('urutan')->get();
                                @endphp
                                @foreach($docs as $doc)
                                    @php $status = $statusMap->get($doc->id) @endphp
                                    @if($doc->kategori == 'perpanjangan' && $loop->first || ($doc->kategori == 'perpanjangan' && $docs[$loop->index - 1]->kategori != 'perpanjangan'))
                                    <tr class="table-warning">
                                        <td colspan="5" class="fw-bold text-center">
                                            <i class="bi bi-arrow-repeat"></i> Dokumen Tambahan Perpanjangan
                                        </td>
                                    </tr>
                                    @endif
                                <tr>
                                    <td class="text-center">{{ $doc->urutan }}</td>
                                    <td>
                                        <strong>{{ $doc->nama_dokumen }}</strong>
                                        @if($doc->wajib)<span class="badge bg-danger ms-1">Wajib</span>@endif
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input doc-checkbox" type="checkbox"
                                                   name="documents[{{ $doc->id }}][is_ada]" value="1"
                                                   id="doc_{{ $doc->id }}"
                                                   {{ old("documents.{$doc->id}.is_ada", $status?->is_ada) ? 'checked' : '' }}
                                                   onchange="updateProgress()">
                                        </div>
                                    </td>
                                    <td>
                                        @if($status?->file_path)
                                            <div class="mb-1">
                                                <span class="badge bg-success">
                                                    <i class="bi bi-file-earmark-check"></i> File tersedia
                                                </span>
                                                <a href="{{ route('rptka.documents.preview', [$rptka->id, $doc->id]) }}"
                                                   target="_blank" class="btn btn-outline-info btn-sm ms-1">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control form-control-sm"
                                               name="documents[{{ $doc->id }}][file]"
                                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        @if($status?->file_path)
                                            <small class="text-muted">Upload baru untuk mengganti file lama</small>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                               name="documents[{{ $doc->id }}][keterangan]"
                                               value="{{ old("documents.{$doc->id}.keterangan", $status?->keterangan) }}"
                                               placeholder="Keterangan...">
                                    </td>
                                </tr>
                                @endforeach
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
                    <div class="progress mb-2" style="height:12px;">
                        <div class="progress-bar bg-success" id="progressBar" style="width:{{ $pct }}%"></div>
                    </div>
                    <small class="text-muted">
                        <span id="progressText">{{ $rptka->documentStatuses->where('is_ada', true)->count() }}</span>
                        dari <span id="progressTotal">{{ $rptka->documentStatuses->count() }}</span> dokumen dilengkapi
                    </small>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                </button>
                <a href="{{ route('rptka.show', $rptka->id) }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>

<script>
function updateProgress() {
    const checkboxes = document.querySelectorAll('.doc-checkbox');
    const checked = document.querySelectorAll('.doc-checkbox:checked').length;
    const total = checkboxes.length;
    const pct = total > 0 ? Math.round((checked / total) * 100) : 0;
    document.getElementById('progressBar').style.width = pct + '%';
    document.getElementById('progressText').textContent = checked;
    document.getElementById('progressTotal').textContent = total;
}
</script>
@endsection
