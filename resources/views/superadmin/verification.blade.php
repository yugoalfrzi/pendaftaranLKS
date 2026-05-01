@extends('layouts.app')

@section('title', 'Verifikasi Pendaftaran LKS - Super Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-shield-check"></i> Upload Sertifikat LKS
            </h1>
            <a href="{{ route('superadmin.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Super Admin Panel
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informasi Pendaftaran -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
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
                                <td><strong>Nomor Kontak</strong></td>
                                <td>{{ $lks->nomor_kontak ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kabupaten/Kota</strong></td>
                                <td>{{ $lks->kabupaten_kota ?? '-' }}</td>
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
                                    @elseif($lks->kewenangan_type == 'provinsi')
                                        <span class="badge bg-success"><i class="bi bi-map"></i> Provinsi</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Tanggal Masuk</strong></td>
                                <td width="60%">{{ \Carbon\Carbon::parse($lks->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status Saat Ini</strong></td>
                                <td>
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
                            <tr>
                                <td><strong>Verifikator Admin</strong></td>
                                <td>{{ $lks->nama_verifikator ?? '-' }}</td>
                            </tr>
                            @if($lks->user)
                            <tr>
                                <td><strong>Email Pendaftar</strong></td>
                                <td>{{ $lks->user->email }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($lks->alasan_penolakan)
                <div class="alert alert-danger mt-3">
                    <strong><i class="bi bi-exclamation-triangle"></i> Alasan Penolakan:</strong><br>
                    {{ $lks->alasan_penolakan }}
                </div>
                @endif

                @if($lks->alasan_dikembalikan)
                <div class="alert alert-warning mt-3">
                    <strong><i class="bi bi-arrow-return-left"></i> Alasan Dikembalikan:</strong><br>
                    {{ $lks->alasan_dikembalikan }}
                </div>
                @endif
            </div>
        </div>

        <!-- Checklist Dokumen -->
        @if($lks->checklists && $lks->checklists->count() > 0)
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-clipboard-check"></i> Kelengkapan Dokumen
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Nama Dokumen</th>
                                <th width="15%">Status</th>
                                <th width="40%">File Dokumen</th>
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
                                            <div class="d-flex justify-content-between align-items-center p-2 mb-2 border rounded">
                                                <div class="d-flex align-items-center">
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
                                                <a href="{{ route('lks.files.show', ['lks' => $lks->id, 'document' => $checklist->id, 'file' => $file['index']]) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-danger">
                                            <i class="bi bi-exclamation-triangle"></i> Tidak ada file
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $checklist->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Form Verifikasi -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clipboard-check"></i> Form Upload Sertifikat
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('superadmin.verification.process', $lks->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="status_permohonan" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_permohonan') is-invalid @enderror"
                                id="status_permohonan"
                                name="status_permohonan"
                                required>
                            <option value="">Pilih Status</option>
                            <option value="Diterima untuk proses" {{ old('status_permohonan', $lks->status_permohonan) == 'Diterima untuk proses' ? 'selected' : '' }}>Diterima untuk proses</option>
                            <option value="Ditolak" {{ old('status_permohonan', $lks->status_permohonan) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Dikembalikan" {{ old('status_permohonan', $lks->status_permohonan) == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                        @error('status_permohonan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Field Upload Sertifikat - Muncul ketika status "Diterima untuk proses" -->
                    <div class="mb-3" id="sertifikat_div" style="display: none;">
                        <label for="sertifikat" class="form-label">
                            Upload Sertifikat (PDF) <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               class="form-control @error('sertifikat') is-invalid @enderror"
                               id="sertifikat"
                               name="sertifikat"
                               accept=".pdf">
                        <div class="form-text">
                            <small>Format: PDF. Maksimal: 5MB</small>
                        </div>
                        @error('sertifikat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Tampilkan surat rekomendasi dari admin -->
                        @if($lks->surat_rekomendasi_path)
                        <div class="mt-2 mb-3">
                            <div class="alert alert-success p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-check text-success"></i>
                                        <span class="ms-2"><strong>Surat Rekomendasi (dari Admin)</strong></span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('superadmin.download-rekomendasi', $lks->id) }}"
                                           class="btn btn-outline-success">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <a href="{{ route('superadmin.preview-rekomendasi', $lks->id) }}"
                                           class="btn btn-outline-info"
                                           target="_blank">
                                            <i class="bi bi-eye"></i> Preview
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Tampilkan sertifikat yang sudah ada -->
                        @if($lks->sertifikat_path)
                        <div class="mt-2">
                            <div class="alert alert-info p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                                        <span class="ms-2"><strong>Sertifikat sudah diupload</strong></span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('superadmin.download-surat', $lks->id) }}"
                                           class="btn btn-outline-primary">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <a href="{{ route('superadmin.preview-surat', $lks->id) }}"
                                           class="btn btn-outline-info"
                                           target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="verifikator" class="form-label">ID Verifikator</label>
                        <input type="text" class="form-control bg-light" id="verifikator" name="verifikator" value="{{ auth()->user()->id }}" readonly>
                    </div>

                    <di class="mb-3">
                        <label for="nama_verifikator" class="form-label">Nama Verifikator</label>
                        <input type="text" class="form-control bg-light" id="nama_verifikator" name="nama_verifikator" value="{{ auth()->user()->name }}" readonly>
                        <div class="form-text"><small>Otomatis diisi sesuai akun yang login</small></div>
                    </div>

                    <!-- Alasan Penolakan -->
                    <div class="mb-3" id="alasan_penolakan_div" style="display: none;">
                        <label for="alasan_penolakan" class="form-label">
                            Alasan Penolakan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('alasan_penolakan') is-invalid @enderror"
                                  id="alasan_penolakan"
                                  name="alasan_penolakan"
                                  rows="3"
                                  placeholder="Masukkan alasan penolakan...">{{ old('alasan_penolakan', $lks->alasan_penolakan) }}</textarea>
                        @error('alasan_penolakan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alasan Dikembalikan -->
                    <div class="mb-3" id="alasan_dikembalikan_div" style="display: none;">
                        <label for="alasan_dikembalikan" class="form-label">
                            Alasan Dikembalikan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('alasan_dikembalikan') is-invalid @enderror"
                                  id="alasan_dikembalikan"
                                  name="alasan_dikembalikan"
                                  rows="3"
                                  placeholder="Masukkan alasan dikembalikan...">{{ old('alasan_dikembalikan', $lks->alasan_dikembalikan) }}</textarea>
                        @error('alasan_dikembalikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan Verifikasi
                        </button>
                        <a href="{{ route('superadmin.index') }}" class="btn btn-outline-secondary">
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
    const sertifikatDiv = document.getElementById('sertifikat_div');
    const alasanPenolakanDiv = document.getElementById('alasan_penolakan_div');
    const alasanDikembalikanDiv = document.getElementById('alasan_dikembalikan_div');
    const alasanPenolakan = document.getElementById('alasan_penolakan');
    const alasanDikembalikan = document.getElementById('alasan_dikembalikan');
    const sertifikatInput = document.getElementById('sertifikat');

    function toggleFields() {
        const status = statusSelect.value;

        // Hide all fields first
        sertifikatDiv.style.display = 'none';
        alasanPenolakanDiv.style.display = 'none';
        alasanDikembalikanDiv.style.display = 'none';

        // Reset required attributes
        alasanPenolakan.required = false;
        alasanDikembalikan.required = false;
        sertifikatInput.required = false;

        // Show relevant fields based on status
        if (status === 'Diterima untuk proses') {
            sertifikatDiv.style.display = 'block';
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
@endsection
