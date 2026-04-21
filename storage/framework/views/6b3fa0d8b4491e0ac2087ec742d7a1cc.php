<?php $__env->startSection('title', 'Verifikasi Pendaftaran LKS'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-person-check"></i> Verifikasi Pendaftaran LKS
            </h1>
            <a href="<?php echo e(route('admin.lks.index')); ?>" class="btn btn-outline-secondary">
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
                                <td width="60%"><?php echo e($lks->nama_lks); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Alamat LKS</strong></td>
                                <td><?php echo e($lks->alamat_lks); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Ketua LKS</strong></td>
                                <td><?php echo e($lks->nama_ketua_lks ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Pelayanan</strong></td>
                                <td><?php echo e($lks->jenis_pelayanan ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Binaan Dalam Panti</strong></td>
                                <td><?php echo e($lks->jumlah_binaan_dalam_panti ?? '0'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Binaan Luar Panti</strong></td>
                                <td><?php echo e($lks->jumlah_binaan_luar_panti ?? '0'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Lokasi LKS</strong></td>
                                <td><?php echo e($lks->lokasi_lks ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Pusat LKS</strong></td>
                                <td><?php echo e($lks->pusat_lks ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Cabang LKS</strong></td>
                                <td><?php echo e($lks->cabang_lks ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Kontak</strong></td>
                                <td><?php echo e($lks->nomor_kontak ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanda Pendaftaran</strong></td>
                                <td>
                                    <span class="badge <?php echo e($lks->tanda_pendaftaran == 'Baru' ? 'bg-success' : 'bg-info'); ?>">
                                        <?php echo e($lks->tanda_pendaftaran); ?>

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Masuk</strong></td>
                                <td><?php echo e(\Carbon\Carbon::parse($lks->tanggal_masuk_dokumen)->format('d/m/Y')); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Status Saat Ini</strong></td>
                                <td width="60%">
                                    <span class="badge <?php echo e($lks->status_badge); ?>">
                                        <?php echo e($lks->status_permohonan); ?>

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Kelengkapan</strong></td>
                                <td>
                                    <span class="badge <?php echo e($lks->pendaftaran_lengkap ? 'bg-success' : 'bg-warning'); ?>">
                                        <?php echo e($lks->pendaftaran_lengkap ? 'Lengkap' : 'Tidak Lengkap'); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php if($lks->sertifikat_path): ?>
                            <tr>
                                <td><strong>Sertifikat</strong></td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="bi bi-file-earmark-pdf"></i> Tersedia
                                    </span>
                                    <div class="mt-1">
                                        <a href="<?php echo e(route('admin.verification.download-sertifikat', $lks->id)); ?>" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <a href="<?php echo e(route('admin.verification.preview-sertifikat', $lks->id)); ?>" 
                                           class="btn btn-sm btn-outline-info"
                                           target="_blank">
                                            <i class="bi bi-eye"></i> Preview
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checklist Dokumen -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-check2-square"></i> Checklist Kelengkapan Dokumen
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="35%">Nama Dokumen</th>
                                <th width="15%">Status</th>
                                <th width="25%">File Dokumen</th>
                                <th width="20%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $lks->checklists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $checklist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e($checklist->kelengkapan == 'Ada' ? 'table-success' : 'table-warning'); ?>">
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <strong><?php echo e($checklist->document->nama_dokumen); ?></strong>
                                        <?php if($checklist->document->wajib): ?>
                                            <span class="badge bg-danger ms-2">Wajib</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($checklist->kelengkapan == 'Ada'): ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Ada
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle"></i> Tidak Ada
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($checklist->file_path): ?>
                                            <a href="<?php echo e(asset('storage/' . $checklist->file_path)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada file</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($checklist->keterangan ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <form action="<?php echo e(route('admin.verification.store', $lks->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="status_permohonan" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                        <select class="form-select <?php $__errorArgs = ['status_permohonan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status_permohonan" name="status_permohonan" required>
                            <option value="">Pilih Status</option>
                            <option value="Diterima untuk proses" <?php echo e((old('status_permohonan') ?? $lks->status_permohonan) == 'Diterima untuk proses' ? 'selected' : ''); ?>>Diterima untuk proses</option>
                            <option value="Diterima" <?php echo e((old('status_permohonan') ?? $lks->status_permohonan) == 'Diterima' ? 'selected' : ''); ?>>Diterima</option>
                            <option value="Ditolak" <?php echo e((old('status_permohonan') ?? $lks->status_permohonan) == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                            <option value="Dikembalikan" <?php echo e((old('status_permohonan') ?? $lks->status_permohonan) == 'Dikembalikan' ? 'selected' : ''); ?>>Dikembalikan</option>
                        </select>
                        <?php $__errorArgs = ['status_permohonan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Field Upload Sertifikat - Muncul hanya ketika status "Diterima untuk proses" dipilih -->
                    <div class="mb-3" id="sertifikat_upload_div" style="display: <?php echo e((old('status_permohonan') ?? $lks->status_permohonan) == 'Diterima untuk proses' ? 'block' : 'none'); ?>;">
                        <label for="sertifikat" class="form-label">
                            Upload Sertifikat (PDF) 
                            <?php if(!$lks->sertifikat_path): ?>
                                <span class="text-danger">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="file" class="form-control <?php $__errorArgs = ['sertifikat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="sertifikat" name="sertifikat" accept=".pdf">
                        <div class="form-text">
                            <small>Format file yang diizinkan: PDF. Maksimal ukuran: 5MB</small>
                        </div>
                        <?php $__errorArgs = ['sertifikat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        
                        <!-- Tampilkan sertifikat yang sudah ada jika ada -->
                        <?php if($lks->sertifikat_path): ?>
                        <div class="mt-2">
                            <div class="alert alert-info p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                                        <span class="ms-2">Sertifikat sudah diupload</span>
                                    </div>
                                    <a href="<?php echo e(route('admin.verification.download-sertifikat', $lks->id)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3" id="alasan_penolakan_div" style="display: <?php echo e((old('status_permohonan') ?? $lks->status_permohonan) == 'Ditolak' ? 'block' : 'none'); ?>;">
                        <label for="alasan_penolakan" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control <?php $__errorArgs = ['alasan_penolakan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="alasan_penolakan" name="alasan_penolakan" rows="3"><?php echo e(old('alasan_penolakan') ?? $lks->alasan_penolakan); ?></textarea>
                        <?php $__errorArgs = ['alasan_penolakan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3" id="alasan_dikembalikan_div" style="display: <?php echo e((old('status_permohonan') ?? $lks->status_permohonan) == 'Dikembalikan' ? 'block' : 'none'); ?>;">
                        <label for="alasan_dikembalikan" class="form-label">Alasan Dikembalikan <span class="text-danger">*</span></label>
                        <textarea class="form-control <?php $__errorArgs = ['alasan_dikembalikan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="alasan_dikembalikan" name="alasan_dikembalikan" rows="3"><?php echo e(old('alasan_dikembalikan') ?? $lks->alasan_dikembalikan); ?></textarea>
                        <?php $__errorArgs = ['alasan_dikembalikan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="verifikator" class="form-label">ID Verifikator <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['verifikator'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="verifikator" name="verifikator" value="<?php echo e(old('verifikator') ?? $lks->verifikator_id); ?>" placeholder="Masukkan ID verifikator" required>
                        <?php $__errorArgs = ['verifikator'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="nama_verifikator" class="form-label">Nama Verifikator <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['nama_verifikator'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nama_verifikator" name="nama_verifikator" value="<?php echo e(old('nama_verifikator') ?? $lks->nama_verifikator); ?>" placeholder="Masukkan nama verifikator" required>
                        <?php $__errorArgs = ['nama_verifikator'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="tandatangan" class="form-label">Tandatangan</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['tandatangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tandatangan" name="tandatangan" value="<?php echo e(old('tandatangan') ?? $lks->tandatangan); ?>" placeholder="Masukkan tandatangan (opsional)">
                        <?php $__errorArgs = ['tandatangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                        <a href="<?php echo e(route('admin.lks.index')); ?>" class="btn btn-outline-secondary">
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
            if (!<?php echo e($lks->sertifikat_path ? 'true' : 'false'); ?>) {
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
.alert {
    border-left: 4px solid;
}
.alert-info {
    border-left-color: #0dcaf0;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/admin/edit.blade.php ENDPATH**/ ?>