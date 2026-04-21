<?php $__env->startSection('title', 'Edit Data LKS'); ?>
<?php $__env->startSection('page-title', 'Edit LKS'); ?>

<?php $__env->startSection('content'); ?>
<style>
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
    .counter-badge {
        background-color: #0d6efd;
        color: white;
        border-radius: 50%;
        padding: 5px 10px;
        font-size: 0.9em;
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
    .custom-file-upload {
        border: 2px dashed #dee2e6;
        border-radius: 0.375rem;
        padding: 0.75rem;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }
    .file-input-wrapper {
        transition: all 0.3s ease;
    }
    .file-input-wrapper .input-group {
        gap: 0.25rem;
    }
    .file-list-container {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.75rem;
        background-color: #f8f9fa;
        font-size: 0.875rem;
    }
    .file-list-container .selected-files ul {
        margin-bottom: 0.5rem;
        padding-left: 0;
    }
    .file-list-container .selected-files li {
        padding: 0.5rem;
        border-bottom: 1px solid #e9ecef;
        background: white;
        border-radius: 0.25rem;
        margin-bottom: 0.25rem;
    }
    .file-list-container .selected-files li:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    .status-alert .alert {
        font-size: 0.875rem;
        margin-bottom: 0;
        padding: 0.5rem 0.75rem;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    /* Custom scrollbar for file list */
    .file-list-container::-webkit-scrollbar {
        width: 6px;
    }
    .file-list-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .file-list-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .file-list-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
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
    .required-label::after {
        content: " *";
        color: #dc3545;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil-square"></i> Edit Data LKS
            </h1>
            <a href="<?php echo e(route('lks.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-file-earmark-text"></i> Form Edit LKS
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('lks.update', $lks->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <!-- Informasi Umum -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-info-circle"></i> Informasi Umum
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nama_lks" class="form-label required-label">Nama LKS</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nama_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Nama Sesuai Akta Notaris"
                                   id="nama_lks" name="nama_lks" value="<?php echo e(old('nama_lks', $lks->nama_lks)); ?>" required>
                            <?php $__errorArgs = ['nama_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nama_ketua_lks" class="form-label required-label">Nama Ketua LKS</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nama_ketua_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="nama_ketua_lks" name="nama_ketua_lks" value="<?php echo e(old('nama_ketua_lks', $lks->nama_ketua_lks)); ?>" required>
                            <?php $__errorArgs = ['nama_ketua_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="alamat_lks" class="form-label required-label">Alamat LKS</label>
                            <textarea class="form-control <?php $__errorArgs = ['alamat_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      placeholder="Alamat Sesuai Surat Keterangan Domisili"  
                                      id="alamat_lks" name="alamat_lks" rows="3" required><?php echo e(old('alamat_lks', $lks->alamat_lks)); ?></textarea>
                            <?php $__errorArgs = ['alamat_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label required-label">Jenis Pelayanan</label>
                            <input type="hidden" id="jenis_pelayanan" name="jenis_pelayanan" value="<?php echo e(old('jenis_pelayanan', $lks->jenis_pelayanan)); ?>">
                            <div class="checkbox-container" id="jenisPelayananList">
                                <?php
                                $opsiPelayanan = [
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
                                $selected = collect(explode(',', old('jenis_pelayanan', $lks->jenis_pelayanan)))->map(fn($v) => trim($v));
                                ?>
                                <?php $__currentLoopData = $opsiPelayanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $opsi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input jenis-pelayanan-checkbox" type="checkbox" value="<?php echo e($opsi); ?>" id="jp_<?php echo e($idx); ?>" <?php echo e($selected->contains($opsi) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="jp_<?php echo e($idx); ?>"><?php echo e($opsi); ?></label>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['jenis_pelayanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">Centang satu atau lebih sesuai layanan.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jumlah_binaan_dalam_panti" class="form-label required-label">Jumlah Binaan Dalam Panti</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['jumlah_binaan_dalam_panti'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Jumlah Binaan"
                                   id="jumlah_binaan_dalam_panti" name="jumlah_binaan_dalam_panti" 
                                   value="<?php echo e(old('jumlah_binaan_dalam_panti', $lks->jumlah_binaan_dalam_panti)); ?>" min="0" required>
                            <?php $__errorArgs = ['jumlah_binaan_dalam_panti'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jumlah_binaan_luar_panti" class="form-label required-label">Jumlah Binaan Luar Panti</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['jumlah_binaan_luar_panti'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Jumlah Binaan"
                                   id="jumlah_binaan_luar_panti" name="jumlah_binaan_luar_panti" 
                                   value="<?php echo e(old('jumlah_binaan_luar_panti', $lks->jumlah_binaan_luar_panti)); ?>" min="0" required>
                            <?php $__errorArgs = ['jumlah_binaan_luar_panti'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nomor_kontak" class="form-label required-label">Nomor Kontak</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nomor_kontak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Nomor kontak aktif"
                                   id="nomor_kontak" name="nomor_kontak" value="<?php echo e(old('nomor_kontak', $lks->nomor_kontak)); ?>" required>
                            <?php $__errorArgs = ['nomor_kontak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="lokasi_lks" class="form-label required-label">Kabupaten/Kota</label>
                            <select class="form-select <?php $__errorArgs = ['lokasi_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="lokasi_lks" name="lokasi_lks" required>
                                <option value="">Pilih Kabupaten/Kota</option>
                                <option value="Kabupaten Bogor" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Bogor' ? 'selected' : ''); ?>>Kabupaten Bogor</option>
                                <option value="Kabupaten Sukabumi" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Sukabumi' ? 'selected' : ''); ?>>Kabupaten Sukabumi</option>
                                <option value="Kabupaten Cianjur" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Cianjur' ? 'selected' : ''); ?>>Kabupaten Cianjur</option>
                                <option value="Kabupaten Bandung" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Bandung' ? 'selected' : ''); ?>>Kabupaten Bandung</option>
                                <option value="Kabupaten Garut" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Garut' ? 'selected' : ''); ?>>Kabupaten Garut</option>
                                <option value="Kabupaten Tasikmalaya" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Tasikmalaya' ? 'selected' : ''); ?>>Kabupaten Tasikmalaya</option>
                                <option value="Kabupaten Ciamis" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Ciamis' ? 'selected' : ''); ?>>Kabupaten Ciamis</option>
                                <option value="Kabupaten Kuningan" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Kuningan' ? 'selected' : ''); ?>>Kabupaten Kuningan</option>
                                <option value="Kabupaten Cirebon" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Cirebon' ? 'selected' : ''); ?>>Kabupaten Cirebon</option>
                                <option value="Kabupaten Majalengka" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Majalengka' ? 'selected' : ''); ?>>Kabupaten Majalengka</option>
                                <option value="Kabupaten Sumedang" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Sumedang' ? 'selected' : ''); ?>>Kabupaten Sumedang</option>
                                <option value="Kabupaten Indramayu" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Indramayu' ? 'selected' : ''); ?>>Kabupaten Indramayu</option>
                                <option value="Kabupaten Subang" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Subang' ? 'selected' : ''); ?>>Kabupaten Subang</option>
                                <option value="Kabupaten Purwakarta" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Purwakarta' ? 'selected' : ''); ?>>Kabupaten Purwakarta</option>
                                <option value="Kabupaten Karawang" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Karawang' ? 'selected' : ''); ?>>Kabupaten Karawang</option>
                                <option value="Kabupaten Bekasi" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Bekasi' ? 'selected' : ''); ?>>Kabupaten Bekasi</option>
                                <option value="Kabupaten Bandung Barat" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Bandung Barat' ? 'selected' : ''); ?>>Kabupaten Bandung Barat</option>
                                <option value="Kabupaten Pangandaran" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Pangandaran' ? 'selected' : ''); ?>>Kabupaten Pangandaran</option>
                                <option value="Kota Bogor" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kota Bogor' ? 'selected' : ''); ?>>Kota Bogor</option>
                                <option value="Kota Sukabumi" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kota Sukabumi' ? 'selected' : ''); ?>>Kota Sukabumi</option>
                                <option value="Kota Bandung" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kota Bandung' ? 'selected' : ''); ?>>Kota Bandung</option>
                                <option value="Kota Cirebon" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kota Cirebon' ? 'selected' : ''); ?>>Kota Cirebon</option>
                                <option value="Kota Bekasi" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kota Bekasi' ? 'selected' : ''); ?>>Kota Bekasi</option>
                                <option value="Kota Depok" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kota Depok' ? 'selected' : ''); ?>>Kota Depok</option>
                                <option value="Kota Cimahi" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kota Cimahi' ? 'selected' : ''); ?>>Kota Cimahi</option>
                                <option value="Kota Tasikmalaya" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kota Tasikmalaya' ? 'selected' : ''); ?>>Kota Tasikmalaya</option>
                                <option value="Kota Banjar" <?php echo e(old('lokasi_lks', $lks->lokasi_lks) == 'Kota Banjar' ? 'selected' : ''); ?>>Kota Banjar</option>
                            </select>
                            <?php $__errorArgs = ['lokasi_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pusat_lks" class="form-label required-label">Pusat LKS</label>
                            <select class="form-select <?php $__errorArgs = ['pusat_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="pusat_lks" name="pusat_lks" required>
                                <option value="">Pilih Kabupaten/Kota</option>
                                <option value="Kabupaten Bogor" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Bogor' ? 'selected' : ''); ?>>Kabupaten Bogor</option>
                                <option value="Kabupaten Sukabumi" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Sukabumi' ? 'selected' : ''); ?>>Kabupaten Sukabumi</option>
                                <option value="Kabupaten Cianjur" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Cianjur' ? 'selected' : ''); ?>>Kabupaten Cianjur</option>
                                <option value="Kabupaten Bandung" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Bandung' ? 'selected' : ''); ?>>Kabupaten Bandung</option>
                                <option value="Kabupaten Garut" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Garut' ? 'selected' : ''); ?>>Kabupaten Garut</option>
                                <option value="Kabupaten Tasikmalaya" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Tasikmalaya' ? 'selected' : ''); ?>>Kabupaten Tasikmalaya</option>
                                <option value="Kabupaten Ciamis" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Ciamis' ? 'selected' : ''); ?>>Kabupaten Ciamis</option>
                                <option value="Kabupaten Kuningan" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Kuningan' ? 'selected' : ''); ?>>Kabupaten Kuningan</option>
                                <option value="Kabupaten Cirebon" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Cirebon' ? 'selected' : ''); ?>>Kabupaten Cirebon</option>
                                <option value="Kabupaten Majalengka" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Majalengka' ? 'selected' : ''); ?>>Kabupaten Majalengka</option>
                                <option value="Kabupaten Sumedang" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Sumedang' ? 'selected' : ''); ?>>Kabupaten Sumedang</option>
                                <option value="Kabupaten Indramayu" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Indramayu' ? 'selected' : ''); ?>>Kabupaten Indramayu</option>
                                <option value="Kabupaten Subang" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Subang' ? 'selected' : ''); ?>>Kabupaten Subang</option>
                                <option value="Kabupaten Purwakarta" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Purwakarta' ? 'selected' : ''); ?>>Kabupaten Purwakarta</option>
                                <option value="Kabupaten Karawang" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Karawang' ? 'selected' : ''); ?>>Kabupaten Karawang</option>
                                <option value="Kabupaten Bekasi" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Bekasi' ? 'selected' : ''); ?>>Kabupaten Bekasi</option>
                                <option value="Kabupaten Bandung Barat" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Bandung Barat' ? 'selected' : ''); ?>>Kabupaten Bandung Barat</option>
                                <option value="Kabupaten Pangandaran" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Pangandaran' ? 'selected' : ''); ?>>Kabupaten Pangandaran</option>
                                <option value="Kota Bogor" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kota Bogor' ? 'selected' : ''); ?>>Kota Bogor</option>
                                <option value="Kota Sukabumi" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kota Sukabumi' ? 'selected' : ''); ?>>Kota Sukabumi</option>
                                <option value="Kota Bandung" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kota Bandung' ? 'selected' : ''); ?>>Kota Bandung</option>
                                <option value="Kota Cirebon" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kota Cirebon' ? 'selected' : ''); ?>>Kota Cirebon</option>
                                <option value="Kota Bekasi" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kota Bekasi' ? 'selected' : ''); ?>>Kota Bekasi</option>
                                <option value="Kota Depok" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kota Depok' ? 'selected' : ''); ?>>Kota Depok</option>
                                <option value="Kota Cimahi" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kota Cimahi' ? 'selected' : ''); ?>>Kota Cimahi</option>
                                <option value="Kota Tasikmalaya" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kota Tasikmalaya' ? 'selected' : ''); ?>>Kota Tasikmalaya</option>
                                <option value="Kota Banjar" <?php echo e(old('pusat_lks', $lks->pusat_lks) == 'Kota Banjar' ? 'selected' : ''); ?>>Kota Banjar</option>
                            </select>
                            <?php $__errorArgs = ['pusat_lks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label required-label">Cabang LKS</label>
                            <input type="hidden" name="cabang_lks" id="cabang_lks_hidden" value="<?php echo e(old('cabang_lks', $lks->cabang_lks)); ?>">
                            <div class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" id="searchInput" class="form-control" placeholder="Ketik nama kabupaten/kota...">
                            </div>
                            <div class="checkbox-container" id="checkboxList">
                                <!-- Kabupaten Options -->
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Bogor" id="bogorKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Bogor') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="bogorKab">Kabupaten Bogor</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Sukabumi" id="sukabumiKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Sukabumi') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="sukabumiKab">Kabupaten Sukabumi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Cianjur" id="cianjurKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Cianjur') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="cianjurKab">Kabupaten Cianjur</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Bandung" id="bandungKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Bandung') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="bandungKab">Kabupaten Bandung</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Garut" id="garutKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Garut') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="garutKab">Kabupaten Garut</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Tasikmalaya" id="tasikmalayaKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Tasikmalaya') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="tasikmalayaKab">Kabupaten Tasikmalaya</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Ciamis" id="ciamisKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Ciamis') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="ciamisKab">Kabupaten Ciamis</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Kuningan" id="kuninganKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Kuningan') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="kuninganKab">Kabupaten Kuningan</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Cirebon" id="cirebonKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Cirebon') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="cirebonKab">Kabupaten Cirebon</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Majalengka" id="majalengkaKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Majalengka') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="majalengkaKab">Kabupaten Majalengka</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Sumedang" id="sumedangKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Sumedang') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="sumedangKab">Kabupaten Sumedang</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Indramayu" id="indramayuKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Indramayu') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="indramayuKab">Kabupaten Indramayu</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Subang" id="subangKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Subang') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="subangKab">Kabupaten Subang</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Purwakarta" id="purwakartaKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Purwakarta') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="purwakartaKab">Kabupaten Purwakarta</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Karawang" id="karawangKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Karawang') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="karawangKab">Kabupaten Karawang</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Bekasi" id="bekasiKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Bekasi') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="bekasiKab">Kabupaten Bekasi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Bandung Barat" id="bandungBaratKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Bandung Barat') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="bandungBaratKab">Kabupaten Bandung Barat</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Pangandaran" id="pangandaranKab" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Pangandaran') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="pangandaranKab">Kabupaten Pangandaran</label>
                                    </div>
                                </div>
                            
                                <!-- Kota Options -->
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Bogor" id="bogorKota" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Bogor') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="bogorKota">Kota Bogor</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Sukabumi" id="sukabumiKota" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Sukabumi') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="sukabumiKota">Kota Sukabumi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Bandung" id="bandungKota" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Bandung') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="bandungKota">Kota Bandung</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Cirebon" id="cirebonKota" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Cirebon') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="cirebonKota">Kota Cirebon</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Bekasi" id="bekasiKota" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Bekasi') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="bekasiKota">Kota Bekasi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Depok" id="depokKota" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Depok') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="depokKota">Kota Depok</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Cimahi" id="cimahiKota" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Cimahi') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="cimahiKota">Kota Cimahi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Tasikmalaya" id="tasikmalayaKota" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Tasikmalaya') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="tasikmalayaKota">Kota Tasikmalaya</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Banjar" id="banjarKota" <?php echo e(str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Banjar') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="banjarKota">Kota Banjar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-4 action-buttons">
                                <button type="button" class="btn btn-select-all" id="selectAllBtn">
                                    <i class="bi bi-check-all"></i> Pilih Semua
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-action" id="clearAllBtn">
                                    <i class="bi bi-x-circle"></i> Hapus Semua
                                </button>
                            </div>

                            <div class="selected-items" id="selectedItems">
                                <!-- Selected items will be displayed here -->
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanda_pendaftaran" class="form-label required-label">Tanda Pendaftaran</label>
                            <select class="form-select <?php $__errorArgs = ['tanda_pendaftaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="tanda_pendaftaran" name="tanda_pendaftaran" required>
                                <option value="">Pilih Tanda Pendaftaran</option>
                                <option value="Baru" <?php echo e(old('tanda_pendaftaran', $lks->tanda_pendaftaran) == 'Baru' ? 'selected' : ''); ?>>Baru</option>
                                <option value="Ulang" <?php echo e(old('tanda_pendaftaran', $lks->tanda_pendaftaran) == 'Ulang' ? 'selected' : ''); ?>>Ulang</option>
                            </select>
                            <?php $__errorArgs = ['tanda_pendaftaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_persyaratan" class="form-label required-label">Tanggal Persyaratan Dinyatakan Lengkap</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['tanggal_persyaratan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="tanggal_persyaratan" name="tanggal_persyaratan" 
                                   value="<?php echo e(old('tanggal_persyaratan', $lks->tanggal_persyaratan ? $lks->tanggal_persyaratan->format('Y-m-d') : '')); ?>" required>
                            <?php $__errorArgs = ['tanggal_persyaratan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_masuk_dokumen" class="form-label required-label">Tanggal Masuk Dokumen</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['tanggal_masuk_dokumen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="tanggal_masuk_dokumen" name="tanggal_masuk_dokumen" 
                                   value="<?php echo e(old('tanggal_masuk_dokumen', $lks->tanggal_masuk_dokumen ? $lks->tanggal_masuk_dokumen->format('Y-m-d') : '')); ?>" required>
                            <?php $__errorArgs = ['tanggal_masuk_dokumen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Checklist Dokumen -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-check2-square"></i> Edit Checklist Kelengkapan Dokumen
                            </h6>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> 
                                <strong>Petunjuk:</strong> Klik "Tambah File" untuk menambahkan multiple files. File akan ditambahkan satu per satu.
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="25%">Nama Dokumen</th>
                                            <th width="25%">Upload File Baru</th>
                                            <th width="30%">File Sebelumnya</th>
                                            <th width="15%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $lks->checklists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $checklist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td>
                                                <strong><?php echo e($checklist->document->nama_dokumen); ?></strong>
                                                <?php if($checklist->document->wajib): ?>
                                                    <span class="badge bg-danger ms-2">Wajib</span>
                                                <?php endif; ?>
                                                <input type="hidden" name="documents[<?php echo e($index); ?>][document_id]" value="<?php echo e($checklist->document_id); ?>">
                                                <input type="hidden" name="documents[<?php echo e($index); ?>][kelengkapan]" id="kelengkapan_<?php echo e($index); ?>" value="<?php echo e($checklist->kelengkapan); ?>">
                                            </td>
                                            <td>
                                                <!-- File Upload Container -->
                                                <div id="file_upload_container_<?php echo e($index); ?>">
                                                    <!-- Dynamic file inputs will be added here -->
                                                    <div class="file-input-wrapper mb-2">
                                                        <input type="file" 
                                                               class="form-control form-control-sm single-file-input" 
                                                               name="documents[<?php echo e($index); ?>][files][]" 
                                                               data-index="<?php echo e($index); ?>"
                                                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                    </div>
                                                </div>
                                                
                                                <!-- Add More Files Button -->
                                                <button type="button" class="btn btn-outline-primary btn-sm add-more-files" data-index="<?php echo e($index); ?>">
                                                    <i class="bi bi-plus-circle"></i> Tambah File Lain
                                                </button>
                                                
                                                <small class="text-muted d-block mt-1">PDF, JPG, PNG, DOC (Max 2MB per file)</small>
                                            </td>
                                            <td>
                                                <?php if($checklist->has_files): ?>
                                                    <div class="existing-files-container">
                                                        <small class="text-success fw-bold d-block mb-2">
                                                            <i class="bi bi-folder-check"></i> 
                                                            File saat ini (<?php echo e($checklist->file_count); ?>)
                                                        </small>
                                                        <?php $__currentLoopData = $checklist->getFilesInfo(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fileIndex => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="existing-file-item d-flex justify-content-between align-items-center p-2 mb-2 border rounded bg-white">
                                                            <div class="file-info">
                                                                <i class="bi bi-file-earmark-check text-success"></i>
                                                                <a href="<?php echo e(route('lks.files.show', [$lks->id, $checklist->id, $file['index']])); ?>" target="_blank" class="text-decoration-none ms-2">
                                                                    <small><?php echo e($file['name']); ?></small>
                                                                </a>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-primary">File <?php echo e($fileIndex + 1); ?></span>
                                                                <button type="button" class="btn btn-sm btn-outline-danger delete-file-btn"
                                                                        data-url="<?php echo e(route('lks.files.destroy', [$lks->id, $checklist->id, $file['index']])); ?>"
                                                                        data-confirm="Hapus file ini?">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">
                                                        <i class="bi bi-file-earmark-x"></i> Belum ada file
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" 
                                                       name="documents[<?php echo e($index); ?>][keterangan]" 
                                                       value="<?php echo e($checklist->keterangan ?? ''); ?>" 
                                                       placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?php echo e(route('lks.show', $lks->id)); ?>" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Update Data
                                </button>
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
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill today's date for tanggal_masuk_dokumen if empty
    const tanggalMasukInput = document.getElementById('tanggal_masuk_dokumen');
    if (tanggalMasukInput && !tanggalMasukInput.value) {
        tanggalMasukInput.value = new Date().toISOString().split('T')[0];
    }

    const tanggalPersyaratanInput = document.getElementById('tanggal_persyaratan');
    if (tanggalPersyaratanInput && !tanggalPersyaratanInput.value) {
        tanggalPersyaratanInput.value = new Date().toISOString().split('T')[0];
    }

    // ========== JENIS PELAYANAN FUNCTIONALITY ==========
    const jenisPelayananCheckboxes = document.querySelectorAll('.jenis-pelayanan-checkbox');
    const jenisPelayananHidden = document.getElementById('jenis_pelayanan');

    function updateJenisPelayanan() {
        const selectedValues = Array.from(jenisPelayananCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);
        
        jenisPelayananHidden.value = selectedValues.join(', ');
        
        console.log('Jenis Pelayanan Selected:', selectedValues); // Debug
        console.log('Hidden Input Value:', jenisPelayananHidden.value); // Debug
    }

    // Initialize jenis pelayanan
    updateJenisPelayanan();

    // Add event listeners for jenis pelayanan checkboxes
    jenisPelayananCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateJenisPelayanan);
    });

    // Form validation for jenis pelayanan
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const selectedValues = Array.from(jenisPelayananCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            
            if (selectedValues.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu jenis pelayanan');
                return false;
            }
            
            // Final update before submit
            updateJenisPelayanan();
        });
    }

    // ========== CABANG LKS FUNCTIONALITY ==========
    const cabangCheckboxes = document.querySelectorAll('.cabang-checkbox');
    const selectedItemsContainer = document.getElementById('selectedItems');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const clearAllBtn = document.getElementById('clearAllBtn');
    const searchInput = document.getElementById('searchInput');
    const cabangLksHidden = document.getElementById('cabang_lks_hidden');

    // Function to update selected items display and hidden input
    function updateSelectedItems() {
        const selectedCheckboxes = Array.from(cabangCheckboxes).filter(checkbox => checkbox.checked);
        const selectedValues = selectedCheckboxes.map(checkbox => checkbox.value);

        // Update hidden input
        cabangLksHidden.value = selectedValues.join(', ');

        if (selectedValues.length === 0) {
            selectedItemsContainer.innerHTML = '<div class="text-muted">Belum ada pilihan. Silakan pilih dari daftar di atas.</div>';
            return;
        }
        
        selectedItemsContainer.innerHTML = '';
        selectedValues.forEach(value => {
            const item = document.createElement('div');
            item.className = 'selected-item';
            item.innerHTML = `
                ${value}
                <button type="button" class="remove-btn" data-value="${value}">
                    <i class="bi bi-x"></i>
                </button>
            `;
            selectedItemsContainer.appendChild(item);
        });

        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const valueToRemove = this.getAttribute('data-value');
                const checkboxToUncheck = Array.from(cabangCheckboxes).find(cb => cb.value === valueToRemove);
                if (checkboxToUncheck) {
                    checkboxToUncheck.checked = false;
                    updateSelectedItems();
                }
            });
        });
    }

    // Initial update for cabang LKS
    updateSelectedItems();

    // Event listener for cabang checkbox changes
    cabangCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedItems);
    });

    // Select all functionality
    selectAllBtn.addEventListener('click', function() {
        cabangCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateSelectedItems();
    });

    // Clear all functionality
    clearAllBtn.addEventListener('click', function() {
        cabangCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectedItems();
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const checkboxItems = document.querySelectorAll('.checkbox-item');

        checkboxItems.forEach(item => {
            const label = item.querySelector('.form-check-label');
            if (label.textContent.toLowerCase().includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // ========== FILE UPLOAD FUNCTIONALITY ==========
    const fileStorage = {};
    
    // Add more files functionality
    document.querySelectorAll('.add-more-files').forEach(button => {
        button.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            addFileInput(index);
        });
    });

    // Handle file input changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('single-file-input')) {
            const index = e.target.getAttribute('data-index');
            handleFileChange(index);
        }
    });

    // Handle file removal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-file') || 
            e.target.closest('.remove-file')) {
            const button = e.target.classList.contains('remove-file') ? e.target : e.target.closest('.remove-file');
            const index = button.getAttribute('data-index');
            const fileName = button.getAttribute('data-filename');
            removeFile(index, fileName);
        }
    });

    function addFileInput(index) {
        const container = document.getElementById(`file_upload_container_${index}`);
        const inputCount = container.querySelectorAll('.single-file-input').length;
        
        const inputWrapper = document.createElement('div');
        inputWrapper.className = 'file-input-wrapper mb-2';
        inputWrapper.innerHTML = `
            <div class="input-group input-group-sm">
                <input type="file" 
                       class="form-control form-control-sm single-file-input" 
                       name="documents[${index}][files][]" 
                       data-index="${index}"
                       accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                <button type="button" class="btn btn-outline-danger btn-sm remove-input">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        
        container.appendChild(inputWrapper);

        // Add remove functionality for this specific input
        inputWrapper.querySelector('.remove-input').addEventListener('click', function() {
            inputWrapper.remove();
            handleFileChange(index);
        });
    }

    function handleFileChange(index) {
        const container = document.getElementById(`file_upload_container_${index}`);
        const inputs = container.querySelectorAll('.single-file-input');
        const kelengkapanInput = document.getElementById(`kelengkapan_${index}`);

        // Collect all files
        const allFiles = [];
        inputs.forEach(input => {
            if (input.files.length > 0) {
                allFiles.push(input.files[0]);
            }
        });

        // Initialize storage for this index if not exists
        if (!fileStorage[index]) {
            fileStorage[index] = [];
        }

        // Update storage with current files
        fileStorage[index] = allFiles;

        // Update UI
        updateFileList(index);
        updateStatus(index, allFiles.length);
    }

    function updateFileList(index) {
        const files = fileStorage[index] || [];
        const fileListContainer = document.getElementById(`file_list_${index}`);

        if (files.length > 0) {
            let fileListHTML = '<div class="selected-files mt-2">';
            fileListHTML += '<small class="text-success fw-bold">File terpilih (' + files.length + '):</small>';
            fileListHTML += '<ul class="list-unstyled mt-1 mb-2">';

            let totalSize = 0;
            let validFiles = 0;

            files.forEach((file, i) => {
                const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
                totalSize += parseFloat(fileSizeMB);

                if (file.size <= 2 * 1024 * 1024) {
                    fileListHTML += `
                        <li class="mb-1 d-flex justify-content-between align-items-center">
                            <small class="text-success">
                                <i class="bi bi-file-earmark-check"></i>
                                ${file.name}
                                <span class="text-muted">(${fileSizeMB} MB)</span>
                            </small>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-file" 
                                    data-index="${index}" data-filename="${file.name}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </li>
                    `;
                    validFiles++;
                } else {
                    fileListHTML += `
                        <li class="mb-1 d-flex justify-content-between align-items-center">
                            <small class="text-danger">
                                <i class="bi bi-file-earmark-x"></i>
                                ${file.name}
                                <span class="badge bg-danger">${fileSizeMB} MB</span>
                            </small>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-file" 
                                    data-index="${index}" data-filename="${file.name}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </li>
                    `;
                }
            });

            fileListHTML += '</ul>';
            fileListHTML += `<small class="text-muted">Total size: ${totalSize.toFixed(2)} MB</small>`;
            
            if (validFiles < files.length) {
                fileListHTML += '<div class="alert alert-warning mt-2 py-1">';
                fileListHTML += '<small><i class="bi bi-exclamation-triangle"></i> Beberapa file melebihi 2MB</small>';
                fileListHTML += '</div>';
            }
            
            fileListHTML += '</div>';

            fileListContainer.innerHTML = fileListHTML;
        } else {
            fileListContainer.innerHTML = '';
        }
    }

    function updateStatus(index, fileCount) {
        const kelengkapanInput = document.getElementById(`kelengkapan_${index}`);

        if (fileCount > 0) {
            kelengkapanInput.value = 'Ada';
        } else {
            kelengkapanInput.value = 'Tidak Ada';
        }
    }

    function removeFile(index, fileName) {
        if (fileStorage[index]) {
            fileStorage[index] = fileStorage[index].filter(file => file.name !== fileName);
            
            // Also remove the corresponding file input
            const container = document.getElementById(`file_upload_container_${index}`);
            const inputs = container.querySelectorAll('.single-file-input');
            inputs.forEach(input => {
                if (input.files[0] && input.files[0].name === fileName) {
                    input.value = ''; // Clear the input
                }
            });
            
            updateFileList(index);
            updateStatus(index, fileStorage[index].length);
        }
    }

    // Initialize with one file input per row
    document.querySelectorAll('[id^="file_upload_container_"]').forEach(container => {
        const index = container.id.split('_').pop();
        if (!fileStorage[index]) {
            fileStorage[index] = [];
        }
    });

    // Handle delete single file
    document.querySelectorAll('.delete-file-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const confirmMsg = this.getAttribute('data-confirm') || 'Hapus file ini?';
            if (!url) return;
            if (!confirm(confirmMsg)) return;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: new URLSearchParams({ _method: 'DELETE' })
            }).then(resp => {
                if (resp.ok) {
                    window.location.reload();
                } else {
                    alert('Gagal menghapus file.');
                }
            }).catch(() => alert('Gagal menghapus file.'));
        });
    });

    // Handle delete all files for a checklist
    document.querySelectorAll('.delete-all-files-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const confirmMsg = this.getAttribute('data-confirm') || 'Hapus semua file untuk dokumen ini?';
            if (!url) return;
            if (!confirm(confirmMsg)) return;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: new URLSearchParams({ _method: 'DELETE' })
            }).then(resp => {
                if (resp.ok) {
                    window.location.reload();
                } else {
                    alert('Gagal menghapus semua file.');
                }
            }).catch(() => alert('Gagal menghapus semua file.'));
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/lks/edit.blade.php ENDPATH**/ ?>