<?php $__env->startSection('title', 'Data Keuangan Hibah LKS'); ?>
<?php $__env->startSection('page-title', 'Hibah LKS'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .card-modern { 
        border-radius:1.25rem; 
        border:1px solid #edf2f7; 
        background:#fff; 
        box-shadow:0 2px 8px rgba(0,0,0,0.02); 
        overflow:hidden; 
    }
    .card-header-custom { 
        background:#fff; 
        border-bottom:1px solid #eef2f6; 
        padding:0.9rem 1.25rem; 
        font-weight:600; 
        font-size:0.9rem; 
        display:flex; 
        align-items:center; 
        gap:0.5rem; 
    }
    .stat-card { 
        border-radius:1.25rem; 
        border:none; 
        transition:all 0.2s; 
        box-shadow:0 4px 15px rgba(0,0,0,0.1); 
    }
    .stat-card:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,0.15); }
    .stat-value { 
        font-size:1.7rem; 
        font-weight:700; 
        color:#fff; 
        line-height:1.1; 
    }
    .stat-label { color:rgba(255,255,255,0.85); font-size:.72rem; font-weight:600; text-transform:uppercase; }
    .stat-icon-sm { 
        width:36px; height:36px; border-radius:0.65rem;
        display:flex; align-items:center; justify-content:center;
        background:rgba(255,255,255,0.25); color:#fff; font-size:1rem; flex-shrink:0;
    }
    .badge-pill { 
        display:inline-flex; 
        align-items:center; 
        gap:0.25rem; 
        padding:0.2rem 0.65rem; 
        border-radius:2rem; 
        font-size:0.72rem; 
        font-weight:500; 
    }
    .s-tersedia { 
        background:#dcfce7; 
        color:#15803d; 
    }
    .s-belum    { 
        background:#fee2e2; 
        color:#b91c1c; 
    }
    .s-sebagian { 
        background:#fef3c7; 
        color:#b45309; 
    }
    .table-doc th { 
        background:#f8fafc; 
        font-size:0.72rem; 
        text-transform:uppercase; 
        letter-spacing:0.04em; 
        color:#475569; 
        padding:0.7rem 1rem; 
        border-bottom:1px solid #e2e8f0; 
        white-space:nowrap; 
    }
    .table-doc td { 
        padding:0.75rem 1rem; 
        vertical-align:middle; 
        border-bottom:1px solid #f1f5f9; 
        font-size:0.83rem; 
    }
</style>


<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-semibold mb-1">
            <i class="bi bi-cash-stack me-2 text-primary"></i>Data Keuangan Hibah LKS
            <span class="badge-pill s-tersedia ms-2"><?php echo e($selectedYear ?? now()->year); ?></span>
        </h4>
    </div>
    <?php if(auth()->guard()->check()): ?>
        <?php if(Auth::user()->hasRole(['super_admin', 'admin'])): ?>
        <a href="<?php echo e(route('hibah.create')); ?>" class="btn btn-primary btn-sm rounded-pill px-3">
            <i class="bi bi-plus-circle me-1"></i> Tambah Data Hibah
        </a>
        <?php endif; ?>
    <?php endif; ?>
</div>


<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Total Proposal</div><div class="stat-value"><?php echo e($totalProposal); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-file-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Proposal Terupload</div><div class="stat-value"><?php echo e($proposalTerupload); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#0891b2,#0e7490);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">LPJ Terupload</div><div class="stat-value"><?php echo e($lpjTerupload); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-file-earmark-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Dokumen Lengkap</div><div class="stat-value"><?php echo e($dokumenLengkap); ?></div></div>
                <div class="stat-icon-sm"><i class="bi bi-folder-check"></i></div>
            </div>
        </div>
    </div>
</div>


<div class="card-modern mb-4">
    <div class="card-header-custom"><i class="bi bi-funnel text-primary"></i> Filter & Pencarian</div>
    <div class="card-body p-3">
        <form id="filterForm" class="row g-2 align-items-end" onsubmit="handleFilterSubmit(event)">
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">Tahun</label>
                <input type="number" id="filterTahun" class="form-control form-control-sm"
                       value="<?php echo e($selectedYear ?? now()->year); ?>" min="2020" max="2100">
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-semibold mb-1">Pencarian</label>
                <input type="text" id="filterSearch" class="form-control form-control-sm"
                       value="<?php echo e(request('search')); ?>" placeholder="Cari nama LKS...">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-pill w-100">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                <a href="<?php echo e(route('hibah.keuangan', now()->year)); ?>" class="btn btn-outline-secondary btn-sm rounded-pill w-100">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function handleFilterSubmit(e) {
    e.preventDefault();
    const tahun = document.getElementById('filterTahun').value || <?php echo e(now()->year); ?>;
    const search = document.getElementById('filterSearch').value;
    let url = '/hibah/keuangan/' + tahun;
    if (search) url += '?search=' + encodeURIComponent(search);
    window.location.href = url;
}
</script>


