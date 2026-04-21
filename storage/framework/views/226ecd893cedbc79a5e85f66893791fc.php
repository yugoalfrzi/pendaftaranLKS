
<?php $__env->startSection('title', 'Verval RPTKA - ' . $rptka->nama_lks); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-patch-check"></i> Verifikasi & Validasi RPTKA</h1>
    <a href="<?php echo e(route('superadmin.rptka.index')); ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Info -->
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Informasi Permohonan</h5></div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td width="35%"><strong>Nama LKS</strong></td><td><?php echo e($rptka->nama_lks); ?></td></tr>
                    <tr><td><strong>Nama TKA</strong></td><td><?php echo e($rptka->nama_tka_pemohon); ?></td></tr>
                    <tr><td><strong>Alamat</strong></td><td><?php echo e($rptka->alamat_lks); ?></td></tr>
                    <tr><td><strong>Jenis</strong></td><td><span class="badge <?php echo e($rptka->permohonan_rptka == 'Baru' ? 'bg-success' : 'bg-warning text-dark'); ?>"><?php echo e($rptka->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru'); ?></span></td></tr>
                    <tr><td><strong>Tgl Masuk</strong></td><td><?php echo e($rptka->tanggal_masuk_dokumen->format('d F Y')); ?></td></tr>
                    <tr><td><strong>Verifikator Admin</strong></td><td><?php echo e($rptka->nama_verifikator ?? '-'); ?></td></tr>
                </table>
            </div>
        </div>

        <!-- Surat Rekomendasi dari Admin -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white"><h5 class="mb-0"><i class="bi bi-file-earmark-check"></i> Surat Rekomendasi dari Admin</h5></div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-file-earmark-pdf text-danger fs-2"></i>
                    <div>
                        <p class="mb-1">Surat rekomendasi RPTKA yang diterbitkan oleh admin</p>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('admin.rptka.preview-surat', $rptka->id)); ?>" class="btn btn-outline-info" target="_blank"><i class="bi bi-eye"></i> Preview</a>
                            <a href="<?php echo e(route('admin.rptka.download-surat', $rptka->id)); ?>" class="btn btn-outline-success"><i class="bi bi-download"></i> Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen -->
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Dokumen Persyaratan</h5></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr><th>No</th><th>Nama Dokumen</th><th>Status</th><th>File</th></tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rptka->documentStatuses->sortBy('masterDocument.urutan'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($status->masterDocument->urutan); ?></td>
                                <td><?php echo e($status->masterDocument->nama_dokumen); ?></td>
                                <td class="text-center">
                                    <?php if($status->is_ada): ?><span class="badge bg-success">Ada</span>
                                    <?php else: ?><span class="badge bg-danger">Belum</span><?php endif; ?>
                                </td>
                                <td>
                                    <?php if($status->file_path): ?>
                                        <a href="<?php echo e(route('rptka.documents.preview', [$rptka->id, $status->master_document_id])); ?>" class="btn btn-outline-info btn-sm" target="_blank"><i class="bi bi-eye"></i></a>
                                    <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Verval -->
    <div class="col-md-4">
        <?php if($rptka->surat_rekomendasi_rptka_final_path): ?>
        <div class="card mb-4 border-success">
            <div class="card-header bg-success text-white"><h6 class="mb-0"><i class="bi bi-check-circle"></i> Surat Final Sudah Ada</h6></div>
            <div class="card-body">
                <div class="btn-group w-100">
                    <a href="<?php echo e(route('superadmin.rptka.preview-final', $rptka->id)); ?>" class="btn btn-outline-info" target="_blank"><i class="bi bi-eye"></i> Preview</a>
                    <a href="<?php echo e(route('superadmin.rptka.download-final', $rptka->id)); ?>" class="btn btn-outline-success"><i class="bi bi-download"></i> Download</a>
                </div>
                <small class="text-muted d-block mt-2">Verifikator: <?php echo e($rptka->nama_verifikator_superadmin); ?></small>
            </div>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-primary text-white"><h5 class="mb-0">Form Verval</h5></div>
            <div class="card-body">
                <form action="<?php echo e(route('superadmin.rptka.verification.process', $rptka->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">Upload Surat Rekomendasi RPTKA Final <span class="text-danger">*</span></label>
                        <input type="file" class="form-control <?php $__errorArgs = ['surat_rekomendasi_rptka_final'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               name="surat_rekomendasi_rptka_final" accept=".pdf" required>
                        <small class="text-muted">Format PDF, maks 5MB</small>
                        <?php $__errorArgs = ['surat_rekomendasi_rptka_final'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Verifikator <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['nama_verifikator_superadmin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               name="nama_verifikator_superadmin"
                               value="<?php echo e(old('nama_verifikator_superadmin', auth()->user()->name)); ?>" required>
                        <?php $__errorArgs = ['nama_verifikator_superadmin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="alert alert-warning p-2 small">
                        <i class="bi bi-info-circle"></i> Setelah verval, status akan berubah menjadi <strong>Terverifikasi</strong> dan surat final dapat didownload oleh pemohon.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-patch-check"></i> Proses Verval</button>
                        <a href="<?php echo e(route('superadmin.rptka.index')); ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/superadmin/rptka/verification.blade.php ENDPATH**/ ?>