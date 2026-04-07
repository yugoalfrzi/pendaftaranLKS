@extends('layouts.app')

@section('title', 'Verifikasi Pendaftaran LKS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-person-check"></i> Verifikasi Pendaftaran LKS
            </h1>
            <a href="{{ route('admin.lks.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Admin Panel
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informasi Pendaftaran -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Informasi Pendaftaran
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama LKS</strong></td>
                                <td width="60%">{{ $lks->nama_lks }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat LKS</strong></td>
                                <td>{{ $lks->alamat_lks }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Ketua LKS</strong></td>
                                <td>{{ $lks->nama_ketua_lks ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Pelayanan</strong></td>
                                <td>{{ $lks->jenis_pelayanan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Binaan Dalam Panti</strong></td>
                                <td>{{ $lks->jumlah_binaan_dalam_panti ?? '0' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Binaan Luar Panti</strong></td>
                                <td>{{ $lks->jumlah_binaan_luar_panti ?? '0' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Lokasi LKS</strong></td>
                                <td>{{ $lks->lokasi_lks ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pusat LKS</strong></td>
                                <td>{{ $lks->pusat_lks ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Cabang LKS</strong></td>
                                <td>{{ $lks->cabang_lks ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Kontak</strong></td>
                                <td>{{ $lks->nomor_kontak ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanda Pendaftaran</strong></td>
                                <td>
                                    <span class="badge {{ $lks->tanda_pendaftaran == 'Baru' ? 'bg-success' : 'bg-info' }}">
                                        {{ $lks->tanda_pendaftaran }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Masuk</strong></td>
                                <td>{{ \Carbon\Carbon::parse($lks->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Status Saat Ini</strong></td>
                                <td width="60%">
                                    <span class="badge {{ $lks->status_badge }}">
                                        {{ $lks->status_permohonan }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Kelengkapan</strong></td>
                                <td>
                                    <span class="badge {{ $lks->pendaftaran_lengkap ? 'bg-success' : 'bg-warning' }}">
                                        {{ $lks->pendaftaran_lengkap ? 'Lengkap' : 'Tidak Lengkap' }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checklist Dokumen -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-clipboard-check"></i> Verifikasi Kelengkapan Dokumen
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Nama Dokumen</th>
                                <th width="15%">Status</th>
                                <th width="45%">File Dokumen</th>
                                <th width="10%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lks->checklists as $index => $checklist)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $checklist->document->nama_dokumen }}</strong>
                                    @if($checklist->document->wajib)
                                        <span class="badge bg-danger ms-2">Wajib</span>
                                    @endif
                                </td>
                                <td>
                                    @if($checklist->kelengkapan == 'Ada')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Lengkap
                                            @if($checklist->file_count > 1)
                                                <br><small>({{ $checklist->file_count }} files)</small>
                                            @endif
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Tidak Lengkap
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($checklist->has_files)
                                        <div class="admin-files-list">
                                            @foreach($checklist->getFilesInfo() as $fileIndex => $file)
                                            <div class="admin-file-item d-flex justify-content-between align-items-center p-2 mb-2 border rounded">
                                                <div class="file-info d-flex align-items-center">
                                                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                    <div>
                                                           @php $fileUrl = $file['url'] ?? null; @endphp
                                                        @if($fileUrl)
                                                            <a href="{{ $fileUrl }}" target="_blank" class="text-decoration-none fw-bold">
                                                                {{ $file['name'] }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('lks.files.show', ['lks' => $lks->id, 'document' => $checklist->id, 'file' => $file['index']]) }}" target="_blank" class="text-decoration-none fw-bold">
                                                                {{ $file['name'] }}
                                                            </a>
                                                        @endif
                                                        <br>
                                                        <small class="text-muted">File {{ $fileIndex + 1 }} of {{ $checklist->file_count }}</small>
                                                    </div>
                                                </div>
                                                <div class="file-actions">
                                                    <a href="{{ route('lks.files.show', ['lks' => $lks->id, 'document' => $checklist->id, 'file' => $file['index']]) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Lihat
                                                    </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-danger">
                                            <i class="bi bi-exclamation-triangle"></i> Tidak ada file
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($checklist->keterangan))
                                        <span>{{ $checklist->keterangan }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
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
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clipboard-check"></i> Form Verifikasi
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.verification.store', $lks->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="status_permohonan" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_permohonan') is-invalid @enderror" id="status_permohonan" name="status_permohonan" required>
                            <option value="">Pilih Status</option>
                            <option value="Diterima untuk proses" {{ old('status_permohonan') == 'Diterima untuk proses' ? 'selected' : '' }}>Diterima untuk proses</option>
                            <option value="Ditolak" {{ old('status_permohonan') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Dikembalikan" {{ old('status_permohonan') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                        @error('status_permohonan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Field Upload Sertifikat - Muncul hanya ketika status "Diterima untuk proses" dipilih -->
                    <div class="mb-3" id="sertifikat_upload_div" style="display: none;">
                        <label for="sertifikat" class="form-label">Upload Sertifikat (PDF) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('sertifikat') is-invalid @enderror" id="sertifikat" name="sertifikat" accept=".pdf">
                        <div class="form-text">
                            <small>Format file yang diizinkan: PDF. Maksimal ukuran: 5MB</small>
                        </div>
                        @error('sertifikat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Tampilkan sertifikat yang sudah ada jika ada -->
                        @if($lks->sertifikat_path)
                        <div class="mt-2">
                            <div class="alert alert-info p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                                        <span class="ms-2">Sertifikat sudah diupload</span>
                                    </div>
                                    <a href="{{ route('admin.verification.download-sertifikat', $lks->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mb-3" id="alasan_penolakan_div" style="display: none;">
                        <label for="alasan_penolakan" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alasan_penolakan') is-invalid @enderror" id="alasan_penolakan" name="alasan_penolakan" rows="3" placeholder="Masukkan alasan penolakan...">{{ old('alasan_penolakan') }}</textarea>
                        @error('alasan_penolakan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="alasan_dikembalikan_div" style="display: none;">
                        <label for="alasan_dikembalikan" class="form-label">Alasan Dikembalikan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alasan_dikembalikan') is-invalid @enderror" id="alasan_dikembalikan" name="alasan_dikembalikan" rows="3" placeholder="Masukkan alasan dikembalikan...">{{ old('alasan_dikembalikan') }}</textarea>
                        @error('alasan_dikembalikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="verifikator" class="form-label">ID Verifikator <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('verifikator') is-invalid @enderror" id="verifikator" name="verifikator" value="{{ old('verifikator', $lks->verifikator_id) }}" placeholder="Masukkan ID verifikator" required>
                        @error('verifikator')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_verifikator" class="form-label">Nama Verifikator <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_verifikator') is-invalid @enderror" id="nama_verifikator" name="nama_verifikator" value="{{ old('nama_verifikator', $lks->nama_verifikator) }}" placeholder="Masukkan nama verifikator" required>
                        @error('nama_verifikator')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan Verifikasi
                        </button>
                        <a href="{{ route('admin.lks.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Batal
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
    const sertifikatUploadDiv = document.getElementById('sertifikat_upload_div');
    const alasanPenolakanDiv = document.getElementById('alasan_penolakan_div');
    const alasanDikembalikanDiv = document.getElementById('alasan_dikembalikan_div');
    const alasanPenolakan = document.getElementById('alasan_penolakan');
    const alasanDikembalikan = document.getElementById('alasan_dikembalikan');
    const sertifikatInput = document.getElementById('sertifikat');
    
    function toggleFields() {
        const status = statusSelect.value;
        
        // Hide all fields first
        sertifikatUploadDiv.style.display = 'none';
        alasanPenolakanDiv.style.display = 'none';
        alasanDikembalikanDiv.style.display = 'none';
        
        // Reset required attributes
        alasanPenolakan.required = false;
        alasanDikembalikan.required = false;
        sertifikatInput.required = false;
        
        // Show relevant fields based on status
        if (status === 'Diterima untuk proses') {
            sertifikatUploadDiv.style.display = 'block';
            // Hanya wajib jika belum ada sertifikat
            if (!{{ $lks->sertifikat_path ? 'true' : 'false' }}) {
                sertifikatInput.required = true;
            }
        } else if (status === 'Ditolak') {
            alasanPenolakanDiv.style.display = 'block';
            alasanPenolakan.required = true;
        } else if (status === 'Dikembalikan') {
            alasanDikembalikanDiv.style.display = 'block';
            alasanDikembalikan.required = true;
        }
    }
    
    // Initial toggle
    toggleFields();
    
    // Add event listener for status change
    statusSelect.addEventListener('change', toggleFields);
    
    // Validasi file PDF
    sertifikatInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileType = file.type;
            const fileSize = file.size;
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (fileType !== 'application/pdf') {
                alert('Hanya file PDF yang diizinkan!');
                e.target.value = '';
                return;
            }
            
            if (fileSize > maxSize) {
                alert('Ukuran file maksimal 5MB!');
                e.target.value = '';
                return;
            }
        }
    });
});
</script>

<style>
.admin-files-list .admin-file-item:hover {
    background-color: #f8f9fa;
}
</style>
@endsection