<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-table text-primary"></i> Daftar Data Hibah Tahun <?php echo e($selectedYear ?? now()->year); ?>

    </div>
    <?php if($items->count() > 0): ?>
    <div class="table-responsive">
        <table class="table table-doc mb-0">
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th>Nama LKS</th>
                    <th style="width:12%">Proposal</th>
                    <th style="width:12%">LPJ</th>
                    <th style="width:20%">Progress Dokumen</th>
                    <th style="width:14%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $docFields = [
                        'hasil_verifikasi_path','pergub_penjabaran_apbd_path','dpa_path',
                        'hasil_identifikasi_path','data_penerima_hibah_path',
                        'spm_path','sp2d_path','petunjuk_teknis_path',
                        'surat_ket_lampiran_verifikasi_path','bukti_pembayaran_transfer_path',
                        'sk_kadinsos_tim_verifikasi_path',
                    ];
                    $totalDocs    = count($docFields);
                    $uploadedDocs = collect($docFields)->filter(fn($f) => $row->$f)->count();
                    $percentage   = $totalDocs > 0 ? ($uploadedDocs / $totalDocs) * 100 : 0;
                    $statusClass  = $percentage == 100 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger');
                    $statusText   = $percentage == 100 ? 'Lengkap' : ($percentage >= 50 ? 'Sebagian' : 'Minimal');
                    $pillClass    = $percentage == 100 ? 's-tersedia' : ($percentage >= 50 ? 's-sebagian' : 's-belum');
                ?>
                <tr>
                    <td class="text-muted"><?php echo e($items->firstItem() + $index); ?></td>
                    <td>
                        <span class="fw-semibold"><?php echo e($row->nama_lks); ?></span>
                        <br><small class="text-muted">Tahun: <?php echo e($row->tahun); ?></small>
                    </td>
                    <td>
                        <?php if($row->proposal_path): ?>
                            <a href="<?php echo e(Storage::disk('public')->url($row->proposal_path)); ?>" target="_blank"
                               class="btn btn-sm btn-outline-primary rounded-pill px-2">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                        <?php else: ?>
                            <span class="badge-pill s-belum">Belum Ada</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($row->lpj_path): ?>
                            <a href="<?php echo e(Storage::disk('public')->url($row->lpj_path)); ?>" target="_blank"
                               class="btn btn-sm btn-outline-success rounded-pill px-2">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                        <?php else: ?>
                            <span class="badge-pill s-sebagian">Belum Ada</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="flex-1">
                                <div class="progress" style="height:6px; border-radius:1rem;">
                                    <div class="progress-bar bg-<?php echo e($statusClass); ?>" style="width:<?php echo e($percentage); ?>%; border-radius:1rem;"></div>
                                </div>
                            </div>
                            <span class="badge-pill <?php echo e($pillClass); ?>" style="font-size:.65rem;"><?php echo e($statusText); ?> <?php echo e($uploadedDocs); ?>/<?php echo e($totalDocs); ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="<?php echo e(route('hibah.show', $row)); ?>" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(Auth::user()->hasRole(['super_admin', 'admin'])): ?>
                                <a href="<?php echo e(route('hibah.edit', $row)); ?>" class="btn btn-sm btn-outline-warning rounded-pill px-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?php echo e(route('hibah.documents', $row->id)); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-2" title="Dokumen">
                                    <i class="bi bi-folder2-open"></i>
                                </a>
                                <form action="<?php echo e(route('hibah.destroy', $row)); ?>" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus data hibah <?php echo e($row->nama_lks); ?>?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2 d-flex justify-content-between align-items-center">
        <small class="text-muted">
            Menampilkan <?php echo e($items->firstItem()); ?>–<?php echo e($items->lastItem()); ?> dari <?php echo e($items->total()); ?> data
        </small>
        <?php echo e($items->links()); ?>

    </div>
    <?php else: ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1"></i>
        <p class="mt-2">Belum ada data hibah untuk tahun <?php echo e($selectedYear ?? now()->year); ?></p>
        <?php if(auth()->guard()->check()): ?>
            <?php if(Auth::user()->hasRole(['super_admin', 'admin'])): ?>
            <a href="<?php echo e(route('hibah.create')); ?>" class="btn btn-primary btn-sm rounded-pill px-4 mt-2">
                <i class="bi bi-plus-circle me-1"></i> Tambah Data Hibah
            </a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/hibah/index.blade.php ENDPATH**/ ?>