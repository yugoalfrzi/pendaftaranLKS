<?php $__env->startSection('title', 'Admin - Verifikasi RPTKA'); ?>
<?php $__env->startSection('page-title', 'Verifikasi RPTKA'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .card-modern { border-radius:1.25rem; border:1px solid #edf2f7; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.02); overflow:hidden; }
    .card-header-custom { background:#fff; border-bottom:1px solid #eef2f6; padding:0.9rem 1.25rem; font-weight:600; font-size:0.9rem; display:flex; align-items:center; gap:0.5rem; }
    .stat-card { border-radius:1.25rem; border:none; transition:all 0.2s; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
    .stat-card:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,0.15); }
    .stat-value { font-size:1.7rem; font-weight:700; color:#fff; line-height:1.1; }
    .stat-label { color:rgba(255,255,255,0.85); font-size:.7rem; font-weight:600; text-transform:uppercase; }
    .stat-icon-sm { width:36px; height:36px; border-radius:0.65rem; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.25); color:#fff; font-size:1rem; flex-shrink:0; }
    .badge-pill { display:inline-flex; align-items:center; gap:0.25rem; padding:0.2rem 0.65rem; border-radius:2rem; font-size:0.72rem; font-weight:500; }
    .s-menunggu { background:#fef3c7; color:#b45309; }
    .s-proses { background:#dbeafe; color:#1d4ed8; }
    .s-diterima { background:#dcfce7; color:#15803d; }
    .s-terverifikasi { background:#e0e7ff; color:#4338ca; }
    .s-ditolak { background:#fee2e2; color:#b91c1c; }
    .s-dikembalikan { background:#e0f2fe; color:#0369a1; }
    .s-baru { background:#dcfce7; color:#15803d; }
    .s-ulang { background:#e0f2fe; color:#0369a1; }
    .table-doc th { background:#f8fafc; font-size:0.72rem; text-transform:uppercase; letter-spacing:0.04em; color:#475569; padding:0.7rem 1rem; border-bottom:1px solid #e2e8f0; white-space:nowrap; }
    .table-doc td { padding:0.75rem 1rem; vertical-align:middle; border-bottom:1px solid #f1f5f9; font-size:0.83rem; }
</style>


<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h4 class="fw-semibold mb-0"><i class="bi bi-file-earmark-person me-2 text-primary"></i>Verifikasi Permohonan RPTKA</h4>
</div>


<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Total</div><div class="stat-value"><?php echo e($stats['total']); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-folder2-open"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Menunggu</div><div class="stat-value"><?php echo e($stats['menunggu']); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Diterima</div><div class="stat-value"><?php echo e($stats['diterima']); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#dc2626,#b91c1c);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Ditolak</div><div class="stat-value"><?php echo e($stats['ditolak']); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-x-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#0891b2,#0e7490);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Dikembalikan</div><div class="stat-value"><?php echo e($stats['dikembalikan']); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-arrow-counterclockwise"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#7c3aed,#6d28d9);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Terverifikasi</div><div class="stat-value"><?php echo e($stats['terverifikasi']); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-patch-check"></i></div>
            </div>
        </div>
    </div>
</div>


<div class="card-modern mb-4">
    <div class="card-header-custom"><i class="bi bi-funnel text-primary"></i> Filter & Pencarian</div>
    <div class="card-body p-3">
        <form method="GET" action="<?php echo e(route('admin.rptka.index')); ?>" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-semibold mb-1">Pencarian</label>
                <input type="text" class="form-control form-control-sm" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama LKS atau TKA...">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select class="form-select form-select-sm" name="status">
                    <option value="">Semua Status</option>
                    <?php $__currentLoopData = ['Menunggu','Diterima','Ditolak','Dikembalikan','Terverifikasi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(request('status') == $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary btn-sm rounded-pill w-100"><i class="bi bi-search me-1"></i> Cari</button>
                <a href="<?php echo e(route('admin.rptka.index')); ?>" class="btn btn-outline-secondary btn-sm rounded-pill w-100">Reset</a>
            </div>
        </form>
    </div>
</div>


<div class="card-modern">
    <div class="card-header-custom"><i class="bi bi-table text-primary"></i> Daftar Permohonan RPTKA</div>
    <?php if($rptkas->count() > 0): ?>
    <div class="table-responsive">
        <table class="table table-doc mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama LKS / TKA</th>
                    <th>Jenis</th>
                    <th>Tgl Masuk</th>
                    <th>Status</th>
                    <th>Surat Rekomendasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $rptkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $sc = match($item->status_permohonan) {
                        'Menunggu' => 's-menunggu',
                        'Diterima' => 's-diterima',
                        'Terverifikasi' => 's-terverifikasi',
                        'Ditolak' => 's-ditolak',
                        'Dikembalikan' => 's-dikembalikan',
                        default => 's-menunggu',
                    };
                ?>
                <tr>
                    <td class="text-muted"><?php echo e($rptkas->firstItem() + $i); ?></td>
                    <td>
                        <span class="fw-semibold"><?php echo e($item->nama_lks); ?></span>
                        <br><small class="text-muted">TKA: <?php echo e($item->nama_tka_pemohon); ?></small>
                    </td>
                    <td>
                        <span class="badge-pill <?php echo e($item->permohonan_rptka == 'Baru' ? 's-baru' : 's-ulang'); ?>">
                            <?php echo e($item->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru'); ?>

                        </span>
                    </td>
                    <td><?php echo e($item->tanggal_masuk_dokumen->format('d/m/Y')); ?></td>
                    <td><span class="badge-pill <?php echo e($sc); ?>"><?php echo e($item->status_permohonan); ?></span></td>
                    <td>
                        <?php if($item->surat_rekomendasi_rptka_path): ?>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.rptka.preview-surat', $item->id)); ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2"><i class="bi bi-eye"></i></a>
                                <a href="<?php echo e(route('admin.rptka.download-surat', $item->id)); ?>" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                            </div>
                        <?php else: ?>
                            <span class="badge-pill s-menunggu">Belum Ada</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.rptka.verification', $item->id)); ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                            <i class="bi bi-shield-check me-1"></i> Verifikasi
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2"><?php echo e($rptkas->links()); ?></div>
    <?php else: ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1"></i>
        <p class="mt-2">Belum ada permohonan RPTKA</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/admin/rptka/index.blade.php ENDPATH**/ ?>