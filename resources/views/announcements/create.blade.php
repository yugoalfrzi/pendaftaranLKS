@extends('layouts.app')

@section('title', 'Tambah Dokumen Baru')
@section('page-title', 'Tambah Dokumen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle"></i> Tambah Dokumen Baru
                </h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data" id="announcementForm">
                    @csrf

                    <!-- Hidden Category fallback -->
                    <input type="hidden" id="category" name="category" value="{{ request('category', old('category', 'regulasi')) }}">

                    <!-- Jenis Dokumen -->
                    <div class="mb-4">
                        <label for="announcement_type" class="form-label fw-bold">Jenis Dokumen <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg @error('announcement_type') is-invalid @enderror" 
                                id="announcement_type" name="announcement_type" required>
                            <option value="">Pilih Jenis Dokumen</option>
                            @foreach($announcementTypes as $value => $label)
                                <option value="{{ $value }}" {{ old('announcement_type') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('announcement_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Pilih jenis dokumen yang akan ditambahkan</div>
                    </div>

                    <!-- Informasi Dokumen -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="bi bi-info-circle"></i> Informasi Dokumen
                            </h6>
                        </div>
                    </div>

                    <!-- Judul -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" 
                               placeholder="Contoh: Panduan Pendaftaran LKS" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Jelaskan secara singkat tentang dokumen ini..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Format -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="format" class="form-label fw-bold">Format File <span class="text-danger">*</span></label>
                                <select class="form-select @error('format') is-invalid @enderror" 
                                        id="format" name="format" required>
                                    <option value="">Pilih Format</option>
                                    @foreach($formats as $label => $value)
                                        <option value="{{ $label }}" {{ old('format') == $label ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('format')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Fields Berdasarkan Jenis Dokumen -->
                    <div id="dynamicFields">
                        <!-- Fields untuk Regulasi -->
                        <div class="row regulasi-fields mb-3" style="display: none;">
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 text-info">
                                    <i class="bi bi-journal-text"></i> Informasi Regulasi
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="year" class="form-label fw-bold">Tahun Regulasi</label>
                                    <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                           id="year" name="year" value="{{ old('year') }}" 
                                           min="1900" max="{{ date('Y') }}"
                                           placeholder="Contoh: 2024">
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Tahun diterbitkannya regulasi</div>
                                </div>
                            </div>
                        </div>

                        <!-- Fields untuk Surat -->
                        <div class="row surat-fields mb-3" style="display: none;">
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 text-warning">
                                    <i class="bi bi-envelope"></i> Informasi Surat
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label fw-bold">Jenis Surat</label>
                                    <input type="text" class="form-control @error('type') is-invalid @enderror" 
                                           id="type" name="type" value="{{ old('type') }}" 
                                           placeholder="Contoh: Pengajuan, Permohonan">
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Jenis surat (opsional)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label fw-bold">Tanggal Surat</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                           id="date" name="date" value="{{ old('date') }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                    <div class="form-text">Tanggal surat (opsional)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Fields untuk Panduan -->
                        <div class="row panduan-fields mb-3" style="display: none;">
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 text-success">
                                    <i class="bi bi-journal-bookmark"></i> Informasi Panduan
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_updated" class="form-label fw-bold">Terakhir Diupdate</label>
                                    <input type="date" class="form-control" 
                                           id="last_updated" name="last_updated" value="{{ old('last_updated', date('Y-m-d')) }}">
                                    <div class="form-text">Tanggal terakhir update panduan</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload File -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 text-danger">
                                <i class="bi bi-cloud-upload"></i> Upload File
                            </h6>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-bold">File Dokumen <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
                        
                        <!-- File Preview -->
                        <div id="filePreview" class="mt-2" style="display: none;">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="shrink-0">
                                            <i class="bi bi-file-earmark fs-1 text-primary" id="fileIcon"></i>
                                        </div>
                                        <div class="grow 1 ms-3">
                                            <h6 id="fileName" class="mb-1"></h6>
                                            <small id="fileSize" class="text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i> Format yang didukung: PDF, DOC, DOCX, PPT, PPTX. Maksimal 10MB.
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end border-top pt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-md-2 px-4">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                            <i class="bi bi-save"></i> Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="bi bi-lightbulb"></i> Informasi Penting
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="shrink-0">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                            <div class="grow 1 ms-3">
                                <small class="fw-bold">Format File</small>
                                <p class="mb-0 text-muted small">PDF, DOC, DOCX, PPT, PPTX</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="shrink-0">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                            <div class="grow 1 ms-3">
                                <small class="fw-bold">Ukuran Maksimal</small>
                                <p class="mb-0 text-muted small">10 MB per file</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="shrink-0">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                            <div class="grow 1 ms-3">
                                <small class="fw-bold">Kelengkapan Data</small>
                                <p class="mb-0 text-muted small">Pastikan semua field wajib diisi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e3e6f0;
}

.card-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.form-label {
    color: #2d3748;
}

.form-control:focus, .form-select:focus {
    border-color: #4dabf7;
    box-shadow: 0 0 0 0.2rem rgba(77, 171, 247, 0.25);
}

.border-bottom {
    border-color: #e9ecef !important;
}

#filePreview .card {
    border-left: 4px solid #4dabf7;
    background-color: #f8f9fa;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.alert {
    border: none;
    border-radius: 8px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const announcementTypeSelect = document.getElementById('announcement_type');
    const categorySelect = document.getElementById('category');
    const fileInput = document.getElementById('file');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileIcon = document.getElementById('fileIcon');
    const submitBtn = document.getElementById('submitBtn');
    
    // categories removed from UI; keep hidden category input in sync with type
    const fileIcons = {
        'pdf': 'bi-file-earmark-pdf text-danger',
        'doc': 'bi-file-earmark-word text-primary',
        'docx': 'bi-file-earmark-word text-primary',
        'ppt': 'bi-file-earmark-ppt text-warning',
        'pptx': 'bi-file-earmark-ppt text-warning'
    };

    // Update categories based on announcement type
    announcementTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Sync hidden category to selected type as fallback default
        // Map type -> default category keyword
        const defaultCategoryMap = { regulasi: 'regulasi', panduan: 'panduan', surat: 'surat' };
        if (defaultCategoryMap[selectedType]) {
            document.getElementById('category').value = defaultCategoryMap[selectedType];
        }

        // Show/hide dynamic fields
        document.querySelectorAll('.regulasi-fields, .surat-fields, .panduan-fields').forEach(field => {
            field.style.display = 'none';
        });

        if (selectedType === 'regulasi') {
            document.querySelector('.regulasi-fields').style.display = 'flex';
        } else if (selectedType === 'surat') {
            document.querySelector('.surat-fields').style.display = 'flex';
        } else if (selectedType === 'panduan') {
            document.querySelector('.panduan-fields').style.display = 'flex';
        }

        // Update form header color based on type
        updateFormHeader(selectedType);
    });

    // File input change handler
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        
        if (file) {
            // Check file size
            if (file.size > maxSize) {
                alert('❌ Ukuran file terlalu besar. Maksimal 10MB.');
                this.value = '';
                filePreview.style.display = 'none';
                return;
            }

            // Check file type
            const fileExtension = file.name.split('.').pop().toLowerCase();
            const allowedExtensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];
            
            if (!allowedExtensions.includes(fileExtension)) {
                alert('❌ Format file tidak didukung. Harus PDF, DOC, DOCX, PPT, atau PPTX.');
                this.value = '';
                filePreview.style.display = 'none';
                return;
            }

            // Show file preview
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileIcon.className = 'bi ' + (fileIcons[fileExtension] || 'bi-file-earmark text-secondary') + ' fs-1';
            filePreview.style.display = 'block';
        } else {
            filePreview.style.display = 'none';
        }
    });

    // Form submission handler
    const form = document.getElementById('announcementForm');
    form.addEventListener('submit', function(e) {
        const announcementType = announcementTypeSelect.value;
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const category = document.getElementById('category').value;
        const format = document.getElementById('format').value;
        const file = fileInput.files[0];

        // Basic validation
        if (!announcementType || !title || !description || !format || !file) {
            e.preventDefault();
            showAlert('⚠️ Harap isi semua field yang wajib diisi.', 'warning');
            return;
        }

        // Show loading state
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        submitBtn.disabled = true;
    });

    // Helper function to format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Helper function to update form header color
    function updateFormHeader(type) {
        const cardHeader = document.querySelector('.card-header');
        const colors = {
            'panduan': 'success',
            'regulasi': 'primary',
            'surat': 'warning'
        };
        
        Object.values(colors).forEach(color => {
            cardHeader.classList.remove(`bg-${color}`);
        });
        
        if (type && colors[type]) {
            cardHeader.classList.add(`bg-${colors[type]}`);
        } else {
            cardHeader.classList.add('bg-primary');
        }
    }

    // Helper function to show alert
    function showAlert(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    // Trigger change event on page load if there's a value
    if (announcementTypeSelect.value) {
        announcementTypeSelect.dispatchEvent(new Event('change'));
    } else {
        // ensure hidden category has a sensible default when page loads
        document.getElementById('category').value = 'regulasi';
    }

    // Set current date for surat date field if empty
    const dateField = document.getElementById('date');
    if (dateField && !dateField.value) {
        dateField.value = new Date().toISOString().split('T')[0];
    }
});
</script>
@endpush