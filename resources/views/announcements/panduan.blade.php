@extends('layouts.app')

@section('title', 'Panduan LKS')
@section('page-title', 'Panduan')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header Section -->
        <div class="card mb-4" style="background: linear-gradient(135deg, #198754 0%, #157347 100%); color: white;">
            <div class="card-body text-center py-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="display-4 fw-bold mb-3">
                            <i class="bi bi-journal-bookmark"></i>
                            PANDUAN LKS
                        </h1>
                        <p class="lead">Panduan Lengkap Lembaga Kesejahteraan Sosial</p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <i class="bi bi-journal-text" style="font-size: 8rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ count($guides) }}</h4>
                                <small>Total Panduan</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-journal-text fs-1 opacity-50"></i>
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
                                <h4 class="mb-0">{{ $totalSize }}</h4>
                                <small>Total Ukuran</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-hdd fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ array_sum(array_column($guides, 'download_count')) }}</h4>
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
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ count(array_unique(array_column($guides, 'category'))) }}</h4>
                                <small>Kategori</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-tags fs-1 opacity-50"></i>
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
                                    <span class="input-group-text bg-success text-white">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Cari panduan..." id="searchInput">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="categoryFilter">
                                    <option value="">Semua Kategori</option>
                                    <option value="Pendaftaran">Pendaftaran</option>
                                    <option value="Formulir">Formulir</option>
                                    <option value="Operasional">Operasional</option>
                                    <option value="Monev">Monev</option>
                                    <option value="Keuangan">Keuangan</option>
                                    <option value="Sertifikasi">Sertifikasi</option>
                                    <option value="Administrasi">Administrasi</option>
                                    <option value="Laporan">Laporan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="formatFilter">
                                    <option value="">Semua Format</option>
                                    <option value="PDF">PDF</option>
                                    <option value="DOCX">DOCX</option>
                                    <option value="DOC">DOC</option>
                                    <option value="PPT">PPT</option>
                                    <option value="PPTX">PPTX</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Panduan -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success">
                    <h5 class="alert-heading">
                        <i class="bi bi-info-circle"></i> Informasi Panduan
                    </h5>
                    <p class="mb-0">
                        Berikut adalah kumpulan panduan lengkap untuk proses pendaftaran, pengisian formulir, 
                        dan operasional Lembaga Kesejahteraan Sosial (LKS). Silakan unduh panduan yang diperlukan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Daftar Panduan -->
        <div class="row" id="guidesContainer">
            @foreach($guides as $guide)
            <div class="col-md-6 col-lg-4 mb-4 guide-card">
                <div class="card h-100 border-success">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="bi {{ $guide['icon'] }}"></i> {{ $guide['category'] }}
                        </h6>
                        <span class="badge bg-light text-dark">{{ $guide['format'] }}</span>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi {{ $guide['icon'] }} fs-4"></i>
                            </div>
                        </div>
                        <h5 class="card-title text-success fw-bold">{{ $guide['title'] }}</h5>
                        <p class="card-text text-muted small">{{ $guide['description'] }}</p>
                        
                        <div class="guide-meta mb-3">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-file-arrow-down"></i> {{ $guide['file_size'] }}</span>
                                <span><i class="bi bi-download"></i> {{ $guide['download_count'] }}x</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-calendar"></i> {{ $guide['last_updated'] }}
                                </span>
                                @if($guide['download_count'] > 500)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> Popular
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('announcements.download', ['type' => 'panduan', 'filename' => $guide['file_name']]) }}" 
                               class="btn btn-success download-btn" 
                               data-filename="{{ $guide['file_name'] }}"
                               data-title="{{ $guide['title'] }}">
                                <i class="bi bi-download"></i> Unduh Panduan
                            </a>
                            @if(pathinfo($guide['file_name'], PATHINFO_EXTENSION) === 'pdf')
                            <a href="{{ route('announcements.preview', ['type' => 'panduan', 'filename' => $guide['file_name']]) }}" 
                               target="_blank"
                               class="btn btn-outline-success">
                                <i class="bi bi-eye"></i> Preview
                            </a>
                            @else
                            <button class="btn btn-outline-secondary" disabled>
                                <i class="bi bi-eye"></i> Preview (PDF Only)
                            </button>
                            @endif

                            @if(isset($guide['id']))
                            <form action="{{ route('announcements.destroy', ['id' => $guide['id']]) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');">
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
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning"></i> Akses Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center justify-content-center">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('announcements.create') }}" class="btn btn-success btn-lg w-100">
                                    <i class="bi bi-plus-circle"></i><br>
                                    <small>Tambah Dokumen</small>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-outline-success btn-lg w-100" onclick="location.reload()">
                                    <i class="bi bi-arrow-clockwise"></i><br>
                                    <small>Refresh Data</small>
                                </button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-outline-success btn-lg w-100" id="exportBtn">
                                    <i class="bi bi-download"></i><br>
                                    <small>Export List</small>
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
                <h5 class="modal-title text-success">
                    <i class="bi bi-download"></i> Konfirmasi Download Panduan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan mengunduh panduan:</p>
                <div class="alert alert-success">
                    <strong id="downloadTitle"></strong>
                </div>
                <p class="text-muted small">
    <i class="bi bi-info-circle"></i> 
    File panduan akan diunduh dalam format {{ strtoupper(pathinfo($guides[0]['file_name'] ?? '', PATHINFO_EXTENSION)) }}.
