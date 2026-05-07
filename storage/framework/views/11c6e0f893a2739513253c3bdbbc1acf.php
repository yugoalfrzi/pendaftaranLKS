

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .stat-card {
        border-radius: 1.25rem;
        border: none;
        transition: all 0.2s; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .stat-card:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 12px 24px rgba(0,0,0,0.15); }
    .stat-icon {
        width: 44px;
        height: 44px; 
        border-radius: 1rem;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 1.2rem;
        background: rgba(255,255,255,0.25) !important;
        color: #fff !important;
    }
    .stat-value { 
        font-size: 1.7rem; 
        font-weight: 700; 
        color: #fff; 
        line-height: 1.1; 
    }
    .stat-label {
        color: rgba(255,255,255,0.85);
        font-size: .68rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .card-modern {
        border-radius: 1.25rem; 
        border: 1px solid #edf2f7;
        background: #fff; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.02); 
        overflow: hidden;
    }
    .card-header-custom {
        background: #fff; 
        border-bottom: 1px solid #eef2f6;
        padding: 0.9rem 1.25rem; 
        font-weight: 600; 
        font-size: 0.9rem;
    }
    .table-modern th {
        background: #f8fafc; 
        font-size: 0.72rem; 
        text-transform: uppercase;
        letter-spacing: 0.04em; 
        color: #475569; 
        padding: 0.7rem 1rem;
        border-bottom: 1px solid #e2e8f0; 
        white-space: nowrap;
    }
    .table-modern td {
        padding: 0.7rem 1rem; 
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9; 
        font-size: 0.83rem;
    }
    .badge-pill {
        display: inline-flex; 
        align-items: center; 
        gap: 0.25rem;
        padding: 0.2rem 0.65rem; 
        border-radius: 2rem;
        font-size: 0.7rem; 
        font-weight: 500;
    }
    .s-menunggu     { 
        background:#fef3c7; 
        color:#b45309; 
    }
    .s-proses       { 
        background:#dbeafe; 
        color:#1d4ed8; 
    }
    .s-diterima     { 
        background:#dcfce7; 
        color:#15803d; }
    .s-terverifikasi{ 
        background:#e0e7ff; 
        color:#4338ca; 
    }
    .s-ditolak      { 
        background:#fee2e2; 
        color:#b91c1c; 
    }
    .s-dikembalikan { 
        background:#e0f2fe; 
        color:#0369a1; 
    }
    .quick-action {
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center;
        gap: 0.5rem; 
        padding: 1.2rem 0.5rem; 
        border-radius: 1rem;
        border: 1.5px solid #e2e8f0; 
        background: #fff; 
        text-decoration: none;
        color: #334155; 
        transition: all 0.2s; 
        font-size: 0.82rem; 
        font-weight: 500;
    }
    .quick-action:hover { 
        border-color: #2563eb; 
        background: #eef2ff; 
        color: #1e40af; 
    }
    .quick-action i { 
        font-size: 1.5rem; 
    }
</style>


<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-semibold mb-1">
            <i class="bi bi-house-door me-2 text-primary"></i>Dashboard
        </h1>
        <p class="text-muted small mb-0">Selamat datang, <strong><?php echo e(auth()->user()->name); ?></strong>
            <?php if(auth()->user()->kabupaten_kota): ?>
                &mdash; <span class="text-primary"><?php echo e(auth()->user()->kabupaten_kota); ?></span>
            <?php endif; ?>
        </p>
    </div>
    <a href="<?php echo e(route('lks.create')); ?>" class="btn btn-primary rounded-pill px-4 btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Pendaftaran LKS Baru
    </a>
</div>


<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total LKS Saya</div>
                    <div class="stat-value"><?php echo e($totalLks); ?></div>
                </div>
                <div class="stat-icon"><i class="bi bi-buildings"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Menunggu</div>
                    <div class="stat-value"><?php echo e($menunggu); ?></div>
                </div>
                <div class="stat-icon"><i class="bi bi-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background: linear-gradient(135deg, #16a34a, #15803d);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Diterima</div>
                    <div class="stat-value"><?php echo e($diterima); ?></div>
                </div>
                <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3" style="background: linear-gradient(135deg, #0891b2, #0e7490);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Dikembalikan</div>
                    <div class="stat-value"><?php echo e($dikembalikan); ?></div>
                </div>
                <div class="stat-icon"><i class="bi bi-arrow-counterclockwise"></i></div>
            </div>
        </div>
    </div>
</div>


<div class="card-modern mb-4">
    <div class="card-header-custom"><i class="bi bi-lightning me-2"></i>Akses Cepat</div>
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-6 col-md-3">
                <a href="<?php echo e(route('lks.create')); ?>" class="quick-action">
                    <i class="bi bi-plus-circle text-primary"></i>
                    <span>Daftar LKS</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?php echo e(route('rptka.index')); ?>" class="quick-action">
                    <i class="bi bi-file-earmark-person text-indigo" style="color:#4338ca"></i>
                    <span>Permohonan RPTKA</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?php echo e(route('lks.terdaftar')); ?>" class="quick-action">
                    <i class="bi bi-patch-check text-success"></i>
                    <span>Tanda Pendaftaran</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?php echo e(route('announcements.regulasi')); ?>" class="quick-action">
                    <i class="bi bi-megaphone text-warning"></i>
                    <span>Pengumuman</span>
                </a>
            </div>
        </div>
    </div>
</div>


<?php if($statusTerkini->count() > 0): ?>
<div class="card-modern mb-4">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-bell me-2 text-primary"></i>Update Status LKS</span>
        <?php if($perluPerhatian > 0): ?>
            <span class="badge bg-danger rounded-pill" style="font-size:.72rem">
                <?php echo e($perluPerhatian); ?> perlu tindakan
            </span>
        <?php endif; ?>
    </div>
    <div class="card-body p-3 d-flex flex-column gap-2">
        <?php $__currentLoopData = $statusTerkini; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lks): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $sc = match($lks->status_permohonan) {
                'Diterima untuk proses' => ['class' => 's-proses', 'icon' => 'bi-hourglass-split', 'bg' => '#eff6ff'],
                'Diterima'              => ['class' => 's-diterima', 'icon' => 'bi-check-circle-fill', 'bg' => '#f0fdf4'],
                'Terverifikasi'         => ['class' => 's-terverifikasi', 'icon' => 'bi-patch-check-fill', 'bg' => '#eef2ff'],
                'Ditolak'               => ['class' => 's-ditolak', 'icon' => 'bi-x-circle-fill', 'bg' => '#fff1f2'],
                'Dikembalikan'          => ['class' => 's-dikembalikan', 'icon' => 'bi-arrow-counterclockwise', 'bg' => '#f0f9ff'],
                default                 => ['class' => 's-menunggu', 'icon' => 'bi-clock', 'bg' => '#fffbeb'],
            };
        ?>
        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 gap-3"
             style="background:<?php echo e($sc['bg']); ?>; border:1px solid rgba(0,0,0,0.05);">
            <div class="d-flex align-items-center gap-3 flex-1 min-w-0">
                <i class="bi <?php echo e($sc['icon']); ?> fs-5 flex-0 badge-pill <?php echo e($sc['class']); ?>" style="padding:.4rem; border-radius:.6rem;"></i>
                <div class="min-w-0">
                    <div class="fw-semibold text-truncate" style="font-size:.85rem;"><?php echo e($lks->nama_lks); ?></div>
                    <div class="text-muted" style="font-size:.75rem;">
                        Diperbarui <?php echo e($lks->updated_at->diffForHumans()); ?>

                        <?php if($lks->status_permohonan === 'Ditolak' && $lks->alasan_penolakan): ?>
                            &mdash; <span class="text-danger"><?php echo e(Str::limit($lks->alasan_penolakan, 60)); ?></span>
                        <?php elseif($lks->status_permohonan === 'Dikembalikan' && $lks->alasan_dikembalikan): ?>
                            &mdash; <span class="text-info"><?php echo e(Str::limit($lks->alasan_dikembalikan, 60)); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-0">
                <span class="badge-pill <?php echo e($sc['class']); ?>"><?php echo e($lks->status_permohonan); ?></span>
                <a href="<?php echo e(route('lks.show', $lks->id)); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-2" style="font-size:.72rem;">
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>


<?php if($rptkaStatusTerkini->count() > 0): ?>
<div class="card-modern mb-4">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-bell me-2 text-primary"></i>Update Status RPTKA</span>
        <?php if($rptkaPerluPerhatian > 0): ?>
            <span class="badge bg-danger rounded-pill" style="font-size:.72rem">
                <?php echo e($rptkaPerluPerhatian); ?> perlu tindakan
            </span>
        <?php endif; ?>
    </div>
    <div class="card-body p-3 d-flex flex-column gap-2">
        <?php $__currentLoopData = $rptkaStatusTerkini; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rptka): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $sr = match($rptka->status_permohonan) {
                'Diterima'    => ['class' => 's-diterima',     'icon' => 'bi-check-circle-fill',    'bg' => '#f0fdf4'],
                'Terverifikasi' => ['class' => 's-terverifikasi', 'icon' => 'bi-patch-check-fill',  'bg' => '#eef2ff'],
                'Ditolak'     => ['class' => 's-ditolak',      'icon' => 'bi-x-circle-fill',        'bg' => '#fff1f2'],
                'Dikembalikan'=> ['class' => 's-dikembalikan', 'icon' => 'bi-arrow-counterclockwise','bg' => '#f0f9ff'],
                default       => ['class' => 's-menunggu',     'icon' => 'bi-clock',                'bg' => '#fffbeb'],
            };
        ?>
        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 gap-3"
             style="background:<?php echo e($sr['bg']); ?>; border:1px solid rgba(0,0,0,0.05);">
            <div class="d-flex align-items-center gap-3 flex-1 min-w-0">
                <i class="bi <?php echo e($sr['icon']); ?> fs-5 flex-0 badge-pill <?php echo e($sr['class']); ?>" style="padding:.4rem; border-radius:.6rem;"></i>
                <div class="min-w-0">
                    <div class="fw-semibold text-truncate" style="font-size:.85rem;">
                        <?php echo e($rptka->nama_lks); ?>

                        <span class="text-muted fw-normal" style="font-size:.75rem;">— <?php echo e($rptka->nama_tka_pemohon); ?></span>
                    </div>
                    <div class="text-muted" style="font-size:.75rem;">
                        Diperbarui <?php echo e($rptka->updated_at->diffForHumans()); ?>

                        <?php if($rptka->status_permohonan === 'Ditolak' && $rptka->alasan_penolakan): ?>
                            &mdash; <span class="text-danger"><?php echo e(Str::limit($rptka->alasan_penolakan, 60)); ?></span>
                        <?php elseif($rptka->status_permohonan === 'Dikembalikan' && $rptka->alasan_dikembalikan): ?>
                            &mdash; <span class="text-info"><?php echo e(Str::limit($rptka->alasan_dikembalikan, 60)); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-0">
                <span class="badge-pill <?php echo e($sr['class']); ?>"><?php echo e($rptka->status_permohonan); ?></span>
                <a href="<?php echo e(route('rptka.show', $rptka->id)); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-2" style="font-size:.72rem;">
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>


<?php if($myLks->count() > 0): ?>
<div class="card-modern mb-4">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-check me-2 text-primary"></i>Pendaftaran LKS Saya</span>
    </div>
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama LKS</th>
                    <th>Tanda Daftar</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $myLks->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lksItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                    <td class="fw-semibold"><?php echo e($lksItem->nama_lks); ?></td>
                    <td>
                        <span class="badge-pill <?php echo e($lksItem->tanda_pendaftaran == 'Baru' ? 's-diterima' : 's-proses'); ?>">
                            <?php echo e($lksItem->tanda_pendaftaran); ?>

                        </span>
                    </td>
                    <td><?php echo e(\Carbon\Carbon::parse($lksItem->tanggal_masuk_dokumen)->format('d/m/Y')); ?></td>
                    <td>
                        <?php
                            $sc = match($lksItem->status_permohonan) {
                                'Menunggu','Menunggu kelengkapan data' => 's-menunggu',
                                'Diterima untuk proses' => 's-proses',
                                'Diterima' => 's-diterima',
                                'Terverifikasi' => 's-terverifikasi',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        ?>
                        <span class="badge-pill <?php echo e($sc); ?>"><?php echo e($lksItem->status_permohonan); ?></span>
                        <?php if($lksItem->status_permohonan === 'Ditolak' && $lksItem->alasan_penolakan): ?>
                            <div class="text-danger mt-1" style="font-size:.70rem;">
                                <i class="bi bi-info-circle me-1"></i><?php echo e(Str::limit($lksItem->alasan_penolakan, 50)); ?>

                            </div>
                        <?php elseif($lksItem->status_permohonan === 'Dikembalikan' && $lksItem->alasan_dikembalikan): ?>
                            <div class="text-warning mt-1" style="font-size:.70rem;">
                                <i class="bi bi-info-circle me-1"></i><?php echo e(Str::limit($lksItem->alasan_dikembalikan, 50)); ?>

                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="<?php echo e(route('lks.show', $lksItem->id)); ?>" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Detail" style="font-size:.75rem">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if($lksItem->status_permohonan === 'Ditolak'): ?>
                                <a href="<?php echo e(route('lks.create')); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="Daftar Baru" style="font-size:.75rem">
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                            <?php elseif($lksItem->status_permohonan === 'Dikembalikan'): ?>
                                <a href="<?php echo e(route('lks.edit', $lksItem->id)); ?>" class="btn btn-sm btn-outline-warning rounded-pill px-2" title="Edit" style="font-size:.75rem">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>


<?php if($totalRptka > 0): ?>
<div class="card-modern">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-file-earmark-person me-2"></i>Permohonan RPTKA Terbaru</span>
        <a href="<?php echo e(route('rptka.index')); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.78rem">
            Lihat Semua <i class="bi bi-arrow-right-short"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama LKS</th>
                    <th>Nama TKA</th>
                    <th>Jenis</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $recentRptka; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rptka): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                    <td class="fw-semibold"><?php echo e($rptka->nama_lks); ?></td>
                    <td><?php echo e($rptka->nama_tka_pemohon); ?></td>
                    <td><span class="badge-pill s-proses"><?php echo e($rptka->permohonan_rptka); ?></span></td>
                    <td><?php echo e(\Carbon\Carbon::parse($rptka->tanggal_masuk_dokumen)->format('d/m/Y')); ?></td>
                    <td>
                        <?php
                            $sc = match($rptka->status_permohonan) {
                                'Menunggu' => 's-menunggu',
                                'Diterima' => 's-diterima',
                                'Terverifikasi' => 's-terverifikasi',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        ?>
                        <span class="badge-pill <?php echo e($sc); ?>"><?php echo e($rptka->status_permohonan); ?></span>
                    </td>
                    <td>
                        <a href="<?php echo e(route('rptka.show', $rptka->id)); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.75rem">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/dashboard/user.blade.php ENDPATH**/ ?>