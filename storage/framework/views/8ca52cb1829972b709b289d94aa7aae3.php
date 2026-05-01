<?php $__env->startSection('title', 'LKS Terdaftar'); ?>
<?php $__env->startSection('page-title', 'LKS Terdaftar'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between py-3">
                <div>
                    <h4 class="mb-0"><?php echo e($stats['kabkota'] + $stats['provinsi']); ?></h4>
                    <p class="mb-0 small text-muted">Total LKS Terdaftar</p>
                </div>
                <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                    <i class="bi bi-patch-check fs-4 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between py-3">
                <div>
                    <h4 class="mb-0"><?php echo e($stats['kabkota']); ?></h4>
                    <p class="mb-0 small text-muted">Kewenangan Kab/Kota</p>
                </div>
                <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                    <i class="bi bi-building fs-4 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between py-3">
                <div>
                    <h4 class="mb-0"><?php echo e($stats['provinsi']); ?></h4>
                    <p class="mb-0 small text-muted">Kewenangan Provinsi</p>
                </div>
                <div class="bg-success bg-opacity-10 p-2 rounded-circle">
                    <i class="bi bi-map fs-4 text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form method="GET" action="<?php echo e(route('lks.terdaftar')); ?>">
            <div class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label small fw-bold mb-1">Pencarian</label>
                    <input type="text" class="form-control form-control-sm" name="search"
                           value="<?php echo e(request('search')); ?>" placeholder="Cari nama LKS atau kabupaten/kota...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm w-100" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="<?php echo e(route('lks.terdaftar')); ?>" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs" id="terdaftarTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-kabkota" data-bs-toggle="tab"
                data-bs-target="#pane-kabkota" type="button" role="tab">
            <i class="bi bi-building"></i> Kewenangan Kab/Kota
            <span class="badge bg-primary ms-1"><?php echo e($lksKabkota->total()); ?></span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-provinsi" data-bs-toggle="tab"
                data-bs-target="#pane-provinsi" type="button" role="tab">
            <i class="bi bi-map"></i> Kewenangan Provinsi
            <span class="badge bg-success ms-1"><?php echo e($lksProvinsi->total()); ?></span>
        </button>
    </li>
</ul>

<div class="tab-content border border-top-0 rounded-bottom bg-white shadow-sm mb-4" id="terdaftarTabContent">

    
    <div class="tab-pane fade show active p-3" id="pane-kabkota" role="tabpanel">
        <p class="text-muted small mb-3">
            <i class="bi bi-info-circle"></i>
            LKS kewenangan Kab/Kota yang telah mendapatkan <strong>Sertifikat Kab/Kota</strong> dari Admin.
        </p>

        <?php if($lksKabkota->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama LKS</th>
                        <th>Kabupaten/Kota</th>
                        <th>Tanda Daftar</th>
                        <th>Verifikator</th>
                        <th>Tanda Pendaftaran Kab/Kota</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $lksKabkota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($lksKabkota->firstItem() + $index); ?></td>
                        <td>
                            <strong><?php echo e($item->nama_lks); ?></strong>
                            <?php if($item->nama_ketua_lks): ?>
                                <br><small class="text-muted">Ketua: <?php echo e($item->nama_ketua_lks); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->kabupaten_kota ?? $item->lokasi_lks ?? '-'); ?></td>
                        <td>
                            <span class="badge <?php echo e($item->tanda_pendaftaran == 'Baru' ? 'bg-success' : 'bg-info'); ?>">
                                <?php echo e($item->tanda_pendaftaran); ?>

                            </span>
                        </td>
                        <td><?php echo e($item->nama_verifikator ?? '-'); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('admin.verification.preview-sertifikat-kabkota', $item->id)); ?>"
                                   target="_blank" class="btn btn-outline-info" title="Preview">
                                    <i class="bi bi-eye"></i> Preview
                                </a>
                                <a href="<?php echo e(route('admin.verification.download-sertifikat-kabkota', $item->id)); ?>"
                                   class="btn btn-outline-success" title="Download">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </div>
                        </td>
                        <td>
                            <a href="<?php echo e(route('lks.show', $item->id)); ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="mt-2"><?php echo e($lksKabkota->appends(request()->query())->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1"></i>
            <p class="mt-2">Belum ada LKS kewenangan Kab/Kota yang sudah bersertifikat.</p>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="tab-pane fade p-3" id="pane-provinsi" role="tabpanel">
        <p class="text-muted small mb-3">
            <i class="bi bi-info-circle"></i>
            LKS kewenangan Provinsi yang telah mendapatkan <strong>Sertifikat</strong> dari Super Admin.
        </p>

        <?php if($lksProvinsi->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama LKS</th>
                        <th>Kabupaten/Kota</th>
                        <th>Tanda Daftar</th>
                        <th>Verifikator</th>
                        <th>Tannda Pendaftaran Provinsi</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $lksProvinsi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($lksProvinsi->firstItem() + $index); ?></td>
                        <td>
                            <strong><?php echo e($item->nama_lks); ?></strong>
                            <?php if($item->nama_ketua_lks): ?>
                                <br><small class="text-muted">Ketua: <?php echo e($item->nama_ketua_lks); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->kabupaten_kota ?? $item->lokasi_lks ?? '-'); ?></td>
                        <td>
                            <span class="badge <?php echo e($item->tanda_pendaftaran == 'Baru' ? 'bg-success' : 'bg-info'); ?>">
                                <?php echo e($item->tanda_pendaftaran); ?>

                            </span>
                        </td>
                        <td><?php echo e($item->nama_verifikator ?? '-'); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('superadmin.preview-surat', $item->id)); ?>"
                                   target="_blank" class="btn btn-outline-info" title="Preview">
                                    <i class="bi bi-eye"></i> Preview
                                </a>
                                <a href="<?php echo e(route('superadmin.download-surat', $item->id)); ?>"
                                   class="btn btn-outline-success" title="Download">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </div>
                        </td>
                        <td>
                            <a href="<?php echo e(route('lks.show', $item->id)); ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="mt-2"><?php echo e($lksProvinsi->appends(request()->query())->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1"></i>
            <p class="mt-2">Belum ada LKS kewenangan Provinsi yang sudah bersertifikat.</p>
        </div>
        <?php endif; ?>
    </div>

</div>

<style>
.nav-tabs .nav-link { font-size: 0.9rem; }
.table td { vertical-align: middle; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Preserve active tab on page reload
    const activeTab = localStorage.getItem('terdaftarActiveTab');
    if (activeTab) {
        const tab = document.querySelector('#terdaftarTabs button[data-bs-target="' + activeTab + '"]');
        if (tab) new bootstrap.Tab(tab).show();
    }
    document.querySelectorAll('#terdaftarTabs button').forEach(btn => {
        btn.addEventListener('shown.bs.tab', e => {
            localStorage.setItem('terdaftarActiveTab', e.target.getAttribute('data-bs-target'));
        });
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/lks/terdaftar.blade.php ENDPATH**/ ?>