@extends('layouts.app')

@section('title', 'Surat LKS')
@section('page-title', 'Surat')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header Section -->
        <div class="card mb-4" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #000;">
            <div class="card-body text-center py-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="display-4 fw-bold mb-3">
                            <i class="bi bi-envelope"></i>
                            SURAT LKS
                        </h1>
                        <p class="lead">Template Surat Resmi Lembaga Kesejahteraan Sosial</p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <i class="bi bi-envelope-paper" style="font-size: 8rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ count($letters) }}</h4>
                                <small>Total Template</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-envelope fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $activeTemplates }}</h4>
                                <small>Template Aktif</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-check-circle fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ array_sum(array_column($letters, 'download_count')) }}</h4>
                                <small>Total Download</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-download fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $currentYear }}</h4>
                                <small>Tahun Berjalan</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-calendar fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-warning text-dark">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Cari template surat..." id="searchInput">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="typeFilter">
                                    <option value="">Semua Jenis</option>
                                    <option value="Pengajuan">Pengajuan</option>
                                    <option value="Permohonan">Permohonan</option>
                                    <option value="Hibah">Hibah</option>
                                    <option value="Administrasi">Administrasi</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="formatFilter">
                                    <option value="">Semua Format</option>
                                    <option value="DOCX">DOCX</option>
                                    <option value="DOC">DOC</option>
                                    <option value="PDF">PDF</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Surat -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning">
                    <h5 class="alert-heading">
                        <i class="bi bi-info-circle"></i> Informasi Template Surat
                    </h5>
                    <p class="mb-0">
                        Berikut adalah kumpulan template surat resmi untuk keperluan administrasi Lembaga Kesejahteraan Sosial (LKS). 
                        Silakan unduh dan sesuaikan dengan kebutuhan Anda.
                    </p>
                </div>
            </div>
        </div>

        <!-- Daftar Surat -->
        <div class="row" id="lettersContainer">
            @foreach($letters as $letter)
            <div class="col-md-6 col-lg-4 mb-4 letter-card">
                <div class="card h-100 border-warning">
                    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="bi {{ $letter['icon'] }}"></i> {{ $letter['type'] }}
                        </h6>
                        <span class="badge bg-dark text-white">{{ $letter['format'] }}</span>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi {{ $letter['icon'] }} fs-4"></i>
                            </div>
                        </div>
                        
                        <div class="letter-date mb-2">
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-calendar"></i> {{ $letter['date'] }}
                            </span>
                        </div>
                        
                        <h5 class="card-title text-warning fw-bold">{{ $letter['title'] }}</h5>
                        <p class="card-text text-muted small">{{ $letter['description'] }}</p>
                        
                        <div class="letter-meta mb-3">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-file-arrow-down"></i> {{ $letter['file_size'] }}</span>
                                <span><i class="bi bi-download"></i> {{ $letter['download_count'] }}x</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                    <i class="bi bi-tags"></i> {{ $letter['category'] }}
                                </span>
                                @if($letter['download_count'] > 200)
                                <span class="badge bg-success text-white">
                                    <i class="bi bi-star-fill"></i> Recommended
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('announcements.download', ['type' => 'surat', 'filename' => $letter['file_name']]) }}" 
                               class="btn btn-warning download-btn" 
                               data-filename="{{ $letter['file_name'] }}"
                               data-title="{{ $letter['title'] }}">
                                <i class="bi bi-download"></i> Unduh Template
                            </a>
                            <button class="btn btn-outline-warning edit-btn" data-title="{{ $letter['title'] }}">
                                <i class="bi bi-pencil"></i> Edit Template
                            </button>

                            @if(isset($letter['id']))
                            <form action="{{ route('announcements.destroy', ['id' => $letter['id']]) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning"></i> Akses Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center justify-content-center">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('announcements.create') }}" class="btn btn-warning btn-lg w-100">
                                    <i class="bi bi-plus-circle"></i><br>
                                    <small>Tambah Dokumen</small>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-outline-warning btn-lg w-100" onclick="location.reload()">
                                    <i class="bi bi-arrow-clockwise"></i><br>
                                    <small>Refresh Data</small>
                                </button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-outline-warning btn-lg w-100" id="quickTemplateBtn">
                                    <i class="bi bi-lightning"></i><br>
                                    <small>Buat Cepat</small>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Download -->
