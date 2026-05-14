@extends('layouts.app')

@section('title', 'Pendaftaran RPTKA Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0"><i class="bi bi-plus-circle"></i> Permohonan Rekomendasi RPTKA</h1>
            <a href="{{ route('rptka.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('rptka.store') }}" enctype="multipart/form-data" id="rptkaForm">
    @csrf

    <div class="row">
        <!-- Informasi Umum -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-info-circle"></i> Informasi Permohonan</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if($errors->has('documents'))
                        <div class="alert alert-danger"><i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first('documents') }}</div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama LKS <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lks"
                                   class="form-control @error('nama_lks') is-invalid @enderror"
                                   value="{{ old('nama_lks') }}" placeholder="Nama sesuai akta" required>
                            @error('nama_lks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama TKA Pemohon <span class="text-danger">*</span></label>
                            <input type="text" name="nama_tka_pemohon"
                                   class="form-control @error('nama_tka_pemohon') is-invalid @enderror"
                                   value="{{ old('nama_tka_pemohon') }}" placeholder="Nama lengkap TKA" required>
                            @error('nama_tka_pemohon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat LKS <span class="text-danger">*</span></label>
                            <textarea name="alamat_lks" rows="3"
                                      class="form-control @error('alamat_lks') is-invalid @enderror"
                                      placeholder="Alamat lengkap LKS" required>{{ old('alamat_lks') }}</textarea>
                            @error('alamat_lks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Permohonan <span class="text-danger">*</span></label>
                            <select name="permohonan_rptka" id="permohonan_rptka"
                                    class="form-select @error('permohonan_rptka') is-invalid @enderror" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Baru" {{ old('permohonan_rptka') == 'Baru' ? 'selected' : '' }}>Baru</option>
                                <option value="Ulang" {{ old('permohonan_rptka') == 'Ulang' ? 'selected' : '' }}>Perpanjangan (Ulang)</option>
                            </select>
                            @error('permohonan_rptka')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk Dokumen <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_masuk_dokumen"
                                   class="form-control @error('tanggal_masuk_dokumen') is-invalid @enderror"
                                   value="{{ old('tanggal_masuk_dokumen', date('Y-m-d')) }}" required>
                            @error('tanggal_masuk_dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dokumen Persyaratan -->
            <div class="card" id="dokumenCard" style="display:none;">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-clipboard-check"></i> Dokumen Persyaratan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="35%">Nama Dokumen</th>
                                    <th width="10%">Ada</th>
                                    <th width="30%">Upload File</th>
                                    <th width="20%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="dokumenUtama"></tbody>
                            <tbody id="dokumenPerpanjangan" style="display:none;">
                                <tr class="table-warning">
                                    <td colspan="5" class="fw-bold text-center">
                                        <i class="bi bi-arrow-repeat"></i> Dokumen Tambahan Perpanjangan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Panduan Pengisian</h6></div>
                <div class="card-body">
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2"><i class="bi bi-1-circle text-primary"></i> Isi informasi permohonan terlebih dahulu</li>
                        <li class="mb-2"><i class="bi bi-2-circle text-primary"></i> Pilih jenis permohonan untuk menampilkan daftar dokumen</li>
                        <li class="mb-2"><i class="bi bi-3-circle text-primary"></i> Centang "Ada" jika dokumen tersedia</li>
                        <li class="mb-2"><i class="bi bi-4-circle text-primary"></i> Upload file dokumen (PDF/JPG/PNG/DOC, maks 5MB)</li>
                        <li><i class="bi bi-5-circle text-primary"></i> Klik Simpan untuk mendaftarkan permohonan</li>
                    </ul>
                </div>
            </div>

            <div class="card" id="progressCard" style="display:none;">
                <div class="card-header"><h6 class="mb-0">Kelengkapan Dokumen</h6></div>
                <div class="card-body">
                    <div class="progress mb-2" style="height:12px;">
                        <div class="progress-bar bg-success" id="progressBar" style="width:0%"></div>
                    </div>
                    <small class="text-muted"><span id="progressText">0</span> dari <span id="progressTotal">0</span> dokumen dilengkapi</small>
                </div>
            </div>

            <div class="mt-3 d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle"></i> Simpan Permohonan
                </button>
                <a href="{{ route('rptka.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>

@php
$dokumenUtama = \App\Models\MasterDocument::where('kategori', 'utama')->orderBy('urutan')->get();
$dokumenPerpanjangan = \App\Models\MasterDocument::where('kategori', 'perpanjangan')->orderBy('urutan')->get();
@endphp

<script>
const dokumenUtama = @json($dokumenUtama);
const dokumenPerpanjangan = @json($dokumenPerpanjangan);

function buildRow(doc, index) {
    return `
    <tr>
        <td class="text-center">${doc.urutan}</td>
        <td>
            <strong>${doc.nama_dokumen}</strong>
            ${doc.wajib ? '<span class="badge bg-danger ms-1">Wajib</span>' : ''}
            ${doc.deskripsi ? `<br><small class="text-muted">${doc.deskripsi}</small>` : ''}
        </td>
        <td class="text-center">
            <div class="form-check d-flex justify-content-center">
                <input class="form-check-input doc-checkbox" type="checkbox"
                       name="documents[${doc.id}][is_ada]" value="1"
                       id="doc_${doc.id}" onchange="updateProgress()">
            </div>
        </td>
        <td>
            <input type="file" class="form-control form-control-sm"
                   name="documents[${doc.id}][file]"
                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
        </td>
        <td>
            <input type="text" class="form-control form-control-sm"
                   name="documents[${doc.id}][keterangan]"
                   placeholder="Keterangan...">
        </td>
    </tr>`;
}

function updateProgress() {
    const checkboxes = document.querySelectorAll('.doc-checkbox');
    const checked = document.querySelectorAll('.doc-checkbox:checked').length;
    const total = checkboxes.length;
    const pct = total > 0 ? Math.round((checked / total) * 100) : 0;
    document.getElementById('progressBar').style.width = pct + '%';
    document.getElementById('progressText').textContent = checked;
    document.getElementById('progressTotal').textContent = total;
}

document.getElementById('permohonan_rptka').addEventListener('change', function () {
    const jenis = this.value;
    const dokumenCard = document.getElementById('dokumenCard');
    const progressCard = document.getElementById('progressCard');
    const tbodyUtama = document.getElementById('dokumenUtama');
    const tbodyPerp = document.getElementById('dokumenPerpanjangan');

    if (!jenis) {
        dokumenCard.style.display = 'none';
        progressCard.style.display = 'none';
        return;
    }

    // Render dokumen utama
    tbodyUtama.innerHTML = dokumenUtama.map((d, i) => buildRow(d, i)).join('');

    // Render dokumen perpanjangan jika Ulang
    if (jenis === 'Ulang') {
        const rows = dokumenPerpanjangan.map((d, i) => buildRow(d, i)).join('');
        // Tambahkan setelah header
        tbodyPerp.innerHTML = tbodyPerp.rows[0].outerHTML + rows;
        tbodyPerp.style.display = '';
    } else {
        tbodyPerp.style.display = 'none';
        tbodyPerp.innerHTML = `<tr class="table-warning">
            <td colspan="5" class="fw-bold text-center">
                <i class="bi bi-arrow-repeat"></i> Dokumen Tambahan Perpanjangan
            </td>
        </tr>`;
    }

    dokumenCard.style.display = '';
    progressCard.style.display = '';
    updateProgress();
});

// Trigger jika ada old value
const oldJenis = "{{ old('permohonan_rptka') }}";
if (oldJenis) {
    document.getElementById('permohonan_rptka').value = oldJenis;
    document.getElementById('permohonan_rptka').dispatchEvent(new Event('change'));
}

// Validasi form sebelum submit
document.getElementById('rptkaForm').addEventListener('submit', function(e) {
    const jenis = document.getElementById('permohonan_rptka').value;
    if (!jenis) {
        e.preventDefault();
        alert('Pilih jenis permohonan terlebih dahulu.');
        return false;
    }

    // Cek dokumen wajib: harus ada is_ada dicentang DAN file diupload
    const allRows = document.querySelectorAll('#dokumenUtama tr, #dokumenPerpanjangan tr');
    let missingWajib = [];

    allRows.forEach(function(row) {
        // Skip header rows
        if (row.classList.contains('table-warning')) return;
        const badge = row.querySelector('.badge.bg-danger');
        if (!badge) return; // bukan wajib

        const checkbox = row.querySelector('.doc-checkbox');
        const fileInput = row.querySelector('input[type="file"]');
        const docName = row.querySelector('td:nth-child(2) strong');
        const name = docName ? docName.textContent.trim() : 'Dokumen wajib';

        if (!checkbox || !checkbox.checked) {
            missingWajib.push(name + ' (belum dicentang "Ada")');
        } else if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            missingWajib.push(name + ' (belum diupload file)');
        }
    });

    if (missingWajib.length > 0) {
        e.preventDefault();
        alert('Dokumen wajib berikut belum dilengkapi:\n\n' + missingWajib.map((n, i) => (i+1) + '. ' + n).join('\n'));
        return false;
    }
});
</script>
@endsection
