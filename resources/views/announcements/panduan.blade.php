@extends('layouts.app')

@section('title', 'Panduan LKS')
@section('page-title', 'Panduan')

@section('content')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #198754 0%, #0f5c3a 100%);
        border-radius: 1.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid rgba(203, 213, 225, 0.4);
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -12px rgba(0,0,0,0.1);
        border-color: #cbd5e1;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        background: #e6f7e6;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #198754;
        font-size: 1.4rem;
    }
    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .filter-card {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid #edf2f7;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
    }
    .guide-item {
        margin-bottom: 1.2rem;
    }
    .guide-card {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid #edf2f7;
        transition: all 0.2s;
        overflow: hidden;
        height: 100%;
    }
    .guide-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }
    .guide-icon {
        width: 48px;
        height: 48px;
        background: #e6f7e6;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #198754;
    }
    .badge-category {
        font-size: 0.7rem;
        padding: 0.2rem 0.7rem;
        border-radius: 2rem;
        font-weight: 500;
        background: #e6f7e6;
        color: #198754;
    }
    .info-alert {
        background: #e6f7e6;
        border-left: 4px solid #198754;
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .btn-outline-soft {
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        border-radius: 2rem;
        padding: 0.25rem 0.8rem;
        font-size: 0.75rem;
        transition: 0.2s;
    }
    .btn-outline-soft:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    @media (max-width: 768px) {
        .hero-gradient { padding: 1.5rem; }
        .stat-value { font-size: 1.4rem; }
        .guide-icon { width: 40px; height: 40px; font-size: 1.2rem; }
    }
</style>

<!-- Hero Section -->
<div class="hero-gradient text-white">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h1 class="display-5 fw-bold mb-3">
                <i class="bi bi-journal-bookmark-fill me-2"></i> Panduan LKS
            </h1>
            <p class="lead mb-0">Panduan Lengkap Lembaga Kesejahteraan Sosial</p>
        </div>
        <div class="col-md-5 text-center">
            <i class="bi bi-journal-text" style="font-size: 6rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Panduan</div>
                    <div class="stat-value">{{ count($guides) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Ukuran</div>
                    <div class="stat-value">{{ $totalSize }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-hdd-stack"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Download</div>
                    <div class="stat-value">{{ number_format(array_sum(array_column($guides, 'download_count'))) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-download"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Kategori</div>
                    <div class="stat-value">{{ count(array_unique(array_column($guides, 'category'))) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-tags"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Penting -->
<div class="info-alert">
    <div class="d-flex gap-3 align-items-start">
        <i class="bi bi-info-circle-fill fs-4 text-success"></i>
        <div>
            <h6 class="fw-semibold mb-1">Informasi Panduan</h6>
            <p class="mb-0 small text-secondary">Berikut adalah kumpulan panduan lengkap untuk proses pendaftaran, pengisian formulir, dan operasional Lembaga Kesejahteraan Sosial (LKS). Silakan unduh panduan yang diperlukan.</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-card">
    <div class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Panduan</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 ps-0" placeholder="Judul atau kata kunci..." id="searchInput">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Kategori</label>
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
            <label class="form-label small fw-semibold">Format</label>
            <select class="form-select" id="formatFilter">
                <option value="">Semua Format</option>
                <option value="PDF">PDF</option>
                <option value="DOCX">DOCX</option>
                <option value="DOC">DOC</option>
                <option value="PPT">PPT</option>
                <option value="PPTX">PPTX</option>
            </select>
        </div>
        <div class="col-md-1">
            <button class="btn btn-outline-secondary w-100" onclick="resetFilters()" title="Reset Filter">
                <i class="bi bi-arrow-repeat"></i>
            </button>
        </div>
    </div>
</div>

<!-- Daftar Panduan -->
<div class="row" id="guidesContainer">
    @forelse($guides as $guide)
    <div class="col-md-6 col-lg-4 guide-item">
        <div class="guide-card p-3">
            <div class="d-flex gap-3">
                <div class="guide-icon flex-0">
                    <i class="bi {{ $guide['icon'] ?? 'bi-file-earmark-text' }}"></i>
                </div>
                <div class="flex-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="fw-bold mb-1">{{ $guide['title'] }}</h6>
                        <span class="badge bg-light text-dark">{{ $guide['format'] }}</span>
                    </div>
                    <p class="small text-secondary mb-2">{{ $guide['description'] }}</p>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="d-flex gap-2">
                            <span class="badge-category">{{ $guide['category'] }}</span>
                            <small class="text-muted"><i class="bi bi-calendar3"></i> {{ $guide['last_updated'] }}</small>
                        </div>
                        <div class="d-flex gap-2">
                            <small class="text-muted"><i class="bi bi-download"></i> {{ number_format($guide['download_count']) }}</small>
                            <small class="text-muted">{{ $guide['file_size'] }}</small>
                        </div>
                    </div>
                    @if($guide['download_count'] > 500)
                    <div class="mt-2">
                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Popular</span>
                    </div>
                    @endif
                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('announcements.download', ['type' => 'panduan', 'filename' => $guide['file_name']]) }}" 
                           class="btn btn-sm btn-success rounded-pill px-3 download-btn"
                           data-filename="{{ $guide['file_name'] }}"
                           data-title="{{ $guide['title'] }}">
                            <i class="bi bi-download"></i> Download
                        </a>
                        @if(pathinfo($guide['file_name'], PATHINFO_EXTENSION) === 'pdf')
                        <a href="{{ route('announcements.preview', ['type' => 'panduan', 'filename' => $guide['file_name']]) }}" 
                           target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-eye"></i> Preview
                        </a>
                        @endif
                        @auth
                            @if(Auth::user()->hasRole('admin') && isset($guide['id']))
                            <form action="{{ route('announcements.destroy', ['id' => $guide['id']]) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <p>Belum ada panduan yang tersedia.</p>
    </div>
    @endforelse
</div>

<!-- Quick Actions (Admin only) -->
@auth
@if(Auth::user()->hasRole('super_admin'))
<div class="row mt-4">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header-custom">
                <i class="bi bi-lightning me-2"></i> Akses Cepat
            </div>
            <div class="card-body p-4">
                <div class="row g-3 justify-content-center">
                    <div class="col-md-4">
                        <a href="{{ route('announcements.create') }}" class="btn btn-success w-100 py-2 rounded-pill">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Dokumen Panduan
                        </a>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-secondary w-100 py-2 rounded-pill" onclick="location.reload()">
                            <i class="bi bi-arrow-repeat me-1"></i> Refresh Data
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-success w-100 py-2 rounded-pill" id="exportBtn">
                            <i class="bi bi-download me-1"></i> Export List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endauth

<!-- Modal Konfirmasi Download -->
<div class="modal fade" id="downloadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success">
                    <i class="bi bi-download me-2"></i> Konfirmasi Download Panduan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan mengunduh panduan:</p>
                <div class="alert alert-success py-2 rounded-pill">
                    <strong id="downloadTitle"></strong>
                </div>
                <p class="text-muted small mb-0">
                    <i class="bi bi-info-circle"></i> Pastikan koneksi internet Anda stabil.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-success rounded-pill px-4" id="confirmDownloadLink">
                    <i class="bi bi-download me-1"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal download
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

    // Filter functions
    function filterGuides() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value;
        const formatFilter = document.getElementById('formatFilter').value;
        
        const items = document.querySelectorAll('.guide-item');
        let visibleCount = 0;
        
        items.forEach(item => {
            const title = item.querySelector('.fw-bold').textContent.toLowerCase();
            const categoryElem = item.querySelector('.badge-category');
            const category = categoryElem ? categoryElem.textContent : '';
            const formatElem = item.querySelector('.badge.bg-light');
            const format = formatElem ? formatElem.textContent : '';
            
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = !categoryFilter || category.includes(categoryFilter);
            const matchesFormat = !formatFilter || format === formatFilter;
            
            if (matchesSearch && matchesCategory && matchesFormat) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide no results
        let noResults = document.getElementById('noResults');
        if (visibleCount === 0) {
            if (!noResults) {
                const container = document.getElementById('guidesContainer');
                const message = document.createElement('div');
                message.id = 'noResults';
                message.className = 'col-12 text-center py-5 text-muted';
                message.innerHTML = `
                    <i class="bi bi-search fs-1 d-block mb-2"></i>
                    <p>Tidak ada panduan yang ditemukan</p>
                    <small>Coba gunakan kata kunci atau filter yang berbeda</small>
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

    // Export dummy
    const exportBtn = document.getElementById('exportBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            alert('Fitur export akan segera tersedia.');
        });
    }
});

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('formatFilter').value = '';
    document.getElementById('searchInput').dispatchEvent(new Event('input'));
    document.getElementById('categoryFilter').dispatchEvent(new Event('change'));
    document.getElementById('formatFilter').dispatchEvent(new Event('change'));
}
</script>
@endpush