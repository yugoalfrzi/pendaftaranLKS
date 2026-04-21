<?php $__env->startSection('title', 'Data Keuangan Hibah LKS'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-cash-stack"></i> Data Keuangan Hibah LKS
        <span class="badge bg-secondary ms-2"><?php echo e($selectedYear ?? now()->year); ?></span>
    </h1>
    <?php if(auth()->guard()->check()): ?>
        <?php if(Auth::user()->hasRole(['super_admin', 'admin'])): ?>
        <a href="<?php echo e(route('hibah.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Data Hibah
        </a>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Statistik -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0"><?php echo e($totalProposal); ?></h4>
                    <small class="text-muted">Total Proposal</small>
                </div>
                <i class="bi bi-file-text fs-2 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0"><?php echo e($proposalTerupload); ?></h4>
                    <small class="text-muted">Proposal Terupload</small>
                </div>
                <i class="bi bi-check-circle fs-2 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0"><?php echo e($lpjTerupload); ?></h4>
                    <small class="text-muted">LPJ Terupload</small>
                </div>
                <i class="bi bi-file-earmark-text fs-2 text-info"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0"><?php echo e($dokumenLengkap); ?></h4>
                    <small class="text-muted">Dokumen Lengkap</small>
                </div>
                <i class="bi bi-folder-check fs-2 text-warning"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('hibah.keuangan', $selectedYear ?? now()->year)); ?>" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Tahun</label>
                <input type="number" name="tahun" class="form-control"
                       value="<?php echo e($selectedYear ?? now()->year); ?>" min="2020" max="2100">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Pencarian</label>
                <input type="text" name="search" class="form-control"
                       value="<?php echo e(request('search')); ?>" placeholder="Cari nama LKS...">
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
                <a href="<?php echo e(route('hibah.keuangan', $selectedYear ?? now()->year)); ?>" class="btn btn-outline-secondary w-100">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-table"></i> Daftar Data Hibah Tahun <?php echo e($selectedYear ?? now()->year); ?>

        </h5>
    </div>
    <div class="card-body">
        <?php if($items->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama LKS</th>
                        <th width="12%">Proposal</th>
                        <th width="12%">LPJ</th>
                        <th width="18%">Progress Dokumen</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $docFields = [
                            'hasil_verifikasi_path','pergub_penjabaran_apbd_path','dpa_path',
                            'hasil_identifikasi_path','data_penerima_hibah_path',
                            'spm_path','sp2d_path','petunjuk_teknis_path'
                        ];
                        $totalDocs    = count($docFields);
                        $uploadedDocs = collect($docFields)->filter(fn($f) => $row->$f)->count();
                        $percentage   = $totalDocs > 0 ? ($uploadedDocs / $totalDocs) * 100 : 0;
                        $statusClass  = $percentage == 100 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger');
                        $statusText   = $percentage == 100 ? 'Lengkap' : ($percentage >= 50 ? 'Sebagian' : 'Minimal');
                    ?>
                    <tr>
                        <td><?php echo e($items->firstItem() + $index); ?></td>
                        <td>
                            <strong><?php echo e($row->nama_lks); ?></strong><br>
                            <small class="text-muted">Tahun: <?php echo e($row->tahun); ?></small>
                        </td>
                        <td>
                            <?php if($row->proposal_path): ?>
                                <a href="<?php echo e(Storage::disk('public')->url($row->proposal_path)); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            <?php else: ?>
                                <span class="badge bg-danger">Belum Ada</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row->lpj_path): ?>
                                <a href="<?php echo e(Storage::disk('public')->url($row->lpj_path)); ?>" target="_blank" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Belum Ada</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="flex-grow-1">
                                    <div class="progress" style="height:8px;">
                                        <div class="progress-bar bg-<?php echo e($statusClass); ?>" style="width:<?php echo e($percentage); ?>%"></div>
                                    </div>
                                </div>
                                <small class="text-nowrap">
                                    <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($statusText); ?></span>
                                    <?php echo e($uploadedDocs); ?>/<?php echo e($totalDocs); ?>

                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('hibah.show', $row)); ?>" class="btn btn-outline-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if(auth()->guard()->check()): ?>
                                    <?php if(Auth::user()->hasRole(['super_admin', 'admin'])): ?>
                                    <a href="<?php echo e(route('hibah.edit', $row)); ?>" class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?php echo e(route('hibah.documents', $row->id)); ?>" class="btn btn-outline-secondary" title="Dokumen">
                                        <i class="bi bi-folder2-open"></i>
                                    </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(Auth::user()->hasRole(['super_admin', 'admin'])): ?>
                                <form action="<?php echo e(route('hibah.destroy', $row)); ?>" method="POST" class="d-inline mt-1"
                                      onsubmit="return confirm('Hapus data hibah <?php echo e($row->nama_lks); ?>?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-outline-danger btn-sm w-100 mt-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                Menampilkan <?php echo e($items->firstItem()); ?>–<?php echo e($items->lastItem()); ?> dari <?php echo e($items->total()); ?> data
            </small>
            <?php echo e($items->links()); ?>

        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-2">Belum ada data hibah untuk tahun <?php echo e($selectedYear ?? now()->year); ?></p>
            <?php if(auth()->guard()->check()): ?>
                <?php if(Auth::user()->hasRole(['super_admin', 'admin'])): ?>
                <a href="<?php echo e(route('hibah.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Data Hibah
                </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/hibah/index.blade.php ENDPATH**/ ?>