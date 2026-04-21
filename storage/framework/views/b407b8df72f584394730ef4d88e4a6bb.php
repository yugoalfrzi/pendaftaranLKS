

<?php $__env->startSection('title', 'Daftar Dokumen'); ?>
<?php $__env->startSection('page-title', 'Daftar Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-file-earmark-text"></i> Daftar Dokumen
            </h1>
            <a href="<?php echo e(route('documents.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Dokumen
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-table"></i> Daftar Jenis Dokumen yang Diperlukan
        </h5>
    </div>
    <div class="card-body">
        <?php if($documents->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($index + 1 + ($documents->currentPage() - 1) * $documents->perPage()); ?></td>
                            <td>
                                <strong><?php echo e($document->nama_dokumen); ?></strong>
                            </td>
                            <td>
                                <?php if($document->deskripsi): ?>
                                    <?php echo e($document->deskripsi); ?>

                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($document->wajib): ?>
                                    <span class="badge bg-danger">Wajib</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Opsional</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($document->urutan); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('documents.show', $document)); ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('documents.edit', $document)); ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('documents.destroy', $document)); ?>" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <?php echo e($documents->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <h5 class="text-muted mt-3">Belum ada data dokumen</h5>
                <p class="text-muted">Mulai dengan menambahkan jenis dokumen yang diperlukan</p>
                <a href="<?php echo e(route('documents.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Dokumen Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Informasi -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Informasi
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Dokumen Wajib</h6>
                        <p class="text-muted">Dokumen yang harus dilengkapi untuk pendaftaran LKS. Jika tidak lengkap, pendaftaran tidak dapat diproses.</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Dokumen Opsional</h6>
                        <p class="text-muted">Dokumen tambahan yang dapat dilengkapi untuk melengkapi persyaratan pendaftaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/documents/index.blade.php ENDPATH**/ ?>