<div class="modal fade" id="downloadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning">
                    <i class="bi bi-download"></i> Konfirmasi Download Template
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan mengunduh template surat:</p>
                <div class="alert alert-warning">
                    <strong id="downloadTitle"></strong>
                </div>
                <p class="text-muted small">
                    <i class="bi bi-info-circle"></i> 
                    File template akan diunduh dalam format yang dapat diedit.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-warning" id="confirmDownloadLink">
                    <i class="bi bi-download"></i> Download Template
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(255, 193, 7, 0.15);
}

.border-warning {
    border: 2px solid #ffc107 !important;
}

.letter-meta {
    border-top: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
    padding: 10px 0;
}

.letter-date .badge {
    font-size: 0.75em;
}

/* Recommended badge animation */
.badge.bg-success {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const downloadButtons = document.querySelectorAll('.download-btn');
    const downloadModal = new bootstrap.Modal(document.getElementById('downloadModal'));
    const downloadTitle = document.getElementById('downloadTitle');
    const confirmDownloadLink = document.getElementById('confirmDownloadLink');
    const editButtons = document.querySelectorAll('.edit-btn');
    const quickTemplateBtn = document.getElementById('quickTemplateBtn');
    
    let currentDownloadUrl = '';
    
    downloadButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            currentDownloadUrl = this.href;
            downloadTitle.textContent = this.dataset.title;
            confirmDownloadLink.href = currentDownloadUrl;
            downloadModal.show();
        });
    });

    // Edit button functionality
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const title = this.dataset.title;
            
            const alert = document.createElement('div');
            alert.className = 'alert alert-info alert-dismissible fade show position-fixed';
            alert.style.top = '20px';
            alert.style.right = '20px';
            alert.style.zIndex = '9999';
            alert.style.minWidth = '300px';
            alert.innerHTML = `
                <i class="bi bi-pencil"></i> 
                <strong>Edit Template:</strong> ${title} - Fitur editor akan segera tersedia.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 4000);
        });
    });

    // Quick template button
    quickTemplateBtn.addEventListener('click', function() {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
        alert.style.top = '20px';
        alert.style.right = '20px';
        alert.style.zIndex = '9999';
        alert.style.minWidth = '300px';
        alert.innerHTML = `
            <i class="bi bi-lightning"></i> 
            <strong>Buat Cepat:</strong> Fitur template cepat akan segera tersedia.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 4000);
    });

    // Search and Filter functionality
    function filterLetters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value;
        const formatFilter = document.getElementById('formatFilter').value;
        
        const cards = document.querySelectorAll('.letter-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const type = card.querySelector('.card-header h6').textContent;
            const format = card.querySelector('.card-header .badge').textContent;
            
            const matchesSearch = title.includes(searchTerm);
            const matchesType = !typeFilter || type.includes(typeFilter);
            const matchesFormat = !formatFilter || format === formatFilter;
            
            if (matchesSearch && matchesType && matchesFormat) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show no results message
        const noResults = document.getElementById('noResults');
        if (visibleCount === 0) {
            if (!noResults) {
                const container = document.getElementById('lettersContainer');
                const message = document.createElement('div');
                message.id = 'noResults';
                message.className = 'col-12 text-center py-5';
                message.innerHTML = `
                    <div class="text-muted">
                        <i class="bi bi-search fs-1"></i>
                        <h4 class="mt-3">Tidak ada template surat yang ditemukan</h4>
                        <p>Coba gunakan kata kunci atau filter yang berbeda</p>
                    </div>
                `;
                container.appendChild(message);
            }
        } else if (noResults) {
            noResults.remove();
        }
    }

    document.getElementById('searchInput').addEventListener('input', filterLetters);
    document.getElementById('typeFilter').addEventListener('change', filterLetters);
    document.getElementById('formatFilter').addEventListener('change', filterLetters);
});
</script>
@endpush