</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-success" id="confirmDownloadLink">
                    <i class="bi bi-download"></i> Download Panduan
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
    box-shadow: 0 8px 25px rgba(25, 135, 84, 0.15);
}

.border-success {
    border: 2px solid #198754 !important;
}

.guide-meta {
    border-top: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
    padding: 10px 0;
}

/* Popular badge animation */
.badge.bg-warning {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Statistics cards hover effect */
.card.bg-success, .card.bg-primary, .card.bg-warning, .card.bg-info {
    transition: transform 0.2s ease-in-out;
}

.card.bg-success:hover, .card.bg-primary:hover, 
.card.bg-warning:hover, .card.bg-info:hover {
    transform: translateY(-3px);
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

    // Search and Filter functionality
    function filterGuides() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value;
        const formatFilter = document.getElementById('formatFilter').value;
        
        const cards = document.querySelectorAll('.guide-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const category = card.querySelector('.card-header h6').textContent;
            const format = card.querySelector('.card-header .badge').textContent;
            
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = !categoryFilter || category.includes(categoryFilter);
            const matchesFormat = !formatFilter || format === formatFilter;
            
            if (matchesSearch && matchesCategory && matchesFormat) {
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
                const container = document.getElementById('guidesContainer');
                const message = document.createElement('div');
                message.id = 'noResults';
                message.className = 'col-12 text-center py-5';
                message.innerHTML = `
                    <div class="text-muted">
                        <i class="bi bi-search fs-1"></i>
                        <h4 class="mt-3">Tidak ada panduan yang ditemukan</h4>
                        <p>Coba gunakan kata kunci atau filter yang berbeda</p>
                    </div>
                `;
                container.appendChild(message);
            }
        } else if (noResults) {
            noResults.remove();
        }
    }

    document.getElementById('searchInput').addEventListener('input', filterGuides);
    document.getElementById('categoryFilter').addEventListener('change', filterGuides);
    document.getElementById('formatFilter').addEventListener('change', filterGuides);

    // Export button functionality
    document.getElementById('exportBtn').addEventListener('click', function() {
        const alert = document.createElement('div');
        alert.className = 'alert alert-info alert-dismissible fade show position-fixed';
        alert.style.top = '20px';
        alert.style.right = '20px';
        alert.style.zIndex = '9999';
        alert.style.minWidth = '300px';
        alert.innerHTML = `
            <i class="bi bi-info-circle"></i> 
            <strong>Export:</strong> Fitur export akan segera tersedia.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 4000);
    });
});
</script>
@endpush