

<?php $__env->startSection('title', 'Persetujuan Akun Pengguna'); ?>
<?php $__env->startSection('page-title', 'Persetujuan Akun'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-person-check"></i> Persetujuan Akun Pengguna</h1>
    <a href="<?php echo e(route('superadmin.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center gap-2">
        <i class="bi bi-clock-history text-warning fs-5"></i>
        <h5 class="mb-0">Akun Menunggu Persetujuan</h5>
        <span class="badge bg-warning text-dark ms-1"><?php echo e($pendingUsers->count()); ?></span>
    </div>
    <div class="card-body p-0">
        <?php if($pendingUsers->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Metode Daftar</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pendingUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="ps-3"><?php echo e($index + 1); ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <?php if($user->avatar): ?>
                                    <img src="<?php echo e($user->avatar); ?>" class="rounded-circle" width="32" height="32" alt="">
                                <?php else: ?>
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                         style="width:32px;height:32px;font-size:0.8rem;font-weight:700;">
                                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                    </div>
                                <?php endif; ?>
                                <strong><?php echo e($user->name); ?></strong>
                            </div>
                        </td>
                        <td><?php echo e($user->email); ?></td>
                        <td>
                            <?php if($user->google_id): ?>
                                <span class="badge bg-light text-dark border">
                                    <svg width="14" height="14" viewBox="0 0 48 48" class="me-1">
                                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.36-8.16 2.36-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                    </svg>
                                    Google
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Email</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($user->created_at->format('d/m/Y H:i')); ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                
                                <form action="<?php echo e(route('users.approve', $user->id)); ?>" method="POST"
                                      onsubmit="return confirm('Setujui akun <?php echo e($user->name); ?>?')">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle"></i> Setujui
                                    </button>
                                </form>

                                
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#rejectModal<?php echo e($user->id); ?>">
                                    <i class="bi bi-x-circle"></i> Tolak
                                </button>
                            </div>

                            
                            <div class="modal fade" id="rejectModal<?php echo e($user->id); ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?php echo e(route('users.reject', $user->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tolak Akun: <?php echo e($user->name); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label class="form-label fw-bold">Alasan Penolakan <small class="text-muted">(opsional)</small></label>
                                                <textarea name="reason" class="form-control" rows="3"
                                                          placeholder="Masukkan alasan penolakan yang akan dikirim ke email pengguna..."></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle"></i> Tolak Akun
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-check-circle fs-1 text-success"></i>
            <p class="mt-2">Tidak ada akun yang menunggu persetujuan.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/superadmin/pending-users.blade.php ENDPATH**/ ?>