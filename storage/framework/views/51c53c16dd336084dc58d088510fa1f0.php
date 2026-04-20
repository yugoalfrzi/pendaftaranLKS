<?php $__env->startSection('title', 'Admin Panel - Verifikasi LKS'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-gear-wide-connected"></i> Admin Panel - Upload Surat Rekomendasi
            </h1>
            <div class="justify-content-end btn-group">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
                <a href="<?php echo e(route('documents.index')); ?>" class="btn btn-outline-primary">
                    <i class="bi bi-file-text"></i> Dokumen Tanda Pendaftaran
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h4 class="text-muted mb-1"><?php echo e($stats['total']); ?></h4>
                        <p class="mb-0">Total Pendaftaran</p>
                    </div>
                     <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-file-text fs-3 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="text-muted mb-0"><?php echo e($stats['menunggu']); ?></h4>
                        <p class="mb-0">Menunggu Verifikasi</p>
                    </div>
                     <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-clock-history fs-3 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="text-muted mb-0"><?php echo e($stats['diterima_proses']); ?></h4>
                        <p class="mb-0">Diterima Proses</p>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-arrow-repeat fs-3 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h4 class="text-muted mb-0"><?php echo e($stats['diterima'] + $stats['terverifikasi']); ?></h4>
                        <p class="mb-0">Diterima/Terverifikasi</p>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-check-circle fs-3 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h4 class="text-muted mb-0"><?php echo e($stats['ditolak'] + $stats['dikembalikan']); ?></h4>
                        <p class="mb-0">Ditolak/Dikembalikan</p>
                    </div>
                     <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-x-circle fs-3 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h4 class="text-muted mb-0"><?php echo e($stats['with_sertifikat'] ?? 0); ?></h4>
                        <p class="mb-0">Dengan Surat Rekomendasi</p>
                    </div>
                     <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-award fs-3 text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Options -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-funnel"></i> Filter Data
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.lks.index')); ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" <?php echo e(request('status') == 'Menunggu' ? 'selected' : ''); ?>>Menunggu</option>
                        <option value="Diterima untuk proses" <?php echo e(request('status') == 'Diterima untuk proses' ? 'selected' : ''); ?>>Diterima untuk Proses</option>
                        <option value="Terverifikasi" <?php echo e(request('status') == 'Terverifikasi' ? 'selected' : ''); ?>>Terverifikasi</option>
                        <option value="Ditolak" <?php echo e(request('status') == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                        <option value="Dikembalikan" <?php echo e(request('status') == 'Dikembalikan' ? 'selected' : ''); ?>>Dikembalikan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Surat Rekomendasi</label>
                    <select class="form-select" id="sertifikatFilter">
                        <option value="">Semua</option>
                        <option value="ada">Dengan Surat Rekomendasi</option>
                        <option value="tidak">Tanpa Surat Rekomendasi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pencarian</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama LKS...">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-table"></i> Daftar LKS - Upload Surat Rekomendasi
        </h5>
    </div>
    <div class="card-body">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($lks->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover" id="lksTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama LKS</th>
                            <th>Tanda Pendaftaran</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Kelengkapan</th>
                            <th>Surat Rekomendasi</th>
                            <th>Nama Verifikator</th>
                            <th>ID Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $lks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lksItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-status="<?php echo e($lksItem->status_permohonan); ?>"
                                data-name="<?php echo e(strtolower($lksItem->nama_lks)); ?>"
                                data-sertifikat="<?php echo e($lksItem->sertifikat_path ? 'ada' : 'tidak'); ?>">
                                <td><?php echo e($lks->firstItem() + $index); ?></td>
                                <td><?php echo e($lksItem->nama_lks); ?></td>
                                <td>
                                    <span class="badge <?php echo e($lksItem->tanda_pendaftaran == 'Baru' ? 'bg-success' : 'bg-info'); ?>">
                                        <?php echo e($lksItem->tanda_pendaftaran); ?>

                                    </span>
                                </td>
                                <td><?php echo e(\Carbon\Carbon::parse($lksItem->tanggal_masuk_dokumen)->format('d/m/Y')); ?></td>
                                <td>
                                    <span class="badge <?php echo e($lksItem->status_badge); ?>">
                                        <?php echo e($lksItem->status_permohonan); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($lksItem->pendaftaran_lengkap ? 'bg-success' : 'bg-warning'); ?>">
                                        <?php echo e($lksItem->pendaftaran_lengkap ? 'Lengkap' : 'Tidak Lengkap'); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($lksItem->surat_rekomendasi_path): ?>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?php echo e(route('admin.verification.download-sertifikat', $lksItem->id)); ?>"
                                               class="btn btn-outline-success"
                                               title="Download Surat Rekomendasi"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.verification.preview-sertifikat', $lksItem->id)); ?>"
                                               class="btn btn-outline-info"
                                               title="Preview Surat Rekomendasi"
                                               target="_blank"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.verification.delete-sertifikat', $lksItem->id)); ?>"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat rekomendasi ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus Surat Rekomendasi">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-secondary" data-bs-toggle="tooltip" title="Belum ada surat rekomendasi">
                                            <i class="bi bi-file-earmark-pdf"></i> Tidak Ada
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($lksItem->nama_verifikator ?? '-'); ?></td>
                                <td><?php echo e($lksItem->verifikator_id ?? '-'); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?php echo e(route('admin.verification', $lksItem->id)); ?>" class="btn btn-primary" title="Upload Surat Rekomendasi">
                                            <i class="bi bi-upload"></i> Upload
                                        </a>
                                        <a href="<?php echo e(route('admin.edit', $lksItem->id)); ?>" class="btn btn-warning" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?php echo e($lks->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2">Belum ada data LKS yang terdaftar.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function applyFilters() {
    const sertifikatFilter = document.getElementById('sertifikatFilter').value;
    const rows = document.querySelectorAll('#lksTable tbody tr');

    rows.forEach(row => {
        const sertifikat = row.getAttribute('data-sertifikat');
        let showRow = true;

        // Filter by sertifikat
        if (sertifikatFilter && sertifikat !== sertifikatFilter) {
            showRow = false;
        }

        row.style.display = showRow ? '' : 'none';
    });
}

// Auto filter on input
document.getElementById('sertifikatFilter').addEventListener('change', applyFilters);

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

<style>
.btn-group .btn {
    margin-right: 2px;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
.table td {
    vertical-align: middle;
}
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/admin/index.blade.php ENDPATH**/ ?>