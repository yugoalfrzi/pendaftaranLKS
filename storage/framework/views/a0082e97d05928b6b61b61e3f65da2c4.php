

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Tambah Data Hibah LKS</h4>
        <a href="<?php echo e(route('hibah.index')); ?>" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('hibah.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Nama LKS</label>
                    <input type="text" name="nama_lks" class="form-control" value="<?php echo e(old('nama_lks')); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="<?php echo e(old('tahun', now()->year)); ?>" min="2023" max="2100">
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Proposal (PDF)</label>
                        <input type="file" name="proposal" class="form-control" accept="*">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">LPJ (PDF)</label>
                        <input type="file" name="lpj" class="form-control" accept="*">
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/hibah/create.blade.php ENDPATH**/ ?>