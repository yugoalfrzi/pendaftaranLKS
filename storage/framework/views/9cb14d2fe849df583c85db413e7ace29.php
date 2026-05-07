<?php $__env->startSection('title', 'Tambah Data Kewenangan Kabupaten/Kota'); ?>

<?php $__env->startPush('styles'); ?>
<style>
:root {
    --primary: #2c7be5;
    --primary-dark: #1a68d1;
    --secondary: #6e84a3;
    --success: #00d97e;
    --info: #39afd1;
    --warning: #f6c343;
    --danger: #e63757;
    --light: #f9fbfd;
    --dark: #12263f;
    --gradient-primary: linear-gradient(135deg, #2c7be5 0%, #1a68d1 100%);
    --gradient-success: linear-gradient(135deg, #00d97e 0%, #00b96b 100%);
    --gradient-warning: linear-gradient(135deg, #f6c343 0%, #f4b223 100%);
    --shadow-sm: 0 0.125rem 0.25rem rgba(18, 38, 63, 0.1);
    --shadow-md: 0 0.5rem 1rem rgba(18, 38, 63, 0.15);
    --shadow-lg: 0 1rem 2rem rgba(18, 38, 63, 0.2);
    --border-radius: 0.75rem;
    --border-radius-lg: 1rem;
}

.form-section {
    background: linear-gradient(135deg, #ffffff 0%, #f8fbfe 100%);
    border-radius: var(--border-radius-lg);
    padding: 2rem;
    margin-bottom: 2.5rem;
    border: 1px solid #e3ebf6;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.form-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--gradient-primary);
}

.form-section:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.form-section h6 {
    color: var(--primary);
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-section h6 i {
    font-size: 1.3rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.form-label {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control {
    border: 2px solid #e3ebf6;
    border-radius: var(--border-radius);
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fff;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
    background: #fff;
}

.form-control:hover {
    border-color: #b8c7e0;
}

.form-select {
    border: 2px solid #e3ebf6;
    border-radius: var(--border-radius);
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236e84a3' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}

.form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
}

.btn-primary {
    background: var(--gradient-primary);
    border: none;
    border-radius: var(--border-radius);
    padding: 0.75rem 2rem;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.btn-secondary {
    background: #fff;
    border: 2px solid #e3ebf6;
    color: var(--secondary);
    border-radius: var(--border-radius);
    padding: 0.75rem 2rem;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #f8fbfe;
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-1px);
}

.required {
    color: var(--danger);
    font-weight: 700;
}

.card {
    border: none;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-lg);
    background: #fff;
}

.card-header {
    background: var(--gradient-primary);
    border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0 !important;
    padding: 1.5rem 2rem;
    border: none;
}

.card-title {
    color: white;
    font-weight: 700;
    font-size: 1.3rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-body {
    padding: 2.5rem;
}

.table {
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    margin-bottom: 0;
}

.table th {
    background: var(--gradient-primary);
    color: white;
    font-weight: 600;
    padding: 1rem;
    border: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-color: #e3ebf6;
    background: #fff;
    transition: background-color 0.3s ease;
}

.table tbody tr:hover td {
    background: #f8fbfe;
}

.alert-danger {
    background: linear-gradient(135deg, #ffe6ea 0%, #ffd6dc 100%);
    border: none;
    border-radius: var(--border-radius);
    border-left: 4px solid var(--danger);
    color: var(--dark);
    box-shadow: var(--shadow-sm);
    padding: 1.25rem;
}

.section-divider {
    height: 2px;
    background: linear-gradient(90deg, transparent 0%, var(--primary) 50%, transparent 100%);
    margin: 2rem 0;
    opacity: 0.3;
}

.input-group-text {
    background: var(--gradient-primary);
    border: 2px solid #e3ebf6;
    border-right: none;
    color: white;
    font-weight: 600;
}

.badge-section {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--gradient-success);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-optional {
    background: var(--gradient-warning);
}

.progress-section {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: #e3ebf6;
    z-index: 9999;
}

.progress-bar {
    height: 100%;
    background: var(--gradient-primary);
    transition: width 0.3s ease;
    width: 0%;
}

.form-help {
    font-size: 0.8rem;
    color: var(--secondary);
    margin-top: 0.25rem;
}

.field-group {
    background: #f8fbfe;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e3ebf6;
}

.field-group-title {
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 1rem;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Dropdown Search Styles */
.search-box {
    position: relative;
}

.search-box .bi-search {
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    color: #6c757d;
}

.search-box input {
    padding-left: 30px;
}

.checkbox-container {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    padding: 10px;
    background-color: #f8f9fa;
}

.checkbox-item {
    margin-bottom: 5px;
}

.checkbox-item:last-child {
    margin-bottom: 0;
}

.selected-items {
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    background-color: #e9ecef;
}

.action-buttons {
    margin-top: 10px;
}

.btn-action {
    min-width: 120px;
}

.btn-select-all {
    background-color: #198754;
    color: white;
}

.btn-select-all:hover {
    background-color: #157347;
    color: white;
}

.selected-item {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 5px 10px;
    margin-bottom: 5px;
    background: white;
    border-radius: 4px;
    border: 1px solid #dee2e6;
}

.remove-btn {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    cursor: pointer;
}

@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-section {
    animation: fadeInUp 0.5s ease-out;
}

.form-section:nth-child(even) {
    animation-delay: 0.1s;
}

.form-section:nth-child(odd) {
    animation-delay: 0.2s;
}

/* Custom checkbox and radio */
.form-check-input:checked {
    background-color: var(--primary);
    border-color: var(--primary);
}

.form-check-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="progress-section">
    <div class="progress-bar" id="formProgress"></div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-building-add"></i> Tambah Data Kewenangan Kabupaten/Kota
                </h5>
            </div>
            <div class="card-body">
                
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <strong class="me-2">Perhatian!</strong> Terdapat kesalahan dalam pengisian form.
                        </div>
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form action="<?php echo e(route('kewenangan-kabkota.store')); ?>" method="POST" id="mainForm">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Identitas Yayasan -->
                    <div class="form-section">
                        <h6><i class="bi bi-building"></i> IDENTITAS YAYASAN</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lembaga/Yayasan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="Nama_Lembaga_Yayasan" rows="3" required placeholder="Masukkan nama lengkap lembaga/yayasan"><?php echo e(old('Nama_Lembaga_Yayasan')); ?></textarea>
                                    <?php $__errorArgs = ['Nama_Lembaga_Yayasan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="pusat" <?php echo e(old('status') == 'pusat' ? 'selected' : ''); ?>>Pusat</option>
                                        <option value="cabang" <?php echo e(old('status') == 'cabang' ? 'selected' : ''); ?>>Cabang</option>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                    <select class="form-select" name="kabupaten_kota" required>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        <option value="Kabupaten Bogor" <?php echo e(old('kabupaten_kota') == 'Kabupaten Bogor' ? 'selected' : ''); ?>>Kabupaten Bogor</option>
                                        <option value="Kabupaten Sukabumi" <?php echo e(old('kabupaten_kota') == 'Kabupaten Sukabumi' ? 'selected' : ''); ?>>Kabupaten Sukabumi</option>
                                        <option value="Kabupaten Cianjur" <?php echo e(old('kabupaten_kota') == 'Kabupaten Cianjur' ? 'selected' : ''); ?>>Kabupaten Cianjur</option>
                                        <option value="Kabupaten Bandung" <?php echo e(old('kabupaten_kota') == 'Kabupaten Bandung' ? 'selected' : ''); ?>>Kabupaten Bandung</option>
                                        <option value="Kabupaten Garut" <?php echo e(old('kabupaten_kota') == 'Kabupaten Garut' ? 'selected' : ''); ?>>Kabupaten Garut</option>
                                        <option value="Kabupaten Tasikmalaya" <?php echo e(old('kabupaten_kota') == 'Kabupaten Tasikmalaya' ? 'selected' : ''); ?>>Kabupaten Tasikmalaya</option>
                                        <option value="Kabupaten Ciamis" <?php echo e(old('kabupaten_kota') == 'Kabupaten Ciamis' ? 'selected' : ''); ?>>Kabupaten Ciamis</option>
                                        <option value="Kabupaten Kuningan" <?php echo e(old('kabupaten_kota') == 'Kabupaten Kuningan' ? 'selected' : ''); ?>>Kabupaten Kuningan</option>
                                        <option value="Kabupaten Cirebon" <?php echo e(old('kabupaten_kota') == 'Kabupaten Cirebon' ? 'selected' : ''); ?>>Kabupaten Cirebon</option>
                                        <option value="Kabupaten Majalengka" <?php echo e(old('kabupaten_kota') == 'Kabupaten Majalengka' ? 'selected' : ''); ?>>Kabupaten Majalengka</option>
                                        <option value="Kabupaten Sumedang" <?php echo e(old('kabupaten_kota') == 'Kabupaten Sumedang' ? 'selected' : ''); ?>>Kabupaten Sumedang</option>
                                        <option value="Kabupaten Indramayu" <?php echo e(old('kabupaten_kota') == 'Kabupaten Indramayu' ? 'selected' : ''); ?>>Kabupaten Indramayu</option>
                                        <option value="Kabupaten Subang" <?php echo e(old('kabupaten_kota') == 'Kabupaten Subang' ? 'selected' : ''); ?>>Kabupaten Subang</option>
                                        <option value="Kabupaten Purwakarta" <?php echo e(old('kabupaten_kota') == 'Kabupaten Purwakarta' ? 'selected' : ''); ?>>Kabupaten Purwakarta</option>
                                        <option value="Kabupaten Karawang" <?php echo e(old('kabupaten_kota') == 'Kabupaten Karawang' ? 'selected' : ''); ?>>Kabupaten Karawang</option>
                                        <option value="Kabupaten Bekasi" <?php echo e(old('kabupaten_kota') == 'Kabupaten Bekasi' ? 'selected' : ''); ?>>Kabupaten Bekasi</option>
                                        <option value="Kabupaten Bandung Barat" <?php echo e(old('kabupaten_kota') == 'Kabupaten Bandung Barat' ? 'selected' : ''); ?>>Kabupaten Bandung Barat</option>
                                        <option value="Kabupaten Pangandaran" <?php echo e(old('kabupaten_kota') == 'Kabupaten Pangandaran' ? 'selected' : ''); ?>>Kabupaten Pangandaran</option>
                                        <option value="Kota Bogor" <?php echo e(old('kabupaten_kota') == 'Kota Bogor' ? 'selected' : ''); ?>>Kota Bogor</option>
                                        <option value="Kota Sukabumi" <?php echo e(old('kabupaten_kota') == 'Kota Sukabumi' ? 'selected' : ''); ?>>Kota Sukabumi</option>
                                        <option value="Kota Bandung" <?php echo e(old('kabupaten_kota') == 'Kota Bandung' ? 'selected' : ''); ?>>Kota Bandung</option>
                                        <option value="Kota Cirebon" <?php echo e(old('kabupaten_kota') == 'Kota Cirebon' ? 'selected' : ''); ?>>Kota Cirebon</option>
                                        <option value="Kota Bekasi" <?php echo e(old('kabupaten_kota') == 'Kota Bekasi' ? 'selected' : ''); ?>>Kota Bekasi</option>
                                        <option value="Kota Depok" <?php echo e(old('kabupaten_kota') == 'Kota Depok' ? 'selected' : ''); ?>>Kota Depok</option>
                                        <option value="Kota Cimahi" <?php echo e(old('kabupaten_kota') == 'Kota Cimahi' ? 'selected' : ''); ?>>Kota Cimahi</option>
                                        <option value="Kota Tasikmalaya" <?php echo e(old('kabupaten_kota') == 'Kota Tasikmalaya' ? 'selected' : ''); ?>>Kota Tasikmalaya</option>
                                        <option value="Kota Banjar" <?php echo e(old('kabupaten_kota') == 'Kota Banjar' ? 'selected' : ''); ?>>Kota Banjar</option>
                                    </select>
                                    <?php $__errorArgs = ['kabupaten_kota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ketua Yayasan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ketua_yayasan" value="<?php echo e(old('ketua_yayasan')); ?>" required placeholder="Masukkan nama ketua yayasan">
                                    <?php $__errorArgs = ['ketua_yayasan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No. Telepon<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="no" value="<?php echo e(old('no')); ?>" placeholder="Masukkan nomor telepon">
                                    <?php $__errorArgs = ['no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap"><?php echo e(old('alamat')); ?></textarea>
                                    <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Identitas LKS -->
                    <div class="form-section">
                        <h6><i class="bi bi-house-gear"></i> IDENTITAS LKS</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama LKS <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="nama_lks" rows="3" required placeholder="Masukkan nama lengkap LKS"><?php echo e(old('nama_lks')); ?></textarea>
                                    <?php $__errorArgs = ['nama_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pusat/Cabang <span class="text-danger">*</span></label>
                                    <select class="form-select" name="pusat_cabang" id="pusat_cabang" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Pusat" <?php echo e(old('pusat_cabang') == 'pusat' ? 'selected' : ''); ?>>Pusat</option>
                                        <option value="Cabang" <?php echo e(old('pusat_cabang') == 'cabang' ? 'selected' : ''); ?>>Cabang</option>
                                    </select>                                    
                                    <?php $__errorArgs = ['pusat_cabang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kabupaten/Kota LKS <span class="text-danger">*</span></label>
                                    <select class="form-select" name="kabupaten_kota_lks" required>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        <option value="Kabupaten Bogor" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Bogor' ? 'selected' : ''); ?>>Kabupaten Bogor</option>
                                        <option value="Kabupaten Sukabumi" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Sukabumi' ? 'selected' : ''); ?>>Kabupaten Sukabumi</option>
                                        <option value="Kabupaten Cianjur" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Cianjur' ? 'selected' : ''); ?>>Kabupaten Cianjur</option>
                                        <option value="Kabupaten Bandung" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Bandung' ? 'selected' : ''); ?>>Kabupaten Bandung</option>
                                        <option value="Kabupaten Garut" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Garut' ? 'selected' : ''); ?>>Kabupaten Garut</option>
                                        <option value="Kabupaten Tasikmalaya" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Tasikmalaya' ? 'selected' : ''); ?>>Kabupaten Tasikmalaya</option>
                                        <option value="Kabupaten Ciamis" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Ciamis' ? 'selected' : ''); ?>>Kabupaten Ciamis</option>
                                        <option value="Kabupaten Kuningan" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Kuningan' ? 'selected' : ''); ?>>Kabupaten Kuningan</option>
                                        <option value="Kabupaten Cirebon" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Cirebon' ? 'selected' : ''); ?>>Kabupaten Cirebon</option>
                                        <option value="Kabupaten Majalengka" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Majalengka' ? 'selected' : ''); ?>>Kabupaten Majalengka</option>
                                        <option value="Kabupaten Sumedang" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Sumedang' ? 'selected' : ''); ?>>Kabupaten Sumedang</option>
                                        <option value="Kabupaten Indramayu" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Indramayu' ? 'selected' : ''); ?>>Kabupaten Indramayu</option>
                                        <option value="Kabupaten Subang" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Subang' ? 'selected' : ''); ?>>Kabupaten Subang</option>
                                        <option value="Kabupaten Purwakarta" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Purwakarta' ? 'selected' : ''); ?>>Kabupaten Purwakarta</option>
                                        <option value="Kabupaten Karawang" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Karawang' ? 'selected' : ''); ?>>Kabupaten Karawang</option>
                                        <option value="Kabupaten Bekasi" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Bekasi' ? 'selected' : ''); ?>>Kabupaten Bekasi</option>
                                        <option value="Kabupaten Bandung Barat" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Bandung Barat' ? 'selected' : ''); ?>>Kabupaten Bandung Barat</option>
                                        <option value="Kabupaten Pangandaran" <?php echo e(old('kabupaten_kota_lks') == 'Kabupaten Pangandaran' ? 'selected' : ''); ?>>Kabupaten Pangandaran</option>
                                        <option value="Kota Bogor" <?php echo e(old('kabupaten_kota_lks') == 'Kota Bogor' ? 'selected' : ''); ?>>Kota Bogor</option>
                                        <option value="Kota Sukabumi" <?php echo e(old('kabupaten_kota_lks') == 'Kota Sukabumi' ? 'selected' : ''); ?>>Kota Sukabumi</option>
                                        <option value="Kota Bandung" <?php echo e(old('kabupaten_kota_lks') == 'Kota Bandung' ? 'selected' : ''); ?>>Kota Bandung</option>
                                        <option value="Kota Cirebon" <?php echo e(old('kabupaten_kota_lks') == 'Kota Cirebon' ? 'selected' : ''); ?>>Kota Cirebon</option>
                                        <option value="Kota Bekasi" <?php echo e(old('kabupaten_kota_lks') == 'Kota Bekasi' ? 'selected' : ''); ?>>Kota Bekasi</option>
                                        <option value="Kota Depok" <?php echo e(old('kabupaten_kota_lks') == 'Kota Depok' ? 'selected' : ''); ?>>Kota Depok</option>
                                        <option value="Kota Cimahi" <?php echo e(old('kabupaten_kota_lks') == 'Kota Cimahi' ? 'selected' : ''); ?>>Kota Cimahi</option>
                                        <option value="Kota Tasikmalaya" <?php echo e(old('kabupaten_kota_lks') == 'Kota Tasikmalaya' ? 'selected' : ''); ?>>Kota Tasikmalaya</option>
                                        <option value="Kota Banjar" <?php echo e(old('kabupaten_kota_lks') == 'Kota Banjar' ? 'selected' : ''); ?>>Kota Banjar</option>
                                    </select>
                                    <?php $__errorArgs = ['kabupaten_kota_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat LKS <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="alamat_lks" rows="3" required placeholder="Masukkan alamat lengkap LKS"><?php echo e(old('alamat_lks')); ?></textarea>
                                    <?php $__errorArgs = ['alamat_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kepengurusan LKS -->
                    <div class="form-section">
                        <h6><i class="bi bi-people"></i> KEPENGURUSAN LKS</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Nama Ketua LKS <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_ketua_lks" value="<?php echo e(old('nama_ketua_lks')); ?>" required placeholder="Masukkan nama ketua LKS">
                                    <?php $__errorArgs = ['nama_ketua_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Nama Sekretaris <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_sekretaris" value="<?php echo e(old('nama_sekretaris')); ?>" required placeholder="Masukkan nama sekretaris">
                                    <?php $__errorArgs = ['nama_sekretaris'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Nama Bendahara <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_bendahara" value="<?php echo e(old('nama_bendahara')); ?>" required placeholder="Masukkan nama bendahara">
                                    <?php $__errorArgs = ['nama_bendahara'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Akta Pendirian Yayasan -->
                    <div class="form-section">
                        <h6><i class="bi bi-file-text"></i> AKTA PENDIRIAN YAYASAN</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Notaris <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="nama_notaris" rows="2" required placeholder="Masukkan nama notaris"><?php echo e(old('nama_notaris')); ?></textarea>
                                    <?php $__errorArgs = ['nama_notaris'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Notaris <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor_notaris" value="<?php echo e(old('nomor_notaris')); ?>" required placeholder="Masukkan nomor notaris">
                                    <?php $__errorArgs = ['nomor_notaris'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Akta <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_akta" value="<?php echo e(old('tanggal_akta')); ?>" required>
                                    <?php $__errorArgs = ['tanggal_akta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengesahan Pendirian Yayasan -->
                    <div class="form-section">
                        <h6><i class="bi bi-check-circle"></i> PENGESAHAN PENDIRIAN YAYASAN</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Pengesahan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor_pengesahan" value="<?php echo e(old('nomor_pengesahan')); ?>" required placeholder="Masukkan nomor pengesahan">
                                    <?php $__errorArgs = ['nomor_pengesahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengesahan <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_pengesahan" value="<?php echo e(old('tanggal_pengesahan')); ?>" required>
                                    <?php $__errorArgs = ['tanggal_pengesahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NPWP -->
                    <div class="form-section">
                        <h6><i class="bi bi-receipt"></i> NPWP</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama NPWP <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="nama_npwp" rows="2" required placeholder="Masukkan nama NPWP"><?php echo e(old('nama_npwp')); ?></textarea>
                                    <?php $__errorArgs = ['nama_npwp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor NPWP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor_npwp" value="<?php echo e(old('nomor_npwp')); ?>" required placeholder="Masukkan nomor NPWP">
                                    <?php $__errorArgs = ['nomor_npwp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Bangunan & Akreditasi -->
                    <div class="form-section">
                        <h6><i class="bi bi-building"></i> STATUS BANGUNAN & AKREDITASI</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status Bangunan <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status_bangunan" required>
                                        <option value="">Pilih Status Bangunan</option>
                                        <option value="milik_sendiri" <?php echo e(old('status_bangunan') == 'milik_sendiri' ? 'selected' : ''); ?>>Milik Sendiri</option>
                                        <option value="sewa/kontrak" <?php echo e(old('status_bangunan') == 'sewa/kontrak' ? 'selected' : ''); ?>>Sewa/Kontrak</option>
                                        <option value="wakaf" <?php echo e(old('status_bangunan') == 'wakaf' ? 'selected' : ''); ?>>Wakaf</option>
                                    </select>
                                    <?php $__errorArgs = ['status_bangunan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Akreditasi <span class="text-danger">*</span></label>
                                    <select class="form-select" name="akreditasi" required>
                                        <option value="">Pilih Akreditasi</option>
                                        <option value="a" <?php echo e(old('akreditasi') == 'a' ? 'selected' : ''); ?>>A</option>
                                        <option value="b" <?php echo e(old('akreditasi') == 'b' ? 'selected' : ''); ?>>B</option>
                                        <option value="c" <?php echo e(old('akreditasi') == 'c' ? 'selected' : ''); ?>>C</option>
                                        <option value="tidak_terakreditasi" <?php echo e(old('akreditasi') == 'tidak_terakreditasi' ? 'selected' : ''); ?>>Tidak Terakreditasi</option>
                                    </select>
                                    <?php $__errorArgs = ['akreditasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanda Daftar Kabupaten/Kota -->
                    <div class="form-section">
                        <h6><i class="bi bi-file-earmark-check"></i> TANDA DAFTAR KABUPATEN/KOTA</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Tanda Daftar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor_tandaDaftar" value="<?php echo e(old('nomor_tandaDaftar')); ?>" required placeholder="Masukkan nomor tanda daftar">
                                    <?php $__errorArgs = ['nomor_tandaDaftar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Tanda Daftar <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_tandaDaftar" value="<?php echo e(old('tanggal_tandaDaftar')); ?>" required>
                                    <?php $__errorArgs = ['tanggal_tandaDaftar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Pelayanan PPKS dengan Checkbox -->
                    <div class="form-section">
                        <h6><i class="bi bi-heart-pulse"></i> JENIS PELAYANAN PPKS</h6>
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Jenis Pelayanan PPKS <span class="text-danger">*</span></label>
                                <input type="hidden" id="jenis_pelayanan_PPKS" name="jenis_pelayanan_PPKS" value="<?php echo e(old('jenis_pelayanan_PPKS')); ?>">
                                
                                <div class="search-box mb-3">
                                    <i class="bi bi-search"></i>
                                    <input type="text" id="searchJenisPelayanan" class="form-control" placeholder="Ketik untuk mencari jenis pelayanan...">
                                </div>
                                
                                <div class="checkbox-container" id="jenisPelayananList">
                                    <?php
                                    $jenisPelayanan = [
                                        'Anak balita terlantar',
                                        'Anak terlantar',
                                        'Anak yang berhadapan dengan hukum',
                                        'Anak jalanan',
                                        'Anak dengan kedisabilitasan (ADK)',
                                        'Anak menjadi korban tindak kekerasan',
                                        'Anak yang memerlukan perlindungan khusus',
                                        'Lansia',
                                        'Penyandang disabilitas',
                                        'Tuna Susila',
                                        'Gelandangan',
                                        'Pengemis',
                                        'Pemulung',
                                        'Kelompok minoritas',
                                        'Bekas warga binaan Lembaga Permasyarakatan (BWBLP)',
                                        'Orang dengan HIV/AIDS',
                                        'Korban penyalahgunaan NAPZA (Narkotika, Psikotropika, dan Zat Adiktif)',
                                        'Korban trafficking',
                                        'Korban tindak kekerasan',
                                        'Pekerja migran bermasalah sosial (PMBS)',
                                        'Korban bencana alam',
                                        'Korban bencana sosial',
                                        'Perempuan rawan sosial ekonomi',
                                        'Fakir miskin',
                                        'Keluarga bermasalah sosial psikologis',
                                        'Komunitas adat terpencil',
                                    ];
                                    $selectedPelayanan = collect(explode(',', old('jenis_pelayanan_PPKS')))->map(fn($v) => trim($v));
                                    ?>
                                    <?php $__currentLoopData = $jenisPelayanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $pelayanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="checkbox-item">
                                        <div class="form-check">
                                            <input class="form-check-input jenis-pelayanan-checkbox" type="checkbox" value="<?php echo e($pelayanan); ?>" id="jp_<?php echo e($idx); ?>" <?php echo e($selectedPelayanan->contains($pelayanan) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="jp_<?php echo e($idx); ?>"><?php echo e($pelayanan); ?></label>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <div class="d-flex justify-content-between mb-4 action-buttons">
                                    <button type="button" class="btn btn-select-all" id="selectAllJenisPelayanan">
                                        <i class="bi bi-check-all"></i> Pilih Semua
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-action" id="clearAllJenisPelayanan">
                                        <i class="bi bi-x-circle"></i> Hapus Semua
                                    </button>
                                </div>
                            
                                <div class="selected-items" id="selectedJenisPelayanan">
                                    <?php if($selectedPelayanan->count() > 0): ?>
                                        <?php $__currentLoopData = $selectedPelayanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selected): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($selected): ?>
                                            <div class="selected-item">
                                                <?php echo e($selected); ?>

                                                <button type="button" class="remove-btn" data-value="<?php echo e($selected); ?>">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="text-muted">Belum ada pilihan. Silakan pilih dari daftar di atas.</div>
                                    <?php endif; ?>
                                </div>

                                <?php $__errorArgs = ['jenis_pelayanan_PPKS'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Warga Binaan -->
                    <div class="form-section">
                        <h6><i class="bi bi-people-fill"></i> JUMLAH WARGA BINAAN</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Seluruh Binaan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="jumlah_seluruh_binaan" value="<?php echo e(old('jumlah_seluruh_binaan', 0)); ?>" min="0" required>
                                    <?php $__errorArgs = ['jumlah_seluruh_binaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Dalam Panti <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="jumlah_dalam_panti" value="<?php echo e(old('jumlah_dalam_panti', 0)); ?>" min="0" required>
                                    <?php $__errorArgs = ['jumlah_dalam_panti'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Luar Panti <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="jumlah_luar_panti" value="<?php echo e(old('jumlah_luar_panti', 0)); ?>" min="0" required>
                                    <?php $__errorArgs = ['jumlah_luar_panti'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data PPKS -->
                    <div class="form-section">
                        <h6><i class="bi bi-person-lines-fill"></i> DATA PPKS</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40%">Jenis PPKS</th>
                                        <th width="30%">Dalam Panti</th>
                                        <th width="30%">Luar Panti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $ppksFields = [
                                            'anak_balita_terlantar' => 'Anak Balita Terlantar',
                                            'anak_terlantar' => 'Anak Terlantar',
                                            'anak_yangberhadapan_dengan_hukum' => 'Anak yang Berhadapan dengan Hukum',
                                            'anak_jalanan' => 'Anak Jalanan',
                                            'anak_dengan_kedisabilitas' => 'Anak dengan Kedisabilitas',
                                            'anak_yangmenjadi_tidak_kekerasan' => 'Anak yang Menjadi Tidak Kekerasan',
                                            'anak_yang_memerlukan_perlindungan_khusus' => 'Anak yang Memerlukan Perlindungan Khusus',
                                            'lanjut_usia_terlantar' => 'Lanjut Usia Terlantar',
                                            'disabilitas_fisik' => 'Disabilitas Fisik',
                                            'disabilitas_intelektual' => 'Disabilitas Intelektual',
                                            'disabilitas_mental' => 'Disabilitas Mental',
                                            'disabilitas_sensorik' => 'Disabilitas Sensorik',
                                            'tuna_susila' => 'Tuna Susila',
                                            'gelandangan' => 'Gelandangan',
                                            'pengemis' => 'Pengemis',
                                            'pemulung' => 'Pemulung',
                                            'kelompok_minoritas' => 'Kelompok Minoritas',
                                            'BWBLP' => 'BWBLP',
                                            'orang_dengan_hiv_aids' => 'Orang dengan HIV/AIDS',
                                            'penyalahgunaan_Napza' => 'Penyalahgunaan Napza',
                                            'korban_Trafficking' => 'Korban Trafficking',
                                            'korban_tindak_kekerasan' => 'Korban Tindak Kekerasan',
                                            'PMBS' => 'PMBS',
                                            'korban_bencana_alam' => 'Korban Bencana Alam',
                                            'korban_bencana_sosial' => 'Korban Bencana Sosial',
                                            'perempuan_rawan_sosial_ekonomi' => 'Perempuan Rawan Sosial Ekonomi',
                                            'fakir_miskin' => 'Fakir Miskin',
                                            'keluarga_bermasalah_sosial_psikologis' => 'Keluarga Bermasalah Sosial Psikologis',
                                            'komunitas_adat_terpencil' => 'Komunitas Adat Terpencil'
                                        ];
                                    ?>
                                    <?php $__currentLoopData = $ppksFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($label); ?></td>
                                        <td>
                                            <input type="number" class="form-control" name="<?php echo e($field); ?>_DP" value="<?php echo e(old($field.'_DP', 0)); ?>" min="0" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="<?php echo e($field); ?>_LP" value="<?php echo e(old($field.'_LP', 0)); ?>" min="0" required>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="form-section">
                        <h6><i class="bi bi-telephone"></i> KONTAK</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor_tlp" value="<?php echo e(old('nomor_tlp')); ?>" required placeholder="Masukkan nomor telepon">
                                    <?php $__errorArgs = ['nomor_tlp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required placeholder="Masukkan alamat email">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Link Tanda Daftar <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control" name="link_tanda_daftar" value="<?php echo e(old('link_tanda_daftar')); ?>" placeholder="Masukkan link tanda daftar (opsional)">
                                    <?php $__errorArgs = ['link_tanda_daftar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></small></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-section text-center bg-light">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="<?php echo e(route('kewenangan-kabkota.index')); ?>" class="btn btn-secondary btn-lg me-md-2">
                                        <i class="bi bi-arrow-left-circle me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle me-2"></i>Simpan Data
                                    </button>
                                </div>
                                <p class="text-muted mt-3 mb-0">
                                    <small><i class="bi bi-info-circle me-1"></i>Pastikan semua data yang wajib diisi telah terisi dengan benar</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Progress bar calculation
function updateProgressBar() {
    const form = document.getElementById('mainForm');
    const totalFields = form.querySelectorAll('input[required], select[required], textarea[required]').length;
    const filledFields = form.querySelectorAll('input[required]:valid, select[required]:valid, textarea[required]:valid').length;
    
    if (totalFields > 0) {
        const progress = (filledFields / totalFields) * 100;
        document.getElementById('formProgress').style.width = progress + '%';
    }
}

// Add event listeners to all required fields
document.addEventListener('DOMContentLoaded', function() {
    const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('input', updateProgressBar);
        field.addEventListener('change', updateProgressBar);
    });
    
    // Initial progress calculation
    updateProgressBar();
});

// Form submission animation
document.getElementById('mainForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Re-enable button after 5 seconds (safety measure)
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }, 5000);
});

// Add smooth scrolling to form sections
document.querySelectorAll('.form-section h6').forEach(header => {
    header.style.cursor = 'pointer';
    header.addEventListener('click', function() {
        this.closest('.form-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});

// ========== JENIS PELAYANAN PPKS FUNCTIONALITY ==========
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.jenis-pelayanan-checkbox');
    const hiddenInput = document.getElementById('jenis_pelayanan_PPKS');
    const selectAllBtn = document.getElementById('selectAllJenisPelayanan');
    const clearAllBtn = document.getElementById('clearAllJenisPelayanan');
    const searchInput = document.getElementById('searchJenisPelayanan');

    // Function utama untuk update data
    function updateSelectedData() {
        const selectedValues = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedValues.push(checkbox.value);
            }
        });
        
        // PASTIKAN: Update hidden input dengan data yang dipilih
        hiddenInput.value = selectedValues.join(',');
    }

    // Event untuk setiap checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedData);
    });

    // Select All
    selectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => checkbox.checked = true);
        updateSelectedData();
    });

    // Clear All  
    clearAllBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => checkbox.checked = false);
        updateSelectedData();
    });

    // Search
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        checkboxes.forEach(checkbox => {
            const label = checkbox.closest('.checkbox-item');
            if (checkbox.value.toLowerCase().includes(searchTerm)) {
                label.style.display = 'block';
            } else {
                label.style.display = 'none';
            }
        });
    });

    // PASTIKAN: Update data sebelum form submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        updateSelectedData(); // Update terakhir sebelum kirim data
        
        // Validasi client-side
        if (hiddenInput.value === '') {
            alert('Pilih minimal satu jenis pelayanan PPKS');
            return false;
        }
    });

    // Inisialisasi pertama
    updateSelectedData();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/kewenangan/kabkota/create.blade.php ENDPATH**/ ?>