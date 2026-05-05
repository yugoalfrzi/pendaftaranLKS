
<?php $__env->startSection('title', 'Super Admin - Verval RPTKA'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-patch-check"></i> Verifikasi & Validasi RPTKA</h1>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
    <?php $__currentLoopData = [
        ['label'=>'Total Masuk','val'=>$stats['total'],'color'=>'primary','icon'=>'folder2-open'],
        ['label'=>'Belum Verval','val'=>$stats['belum_verval'],'color'=>'warning','icon'=>'hourglass-split'],
        ['label'=>'Sudah Verval','val'=>$stats['sudah_verval'],'color'=>'success','icon'=>'check-circle'],
        ['label'=>'Terverifikasi','val'=>$stats['terverifikasi'],'color'=>'info','icon'=>'patch-check'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0"><?php echo e($s['val']); ?></h4>
                    <small class="text-muted"><?php echo e($s['label']); ?></small>
                </div>
                <i class="bi bi-<?php echo e($s['icon']); ?> fs-2 text-<?php echo e($s['color']); ?>"></i>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama LKS atau TKA...">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="has_final">
                    <option value="">Semua</option>
                    <option value="no" <?php echo e(request('has_final') == 'no' ? 'selected' : ''); ?>>Belum Ada Surat Final</option>
                    <option value="yes" <?php echo e(request('has_final') == 'yes' ? 'selected' : ''); ?>>Sudah Ada Surat Final</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Cari</button>
                <a href="<?php echo e(route('superadmin.rptka.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel -->
<div class="card">
    <div class="card-body">
        <?php if($rptkas->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama LKS / TKA</th>
                        <th>Jenis</th>
                        <th>Surat Rekomendasi (Admin)</th>
                        <th>Surat Final (Verval)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $rptkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($rptkas->firstItem() + $i); ?></td>
                        <td>
                            <strong><?php echo e($item->nama_lks); ?></strong><br>
                            <small class="text-muted">TKA: <?php echo e($item->nama_tka_pemohon); ?></small>
                        </td>
                        <td>
                            <span class="badge <?php echo e($item->permohonan_rptka == 'Baru' ? 'bg-success' : 'bg-warning text-dark'); ?>">
                                <?php echo e($item->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru'); ?>

                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('admin.rptka.preview-surat', $item->id)); ?>" class="btn btn-outline-info" target="_blank" title="Preview"><i class="bi bi-eye"></i></a>
                                <a href="<?php echo e(route('admin.rptka.download-surat', $item->id)); ?>" class="btn btn-outline-success" title="Download"><i class="bi bi-download"></i></a>
                            </div>
                        </td>
                        <td>
                            <?php if($item->surat_rekomendasi_rptka_final_path): ?>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo e(route('superadmin.rptka.preview-final', $item->id)); ?>" class="btn btn-outline-info" target="_blank" title="Preview"><i class="bi bi-eye"></i></a>
                                    <a href="<?php echo e(route('superadmin.rptka.download-final', $item->id)); ?>" class="btn btn-outline-success" title="Download"><i class="bi bi-download"></i></a>
                                </div>
                            <?php else: ?>
                                <span class="badge bg-secondary">Belum Ada</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('superadmin.rptka.verification', $item->id)); ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-patch-check"></i> Verval
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3"><?php echo e($rptkas->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-2">Belum ada RPTKA yang siap diverval</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/superadmin/rptka/index.blade.php ENDPATH**/ ?>