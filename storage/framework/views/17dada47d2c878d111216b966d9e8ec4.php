<?php $__env->startSection('title', 'Detail LKS'); ?>

<?php $__env->startSection('page-title', 'Detail LKS'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-eye"></i> Detail LKS
            </h1>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('lks.edit', $lks->id)); ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <?php if(auth()->user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('admin.verification', $lks->id)); ?>" class="btn btn-primary">
                        <i class="bi bi-clipboard-check"></i> Verifikasi
                    </a>
                <?php endif; ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informasi Umum -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Informasi Umum
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless align-middle">
                    <tr>
                        <td width="40%"><strong>Nama LKS</strong></td>
                        <td width="60%"><?php echo e($lks->nama_lks ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Alamat LKS</strong></td>
                        <td><?php echo e($lks->alamat_lks ?? '-'); ?></td>
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
                            <?php if($lks->tanda_pendaftaran): ?>
                                <span class="badge <?php echo e($lks->tanda_pendaftaran === 'Baru' ? 'bg-success' : 'bg-info'); ?> status-badge">
                                    <?php echo e($lks->tanda_pendaftaran); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Masuk Dokumen</strong></td>
                        <td>
                            <?php if($lks->tanggal_masuk_dokumen): ?>
                                <?php echo e(optional($lks->tanggal_masuk_dokumen)->format('d/m/Y')); ?>

                            <?php else: ?>
                                <span class="text-muted">Belum diisi</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Persyaratan</strong></td>
                        <td>
                            <?php if($lks->tanggal_persyaratan): ?>
                                <?php echo e(optional($lks->tanggal_persyaratan)->format('d/m/Y')); ?>

                            <?php else: ?>
                                <span class="text-muted">Belum diisi</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status Permohonan</strong></td>
                        <td>
                            <span class="badge <?php echo e($lks->status_badge); ?> status-badge">
                                <?php echo e($lks->status_permohonan); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Kelengkapan</strong></td>
                        <td>
                            <?php if($lks->pendaftaran_lengkap): ?>
                                <span class="badge bg-success status-badge">
                                    <i class="bi bi-check-circle"></i> Lengkap
                                </span>
                            <?php else: ?>
                                <span class="badge bg-warning status-badge">
                                    <i class="bi bi-exclamation-triangle"></i> Belum Lengkap
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Info Verifikasi dan Sertifikat -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clipboard-check"></i> Informasi Verifikasi & Sertifikat
                </h5>
            </div>
            <div class="card-body">
                <!-- Informasi Verifikasi -->
                <div class="mb-4">
                    <h6 class="border-bottom pb-2">
                        <i class="bi bi-person-check"></i> Data Verifikasi
                    </h6>
                    <table class="table table-borderless align-middle">
                        <tr>
                            <td width="40%"><strong>Nama Verifikator</strong></td>
                            <td width="60%"><?php echo e($lks->nama_verifikator ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>ID Verifikator</strong></td>
                            <td><?php echo e($lks->verifikator_id ?? '-'); ?></td>
                        </tr>
                        <?php if($lks->status_permohonan == 'Ditolak'): ?>
                        <tr>
                            <td><strong>Alasan Penolakan</strong></td>
                            <td><?php echo e($lks->alasan_penolakan ?? '-'); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($lks->status_permohonan == 'Dikembalikan'): ?>
                        <tr>
                            <td><strong>Alasan Dikembalikan</strong></td>
                            <td><?php echo e($lks->alasan_dikembalikan ?? '-'); ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>

                <!-- Informasi Sertifikat -->
                <div>
                    <h6 class="border-bottom pb-2">
                        <i class="bi bi-file-earmark-pdf"></i> Sertifikat
                    </h6>
                    <?php if($lks->sertifikat_path): ?>
                        <div class="alert alert-success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-4"></i>
                                    <span class="ms-2 fw-bold">Sertifikat Tersedia</span>
                                </div>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('admin.verification.download-sertifikat', $lks->id)); ?>" 
                                       class="btn btn-success btn-sm" 
                                       title="Download Sertifikat">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                    <a href="<?php echo e(route('admin.verification.preview-sertifikat', $lks->id)); ?>" 
                                       class="btn btn-info btn-sm" 
                                       target="_blank"
                                       title="Preview Sertifikat">
                                        <i class="bi bi-eye"></i> Preview
                                    </a>
                                    <?php if(auth()->user()->role === 'admin'): ?>
                                        <form action="<?php echo e(route('admin.verification.delete-sertifikat', $lks->id)); ?>" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Sertifikat">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mt-2 small text-muted">
                                <i class="bi bi-info-circle"></i> Sertifikat telah diterbitkan untuk LKS ini
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-secondary">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-x text-muted fs-4 me-3"></i>
                                <div>
                                    <strong class="d-block">Belum Ada Sertifikat</strong>
                                    <small class="text-muted">
                                        <?php if($lks->status_permohonan === 'Diterima untuk proses'): ?>
                                            Sertifikat akan tersedia setelah proses verifikasi selesai
                                        <?php else: ?>
                                            Sertifikat akan tersedia ketika status "Diterima untuk proses"
                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>
                            <?php if(auth()->user()->role === 'admin' && $lks->status_permohonan === 'Diterima untuk proses'): ?>
                                <div class="mt-3">
                                    <a href="<?php echo e(route('admin.verification', $lks->id)); ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-upload"></i> Upload Sertifikat
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <small class="text-muted mt-3 d-block">
                    <i class="bi bi-clock-history"></i> Data terakhir diperbarui: 
                    <?php echo e($lks->updated_at->format('d/m/Y H:i')); ?>

                </small>
            </div>
        </div>
    </div>
</div>

<!-- Checklist Dokumen -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-check-circle"></i> Checklist Kelengkapan Dokumen
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
                                <th width="40%">File Dokumen</th>
                                <th width="15%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $lks->checklists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $checklist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
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
                                            <?php if($checklist->file_count > 1): ?>
                                                <br><small>(<?php echo e($checklist->file_count); ?> files)</small>
                                            <?php endif; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Tidak Ada
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($checklist->has_files): ?>
                                        <div class="multiple-files-list">
                                            <?php $__currentLoopData = $checklist->getFilesInfo(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fileIndex => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="file-item d-flex justify-content-between align-items-center p-2 mb-2 border rounded bg-light">
                                                <div class="file-info d-flex align-items-center">
                                                    <i class="bi bi-file-earmark-text me-2"></i>
                                                    <a href="<?php echo e(route('lks.files.show', [$lks->id, $checklist->id, $file['index']])); ?>" target="_blank" class="text-decoration-none">
                                                        <?php echo e($file['name']); ?>

                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-secondary">#<?php echo e($fileIndex + 1); ?></span>
                                                    <form action="<?php echo e(route('lks.files.destroy', [$lks->id, $checklist->id, $file['index']])); ?>" method="POST" onsubmit="return confirm('Hapus file ini?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">
                                            <i class="bi bi-file-earmark-x"></i> Tidak ada file
                                        </span>
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
</div>

<style>
.status-badge {
    font-size: 0.8rem;
    padding: 0.35rem 0.65rem;
}
.btn-group .btn {
    margin-right: 2px;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
.alert {
    border-left: 4px solid;
}
.alert-success {
    border-left-color: #198754;
}
.alert-secondary {
    border-left-color: #6c757d;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/lks/show.blade.php ENDPATH**/ ?>