

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .stat-card {
        background: #fff; border-radius: 1.25rem;
        border: 1px solid rgba(203,213,225,0.4);
        transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px -10px rgba(0,0,0,0.1); }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 1rem;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }
    .stat-value { font-size: 1.7rem; font-weight: 700; color: #0f172a; line-height: 1.1; }
    .card-modern {
        border-radius: 1.25rem; border: 1px solid #edf2f7;
        background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.02); overflow: hidden;
    }
    .card-header-custom {
        background: #fff; border-bottom: 1px solid #eef2f6;
        padding: 0.9rem 1.25rem; font-weight: 600; font-size: 0.9rem;
    }
    .table-modern th {
        background: #f8fafc; font-size: 0.72rem; text-transform: uppercase;
        letter-spacing: 0.04em; color: #475569; padding: 0.7rem 1rem;
        border-bottom: 1px solid #e2e8f0; white-space: nowrap;
    }
    .table-modern td {
        padding: 0.7rem 1rem; vertical-align: middle;
        border-bottom: 1px solid #f1f5f9; font-size: 0.83rem;
    }
    .badge-pill {
        display: inline-flex; align-items: center; gap: 0.25rem;
        padding: 0.2rem 0.65rem; border-radius: 2rem;
        font-size: 0.7rem; font-weight: 500;
    }
    .s-menunggu     { background:#fef3c7; color:#b45309; }
    .s-proses       { background:#dbeafe; color:#1d4ed8; }
    .s-diterima     { background:#dcfce7; color:#15803d; }
    .s-terverifikasi{ background:#e0e7ff; color:#4338ca; }
    .s-ditolak      { background:#fee2e2; color:#b91c1c; }
    .s-dikembalikan { background:#e0f2fe; color:#0369a1; }
    .quick-action {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 0.5rem; padding: 1.2rem 0.5rem; border-radius: 1rem;
        border: 1.5px solid #e2e8f0; background: #fff; text-decoration: none;
        color: #334155; transition: all 0.2s; font-size: 0.82rem; font-weight: 500;
    }
    .quick-action:hover { border-color: #2563eb; background: #eef2ff; color: #1e40af; }
    .quick-action i { font-size: 1.5rem; }
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
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted fw-semibold text-uppercase" style="font-size:.68rem">Total LKS Saya</div>
                    <div class="stat-value"><?php echo e($totalLks); ?></div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-buildings"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted fw-semibold text-uppercase" style="font-size:.68rem">Menunggu</div>
                    <div class="stat-value text-warning"><?php echo e($menunggu); ?></div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted fw-semibold text-uppercase" style="font-size:.68rem">Diterima</div>
                    <div class="stat-value text-success"><?php echo e($diterima); ?></div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted fw-semibold text-uppercase" style="font-size:.68rem">Dikembalikan</div>
                    <div class="stat-value text-info"><?php echo e($dikembalikan); ?></div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-arrow-counterclockwise"></i></div>
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


<div class="card-modern mb-4">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2"></i>Pendaftaran LKS Terbaru</span>
        <?php if($totalLks > 5): ?>
            <span class="text-muted small">Menampilkan 5 dari <?php echo e($totalLks); ?></span>
        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama LKS</th>
                    <th>Kewenangan</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $recentLKS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lks): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                    <td class="fw-semibold"><?php echo e($lks->nama_lks); ?></td>
                    <td>
                        <span class="badge-pill <?php echo e($lks->kewenangan_type === 'kabkota' ? 's-proses' : 's-terverifikasi'); ?>">
                            <?php echo e($lks->kewenangan_type === 'kabkota' ? 'Kab/Kota' : 'Provinsi'); ?>

                        </span>
                    </td>
                    <td><?php echo e(\Carbon\Carbon::parse($lks->tanggal_masuk_dokumen)->format('d/m/Y')); ?></td>
                    <td>
                        <?php
                            $sc = match($lks->status_permohonan) {
                                'Menunggu','Menunggu kelengkapan data' => 's-menunggu',
                                'Diterima untuk proses' => 's-proses',
                                'Diterima' => 's-diterima',
                                'Terverifikasi' => 's-terverifikasi',
                                'Ditolak' => 's-ditolak',
                                'Dikembalikan' => 's-dikembalikan',
                                default => 's-menunggu',
                            };
                        ?>
                        <span class="badge-pill <?php echo e($sc); ?>"><?php echo e($lks->status_permohonan); ?></span>
                    </td>
                    <td>
                        <a href="<?php echo e(route('lks.show', $lks->id)); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.75rem">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="bi bi-inbox fs-2 text-muted d-block mb-2"></i>
                        <span class="text-muted">Belum ada pendaftaran LKS</span><br>
                        <a href="<?php echo e(route('lks.create')); ?>" class="btn btn-primary rounded-pill px-4 mt-3 btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Mulai Pendaftaran
                        </a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


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


<?php if($latestLks && in_array($latestLks->status_permohonan, ['Diterima untuk proses','Diterima','Ditolak','Dikembalikan'])): ?>
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <?php
                $st = $latestLks->status_permohonan;
                $hc = match($st) { 'Diterima untuk proses','Diterima' => 'bg-success', 'Ditolak' => 'bg-danger', default => 'bg-warning' };
                $ic = match($st) { 'Diterima untuk proses','Diterima' => 'bi-check-circle', 'Ditolak' => 'bi-x-circle', default => 'bi-arrow-counterclockwise' };
            ?>
            <div class="modal-header <?php echo e($hc); ?> text-white border-0">
                <h5 class="modal-title fw-semibold"><i class="bi <?php echo e($ic); ?> me-2"></i>Update Status: <?php echo e($st); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="fw-semibold mb-1"><?php echo e($latestLks->nama_lks); ?></p>
                <?php if($st === 'Ditolak'): ?>
                    <div class="alert alert-danger py-2 small"><?php echo e($latestLks->alasan_penolakan ?? 'Tidak ada keterangan.'); ?></div>
                <?php elseif($st === 'Dikembalikan'): ?>
                    <div class="alert alert-warning py-2 small"><?php echo e($latestLks->alasan_dikembalikan ?? 'Tidak ada keterangan.'); ?></div>
                <?php else: ?>
                    <div class="alert alert-success py-2 small">Permohonan Anda telah diterima dan sedang diproses.</div>
                <?php endif; ?>
                <small class="text-muted">Diperbarui: <?php echo e(optional($latestLks->updated_at)->format('d/m/Y H:i')); ?></small>
            </div>
            <div class="modal-footer border-0 pt-0">
                <a href="<?php echo e(route('lks.show', $latestLks->id)); ?>" class="btn btn-outline-primary rounded-pill px-4 btn-sm">Lihat Detail</a>
                <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    <?php if($latestLks && in_array($latestLks->status_permohonan, ['Diterima untuk proses','Diterima','Ditolak','Dikembalikan'])): ?>
    const key = 'statusModal_<?php echo e($latestLks->id); ?>_<?php echo e($latestLks->updated_at?->timestamp); ?>';
    if (!sessionStorage.getItem(key)) {
        new bootstrap.Modal(document.getElementById('statusModal')).show();
        sessionStorage.setItem(key, '1');
    }
    <?php endif; ?>
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/dashboard/user.blade.php ENDPATH**/ ?>