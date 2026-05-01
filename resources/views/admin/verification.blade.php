@extends('layouts.app')

@section('title', 'Verifikasi Pendaftaran LKS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-person-check"></i> 
                @if($lks->kewenangan_type == 'kabkota')
                    Upload Sertifikat Kab/Kota LKS
                @else
                    Upload Surat Rekomendasi LKS
                @endif
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
                                <td><strong>Kewenangan</strong></td>
                                <td>
                                    @if($lks->kewenangan_type == 'kabkota')
                                        <span class="badge bg-primary"><i class="bi bi-building"></i> Kab/Kota</span>
                                        <small class="d-block text-muted mt-1">Proses berhenti di Admin</small>
                                    @elseif($lks->kewenangan_type == 'provinsi')
                                        <span class="badge bg-success"><i class="bi bi-map"></i> Provinsi</span>
                                        <small class="d-block text-muted mt-1">Diteruskan ke Super Admin</small>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
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
                    <i class="bi bi-clipboard-check"></i> 
                    @if($lks->kewenangan_type == 'kabkota')
                        Form Upload Sertifikat Kab/Kota
                    @else
                        Form Upload Surat Rekomendasi
                    @endif
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.verification.store', $lks->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="status_permohonan" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_permohonan') is-invalid @enderror" id="status_permohonan" name="status_permohonan" required>
                            <option value="">Pilih Status</option>
                            <option value="Diterima" {{ old('status_permohonan') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Ditolak" {{ old('status_permohonan') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Dikembalikan" {{ old('status_permohonan') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                        @error('status_permohonan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($lks->kewenangan_type == 'kabkota')
                    {{-- Kab/Kota: Upload Sertifikat Kab/Kota --}}
                    <div class="mb-3" id="sertifikat_kabkota_div" style="display: none;">
                        <label for="sertifikat_kabkota" class="form-label">Upload Sertifikat Kab/Kota (PDF/JPG/PNG)</label>
                        <input type="file" class="form-control @error('sertifikat_kabkota') is-invalid @enderror" id="sertifikat_kabkota" name="sertifikat_kabkota" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">
                            <small>Format file yang diizinkan: PDF, JPG, PNG. Maksimal ukuran: 5MB</small>
                        </div>
                        @error('sertifikat_kabkota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($lks->sertifikat_kabkota_path)
                        <div class="mt-2">
                            <div class="alert alert-info p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-check text-success"></i>
                                        <span class="ms-2">Sertifikat kab/kota sudah diupload</span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.verification.download-sertifikat-kabkota', $lks->id) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <a href="{{ route('admin.verification.preview-sertifikat-kabkota', $lks->id) }}" class="btn btn-outline-info" target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    {{-- Provinsi: Upload Surat Rekomendasi --}}
                    <div class="mb-3" id="surat_rekomendasi_div" style="display: none;">
                        <label for="surat_rekomendasi" class="form-label">Upload Surat Rekomendasi (PDF/JPG/PNG)</label>
                        <input type="file" class="form-control @error('surat_rekomendasi') is-invalid @enderror" id="surat_rekomendasi" name="surat_rekomendasi" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">
                            <small>Format file yang diizinkan: PDF, JPG, PNG. Maksimal ukuran: 5MB</small>
                        </div>
                        @error('surat_rekomendasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($lks->surat_rekomendasi_path)
                        <div class="mt-2">
                            <div class="alert alert-info p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-check text-success"></i>
                                        <span class="ms-2">Surat rekomendasi sudah diupload</span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.verification.download-sertifikat', $lks->id) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <a href="{{ route('admin.verification.preview-sertifikat', $lks->id) }}" class="btn btn-outline-info" target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

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
                        <label for="nama_verifikator" class="form-label">Nama Verifikator</label>
                        <input type="text" class="form-control bg-light" id="nama_verifikator" name="nama_verifikator" value="{{ auth()->user()->name }}" readonly>
                        <div class="form-text"><small>Otomatis diisi sesuai akun yang login</small></div>
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
    const alasanPenolakanDiv = document.getElementById('alasan_penolakan_div');
    const alasanDikembalikanDiv = document.getElementById('alasan_dikembalikan_div');
    const alasanPenolakan = document.getElementById('alasan_penolakan');
    const alasanDikembalikan = document.getElementById('alasan_dikembalikan');

    // Deteksi jenis kewenangan dari blade
    const isKabkota = {{ $lks->kewenangan_type == 'kabkota' ? 'true' : 'false' }};
    const uploadDiv = isKabkota
        ? document.getElementById('sertifikat_kabkota_div')
        : document.getElementById('surat_rekomendasi_div');
    const uploadInput = isKabkota
        ? document.getElementById('sertifikat_kabkota')
        : document.getElementById('surat_rekomendasi');

    function toggleFields() {
        const status = statusSelect.value;

        uploadDiv.style.display = 'none';
        alasanPenolakanDiv.style.display = 'none';
        alasanDikembalikanDiv.style.display = 'none';

        alasanPenolakan.required = false;
        alasanDikembalikan.required = false;

        if (status === 'Diterima') {
            uploadDiv.style.display = 'block';
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

    // Validasi file
    if (uploadInput) {
        uploadInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Hanya file PDF, JPG, atau PNG yang diizinkan!');
                    e.target.value = '';
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file maksimal 5MB!');
                    e.target.value = '';
                }
            }
        });
    }
});
</script>

<style>
.admin-files-list .admin-file-item:hover {
    background-color: #f8f9fa;
}
</style>
@endsection