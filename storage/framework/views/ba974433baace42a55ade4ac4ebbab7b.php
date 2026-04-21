

<?php $__env->startSection('title', 'Detail RPTKA - ' . $rptka->nama_lks); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0"><i class="bi bi-file-earmark-text"></i> Detail Permohonan RPTKA</h1>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('rptka.edit', $rptka->id)); ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="<?php echo e(route('rptka.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

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
                        <td><?php echo e($rptka->nama_lks); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama TKA Pemohon</strong></td>
                        <td><?php echo e($rptka->nama_tka_pemohon); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Alamat LKS</strong></td>
                        <td><?php echo e($rptka->alamat_lks); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Permohonan</strong></td>
                        <td>
                            <span class="badge <?php echo e($rptka->permohonan_rptka == 'Baru' ? 'bg-success' : 'bg-warning text-dark'); ?>">
                                <?php echo e($rptka->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru'); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status Permohonan</strong></td>
                        <td><span class="badge <?php echo e($rptka->status_badge); ?>"><?php echo e($rptka->status_permohonan); ?></span></td>
                    </tr>
                    <?php if($rptka->alasan_penolakan): ?>
                    <tr><td><strong>Alasan Penolakan</strong></td><td class="text-danger"><?php echo e($rptka->alasan_penolakan); ?></td></tr>
                    <?php endif; ?>
                    <?php if($rptka->alasan_dikembalikan): ?>
                    <tr><td><strong>Alasan Dikembalikan</strong></td><td class="text-info"><?php echo e($rptka->alasan_dikembalikan); ?></td></tr>
                    <?php endif; ?>
                    <tr>
                        <td><strong>Tanggal Lengkap</strong></td>
                        <td>
                            <?php if($rptka->tanggal_persyaratan_lengkap): ?>
                                <span class="text-success">
                                    <i class="bi bi-check-circle"></i>
                                    <?php echo e($rptka->tanggal_persyaratan_lengkap->format('d F Y')); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-muted">Belum lengkap</span>
                            <?php endif; ?>
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
                            <?php $__empty_1 = true; $__currentLoopData = $rptka->documentStatuses->sortBy('masterDocument.urutan'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center"><?php echo e($status->masterDocument->urutan); ?></td>
                                <td>
                                    <strong><?php echo e($status->masterDocument->nama_dokumen); ?></strong>
                                    <?php if($status->masterDocument->wajib): ?>
                                        <span class="badge bg-danger ms-1">Wajib</span>
                                    <?php endif; ?>
                                    <?php if($status->masterDocument->kategori == 'perpanjangan'): ?>
                                        <span class="badge bg-warning text-dark ms-1">Perpanjangan</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($status->is_ada): ?>
                                        <span class="badge bg-success"><i class="bi bi-check"></i> Ada</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bi bi-x"></i> Belum</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($status->file_path): ?>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo e(route('rptka.documents.preview', [$rptka->id, $status->master_document_id])); ?>"
                                               class="btn btn-outline-info" target="_blank" title="Preview">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('rptka.documents.download', [$rptka->id, $status->master_document_id])); ?>"
                                               class="btn btn-outline-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><small><?php echo e($status->keterangan ?? '-'); ?></small></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada dokumen</td>
                            </tr>
                            <?php endif; ?>
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
                <?php $pct = $rptka->completionPercentage() ?>
                <div class="progress mb-2" style="height:14px;">
                    <div class="progress-bar <?php echo e($pct == 100 ? 'bg-success' : 'bg-primary'); ?>"
                         style="width:<?php echo e($pct); ?>%"><?php echo e($pct); ?>%</div>
                </div>
                <?php
                    $total = $rptka->documentStatuses->count();
                    $ada   = $rptka->documentStatuses->where('is_ada', true)->count();
                ?>
                <small class="text-muted"><?php echo e($ada); ?> dari <?php echo e($total); ?> dokumen dilengkapi</small>

                <?php if($rptka->tanggal_persyaratan_lengkap): ?>
                    <div class="alert alert-success mt-3 mb-0 p-2">
                        <i class="bi bi-check-circle"></i> Semua dokumen lengkap
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="d-grid gap-2">
            <?php if($rptka->surat_rekomendasi_rptka_final_path): ?>
            <div class="card border-success mb-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-patch-check"></i> Surat Rekomendasi RPTKA</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-2">Surat rekomendasi RPTKA final telah diterbitkan. Silakan download.</p>
                    <a href="<?php echo e(route('rptka.download-surat-final', $rptka->id)); ?>" class="btn btn-success w-100">
                        <i class="bi bi-download"></i> Download Surat Rekomendasi
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if(in_array($rptka->status_permohonan, ['Menunggu', 'Dikembalikan'])): ?>
            <a href="<?php echo e(route('rptka.edit', $rptka->id)); ?>" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Permohonan
            </a>
            <?php endif; ?>
            <form action="<?php echo e(route('rptka.destroy', $rptka->id)); ?>" method="POST"
                  onsubmit="return confirm('Hapus permohonan RPTKA ini?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn btn-outline-danger w-100">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/RPTKA/show.blade.php ENDPATH**/ ?>