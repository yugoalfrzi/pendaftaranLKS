

<?php $__env->startSection('content'); ?>
<style>
    .card-modern { 
        border-radius:1.25rem; 
        border:1px solid #edf2f7; 
        background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.02); 
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
        background:#fef3c7; 
        color:#b45309; 
    }
    .s-shared   { 
        background:#e0e7ff; 
        color:#4338ca; 
    }
    .doc-file-item { 
        display:flex; 
        align-items:center; 
        justify-content:space-between; 
        padding:0.5rem 0.75rem; 
        border-radius:0.6rem; 
        background:#f8fafc; 
        border:1px solid #e2e8f0; 
        margin-bottom:0.4rem; 
        font-size:0.82rem; 
    }
    .doc-file-item:last-child { 
        margin-bottom:0; 
    }
    .upload-area { 
        border:2px dashed #e2e8f0; 
        border-radius:0.75rem; 
        padding:1.25rem; 
        text-align:center; 
        cursor:pointer; t
        ransition:all 0.2s; 
        background:#f8fafc;
    }
    .upload-area:hover { 
        border-color:#2563eb; 
        background:#eff6ff; 
    }
    .stat-card { 
        border-radius:1rem; 
        padding:1rem 1.25rem; 
        display:flex; 
        align-items:center; 
        gap:0.85rem; 
        border:1px solid #edf2f7; 
        background:#fff; 
        box-shadow:0 2px 6px rgba(0,0,0,0.02); 
    }
    .stat-icon { 
        width:2.5rem; 
        height:2.5rem; 
        border-radius:0.65rem; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        font-size:1.1rem; 
        flex-shrink:0; 
    }
</style>


<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1" style="font-size:0.8rem">
                <li class="breadcrumb-item"><a href="<?php echo e(route('hibah.index')); ?>">Data Hibah</a></li>
                <li class="breadcrumb-item active">Kelola Dokumen &mdash; <?php echo e($hibah->tahun); ?></li>
            </ol>
        </nav>
        <h4 class="fw-semibold mb-1">Kelola Dokumen Pendukung</h4>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="text-muted small"><i class="bi bi-building me-1"></i><?php echo e($hibah->nama_lks); ?></span>
            <span class="badge-pill s-shared"><i class="bi bi-calendar me-1"></i>Tahun <?php echo e($hibah->tahun); ?></span>
            <span class="badge-pill s-shared"><i class="bi bi-calendar-check me-1"></i>Per Tahun</span>
        </div>
    </div>
    <div class="d-flex gap-2">
        <?php if(Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin'): ?>
        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
            <i class="bi bi-cloud-arrow-up me-1"></i> Upload Massal
        </button>
        <?php endif; ?>
        <a href="<?php echo e(route('hibah.index', ['tahun' => $hibah->tahun])); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>


<div class="alert alert-info d-flex align-items-start gap-2 mb-3" style="border-radius:0.75rem; font-size:0.85rem;">
    <i class="bi bi-info-circle-fill mt-1 flex-0"></i>
    <div>
        <strong>Sistem Dokumen Pendukung Per Tahun</strong> —
        Dokumen pendukung diupload sekali dan berlaku untuk <strong>semua LKS tahun <?php echo e($hibah->tahun); ?></strong>.
        Dokumen tidak akan menyebar ke tahun lain.
        <?php $totalLksTahunIni = $allYearsData->where('tahun', $hibah->tahun)->count(); ?>
        Total: <strong><?php echo e($totalLksTahunIni); ?> LKS</strong>.
    </div>
</div>


<?php
    $uploadedDocs = 0;
    $totalDocs = 11;
    $docFields = [
        'hasil_verifikasi_path', 'pergub_penjabaran_apbd_path', 'dpa_path',
        'hasil_identifikasi_path', 'data_penerima_hibah_path',
        'spm_path', 'sp2d_path', 'petunjuk_teknis_path',
        'surat_ket_lampiran_verifikasi_path', 'bukti_pembayaran_transfer_path',
        'sk_kadinsos_tim_verifikasi_path',
    ];
    foreach ($docFields as $field) {
        if (!empty($hibah->$field)) $uploadedDocs++;
    }
    $percentage = $totalDocs > 0 ? ($uploadedDocs / $totalDocs) * 100 : 0;
?>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff; color:#2563eb;"><i class="bi bi-file-text"></i></div>
            <div>
                <div class="fw-semibold" style="font-size:1rem;"><?php echo e($hibah->proposal_path ? '✓' : '✗'); ?></div>
                <div class="text-muted" style="font-size:0.75rem;">Proposal <?php echo e($hibah->tahun); ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;"><i class="bi bi-file-earmark-text"></i></div>
            <div>
                <div class="fw-semibold" style="font-size:1rem;"><?php echo e($hibah->lpj_path ? '✓' : '✗'); ?></div>
                <div class="text-muted" style="font-size:0.75rem;">LPJ <?php echo e($hibah->tahun); ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0f9ff; color:#0284c7;"><i class="bi bi-folder2"></i></div>
            <div>
                <div class="fw-semibold" style="font-size:1rem;"><?php echo e($uploadedDocs); ?>/<?php echo e($totalDocs); ?></div>
                <div class="text-muted" style="font-size:0.75rem;">Dok. Pendukung</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fefce8; color:#ca8a04;"><i class="bi bi-share"></i></div>
            <div>
                <div class="fw-semibold" style="font-size:1rem;"><?php echo e($totalLksTahunIni); ?></div>
                <div class="text-muted" style="font-size:0.75rem;">LKS Tahun <?php echo e($hibah->tahun); ?></div>
            </div>
        </div>
    </div>
</div>


<p class="fw-semibold text-secondary mb-2" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em;">
    <i class="bi bi-calendar-event me-1"></i> Dokumen Spesifik Tahun <?php echo e($hibah->tahun); ?>

</p>
<div class="row g-3 mb-4">
    
    <div class="col-md-6">
        <div class="card-modern">
            <div class="card-header-custom">
                <i class="bi bi-file-text text-primary"></i> Proposal
                <span class="badge-pill s-shared ms-1" style="font-size:0.65rem;"><i class="bi bi-calendar me-1"></i><?php echo e($hibah->tahun); ?></span>
                <span class="ms-auto">
                    <?php if($hibah->proposal_path): ?>
                        <span class="badge-pill s-tersedia"><i class="bi bi-check-circle"></i> Tersedia</span>
                    <?php else: ?>
                        <span class="badge-pill s-belum"><i class="bi bi-clock"></i> Belum ada</span>
                    <?php endif; ?>
                </span>
            </div>
            <div class="card-body p-3">
                <?php if($hibah->proposal_path): ?>
                <div class="doc-file-item mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                        <span>Proposal <?php echo e($hibah->tahun); ?></span>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('hibah.documents.preview', [$hibah->id, 'proposal'])); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2" target="_blank"><i class="bi bi-eye"></i></a>
                        <a href="<?php echo e(route('hibah.documents.download', [$hibah->id, 'proposal'])); ?>" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                    </div>
                </div>
                <?php endif; ?>
                <a href="<?php echo e(route('hibah.edit', $hibah->id)); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3 w-100">
                    <i class="bi bi-pencil me-1"></i> Edit Proposal
                </a>
            </div>
        </div>
    </div>

    
    <div class="col-md-6">
        <div class="card-modern">
            <div class="card-header-custom">
                <i class="bi bi-file-earmark-text text-success"></i> LPJ
                <span class="badge-pill s-shared ms-1" style="font-size:0.65rem;"><i class="bi bi-calendar me-1"></i><?php echo e($hibah->tahun); ?></span>
                <span class="ms-auto">
                    <?php if($hibah->lpj_path): ?>
                        <span class="badge-pill s-tersedia"><i class="bi bi-check-circle"></i> Tersedia</span>
                    <?php else: ?>
                        <span class="badge-pill s-belum"><i class="bi bi-clock"></i> Belum ada</span>
                    <?php endif; ?>
                </span>
            </div>
            <div class="card-body p-3">
                <?php if($hibah->lpj_path): ?>
                <div class="doc-file-item mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                        <span>LPJ <?php echo e($hibah->tahun); ?></span>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('hibah.documents.preview', [$hibah->id, 'lpj'])); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2" target="_blank"><i class="bi bi-eye"></i></a>
                        <a href="<?php echo e(route('hibah.documents.download', [$hibah->id, 'lpj'])); ?>" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(Auth::user() && (Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin')): ?>
                <form action="<?php echo e(route('hibah.documents.upload', $hibah->id)); ?>" method="POST" enctype="multipart/form-data" class="mb-0">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="document_type" value="lpj">
                    <div class="upload-area" onclick="document.getElementById('file-lpj').click()">
                        <i class="bi bi-cloud-arrow-up fs-5 text-muted mb-1 d-block"></i>
                        <p class="small mb-1">Upload LPJ untuk <strong>Tahun <?php echo e($hibah->tahun); ?></strong></p>
                        <p class="small text-muted mb-0">PDF, Word, Excel, dll (Maks. 50MB)</p>
                        <input type="file" name="document_file" id="file-lpj" class="d-none" accept="*" onchange="this.form.submit()">
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<p class="fw-semibold text-secondary mb-2" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em;">
    <i class="bi bi-calendar-check me-1"></i> Dokumen Pendukung — Berlaku untuk Semua LKS Tahun <?php echo e($hibah->tahun); ?>

</p>

<?php
    $supportingDocuments = [
        'hasil_verifikasi'              => ['icon' => 'bi-clipboard-check',   'title' => 'Hasil Verifikasi Administrasi',                                           'color' => 'primary'],
        'pergub_penjabaran_apbd'        => ['icon' => 'bi-file-earmark-text', 'title' => 'Pergub Penjabaran APBD',                                                  'color' => 'info'],
        'dpa'                           => ['icon' => 'bi-file-text',          'title' => 'DPA',                                                                     'color' => 'secondary'],
        'hasil_identifikasi'            => ['icon' => 'bi-person-check',       'title' => 'Hasil Identifikasi',                                                      'color' => 'success'],
        'data_penerima_hibah'           => ['icon' => 'bi-people',             'title' => 'Data Penerima Hibah',                                                     'color' => 'warning'],
        'spm'                           => ['icon' => 'bi-cash-coin',          'title' => 'SPM',                                                                     'color' => 'danger'],
        'sp2d'                          => ['icon' => 'bi-receipt',            'title' => 'SP2D',                                                                    'color' => 'dark'],
        'petunjuk_teknis'               => ['icon' => 'bi-journal-text',       'title' => 'Petunjuk Teknis',                                                         'color' => 'primary'],
        'surat_ket_lampiran_verifikasi' => ['icon' => 'bi-file-earmark-check', 'title' => 'Surat Keterangan dan Lampiran Hasil Verifikasi Administrasi (Pencairan)', 'color' => 'success'],
        'bukti_pembayaran_transfer'     => ['icon' => 'bi-bank',               'title' => 'Bukti Pembayaran Transfer dan Lampiran Penerima Hibah (Pencairan)',       'color' => 'info'],
        'sk_kadinsos_tim_verifikasi'    => ['icon' => 'bi-award',              'title' => 'SK Kadinsos tentang Tim Verifikasi dan Evaluasi Hibah dan Bansos',        'color' => 'warning'],
    ];
?>

<div class="row g-3 mb-4">
    <?php $__currentLoopData = $supportingDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docType => $docInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $fileField = $docType . '_path'; $hasFile = !empty($hibah->$fileField); ?>
        <div class="col-md-6 col-lg-4">
            <div class="card-modern h-100">
                <div class="card-header-custom">
                    <i class="<?php echo e($docInfo['icon']); ?> text-<?php echo e($docInfo['color']); ?>"></i>
                    <?php echo e($docInfo['title']); ?>

                    <span class="badge-pill ms-1" style="font-size:0.65rem; background:#fef3c7; color:#b45309;"><i class="bi bi-calendar-check me-1"></i>Per Tahun</span>
                    <span class="ms-auto">
                        <?php if($hasFile): ?>
                            <span class="badge-pill s-tersedia"><i class="bi bi-check-circle"></i> Ada</span>
                        <?php else: ?>
                            <span class="badge-pill s-belum"><i class="bi bi-clock"></i> Belum</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="card-body p-3">
                    <?php if($hasFile): ?>
                    <div class="doc-file-item mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-pdf text-danger"></i>
                            <span><?php echo e($docInfo['title']); ?></span>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="<?php echo e(route('hibah.documents.preview', [$hibah->id, $docType])); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2" target="_blank"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('hibah.documents.download', [$hibah->id, $docType])); ?>" class="btn btn-sm btn-outline-success rounded-pill px-2"><i class="bi bi-download"></i></a>
                            <?php if(Auth::user() && Auth::user()->role === 'super_admin'): ?>
                            <form action="<?php echo e(route('hibah.documents.delete', $hibah->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <input type="hidden" name="document_type" value="<?php echo e($docType); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2"
                                        onclick="return confirm('Hapus <?php echo e($docInfo['title']); ?> untuk semua LKS tahun <?php echo e($hibah->tahun); ?>?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="text-muted mb-2" style="font-size:0.75rem;">
                        <i class="bi bi-calendar-check me-1"></i>Berlaku untuk <?php echo e($totalLksTahunIni); ?> LKS <strong>tahun <?php echo e($hibah->tahun); ?></strong>
                    </p>
                    <?php endif; ?>

                    <?php if(Auth::user() && (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')): ?>
                    <form action="<?php echo e(route('hibah.documents.upload', $hibah->id)); ?>" method="POST" enctype="multipart/form-data" class="mb-0">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="document_type" value="<?php echo e($docType); ?>">
                        <div class="upload-area" onclick="document.getElementById('file-<?php echo e($docType); ?>').click()">
                            <i class="bi bi-cloud-arrow-up fs-5 text-muted mb-1 d-block"></i>
                            <p class="small mb-1">Upload untuk <strong>Semua LKS Tahun <?php echo e($hibah->tahun); ?></strong></p>
                            <p class="small text-muted mb-0">PDF, Word, Excel, dll (Maks. 50MB)</p>
                            <input type="file" name="document_file" id="file-<?php echo e($docType); ?>" class="d-none" accept="*" onchange="this.form.submit()">
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="card-modern mb-4">
    <div class="card-header-custom"><i class="bi bi-info-circle text-primary"></i> Informasi Sistem Dokumen Terpusat</div>
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-6">
                <p class="fw-semibold small mb-1">Dokumen Spesifik Tahun:</p>
                <ul class="small text-muted mb-0 ps-3">
                    <li><strong>Proposal</strong> — Diupload saat buat data baru, spesifik per LKS per tahun</li>
                    <li><strong>LPJ</strong> — Diupload terpisah untuk setiap LKS per tahun</li>
                </ul>
            </div>
            <div class="col-md-6">
                <p class="fw-semibold small mb-1">Dokumen Pendukung Per Tahun:</p>
                <ul class="small text-muted mb-0 ps-3">
                    <li>Hasil Verifikasi, Pergub APBD, DPA, SPM, SP2D, dll.</li>
                    <li>Diupload <strong>sekali saja</strong> dan berlaku untuk semua LKS <strong>tahun <?php echo e($hibah->tahun); ?></strong></li>
                    <li>Tidak menyebar ke tahun lain — setiap tahun perlu upload ulang</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php if(Auth::user() && in_array(Auth::user()->role, ['admin', 'super_admin'])): ?>
<div class="modal fade" id="bulkUploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:1rem; border:1px solid #edf2f7;">
            <div class="modal-header" style="border-bottom:1px solid #eef2f6;">
                <h5 class="modal-title fw-semibold" style="font-size:0.95rem;">
                    <i class="bi bi-upload me-2 text-primary"></i>Upload Massal Dokumen Pendukung
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('hibah.bulk-upload-supporting', $hibah->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="alert alert-info d-flex align-items-start gap-2 mb-3" style="border-radius:0.75rem; font-size:0.83rem;">
                        <i class="bi bi-info-circle-fill mt-1 flex-0"></i>
                        <div>
                            Dokumen yang diupload akan berlaku untuk <strong>semua LKS tahun <?php echo e($hibah->tahun); ?></strong>.
                            Total: <strong><?php echo e($totalLksTahunIni); ?> LKS</strong>.
                        </div>
                    </div>
                    <div class="row g-3">
                        <?php $__currentLoopData = $supportingDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docType => $docInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary"><?php echo e($docInfo['title']); ?></label>
                            <input type="file" name="supporting_documents[<?php echo e($docType); ?>]" class="form-control form-control-sm">
                            <small class="text-muted">PDF, Word, Excel, dll. Maks 50MB</small>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #eef2f6;">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">
                        <i class="bi bi-cloud-arrow-up me-1"></i> Upload Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $('.upload-area').on('dragover', function(e) {
            e.preventDefault();
            $(this).css({'border-color':'#2563eb','background':'#eff6ff'});
        });
        $('.upload-area').on('dragleave drop', function(e) {
            e.preventDefault();
            $(this).css({'border-color':'#e2e8f0','background':'#f8fafc'});
        });
        setTimeout(() => { $('.alert').alert('close'); }, 5000);
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/hibah/documents.blade.php ENDPATH**/ ?>