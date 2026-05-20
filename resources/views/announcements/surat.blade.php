@extends('layouts.app')

@section('title', 'Surat LKS')
@section('page-title', 'Surat')

@section('content')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
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
        background: #fef3c7;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #eab308;
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
    .letter-item {
        margin-bottom: 1.2rem;
    }
    .letter-card {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid #edf2f7;
        transition: all 0.2s;
        overflow: hidden;
        height: 100%;
    }
    .letter-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }
    .letter-icon {
        width: 48px;
        height: 48px;
        background: #fef3c7;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #eab308;
    }
    .badge-category {
        font-size: 0.7rem;
        padding: 0.2rem 0.7rem;
        border-radius: 2rem;
        font-weight: 500;
        background: #fef3c7;
        color: #b45309;
    }
    .info-alert {
        background: #fef3c7;
        border-left: 4px solid #eab308;
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 768px) {
        .hero-gradient { padding: 1.5rem; }
        .stat-value { font-size: 1.4rem; }
        .letter-icon { width: 40px; height: 40px; font-size: 1.2rem; }
    }
</style>

<!-- Hero Section -->
<div class="hero-gradient text-white">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h1 class="display-5 fw-bold mb-3">
                <i class="bi bi-envelope-paper-fill me-2"></i> Surat LKS
            </h1>
            <p class="lead mb-0">Template Surat Resmi Lembaga Kesejahteraan Sosial</p>
        </div>
        <div class="col-md-5 text-center">
            <i class="bi bi-envelope-paper" style="font-size: 6rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Template</div>
                    <div class="stat-value">{{ count($letters) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-envelope"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Template Aktif</div>
                    <div class="stat-value">{{ $activeTemplates ?? count($letters) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Download</div>
                    <div class="stat-value">{{ number_format(array_sum(array_column($letters, 'download_count'))) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-download"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Tahun Berjalan</div>
                    <div class="stat-value">{{ $currentYear ?? date('Y') }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-calendar"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Penting -->
<div class="info-alert">
    <div class="d-flex gap-3 align-items-start">
        <i class="bi bi-info-circle-fill fs-4 text-warning"></i>
        <div>
            <h6 class="fw-semibold mb-1">Informasi Template Surat</h6>
            <p class="mb-0 small text-secondary">Berikut adalah kumpulan template surat resmi untuk keperluan administrasi Lembaga Kesejahteraan Sosial (LKS). Silakan unduh dan sesuaikan dengan kebutuhan Anda.</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-card">
    <div class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Template</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 ps-0" placeholder="Judul atau kata kunci..." id="searchInput">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Jenis Surat</label>
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
            <label class="form-label small fw-semibold">Format</label>
            <select class="form-select" id="formatFilter">
                <option value="">Semua Format</option>
                <option value="DOCX">DOCX</option>
                <option value="DOC">DOC</option>
                <option value="PDF">PDF</option>
            </select>
        </div>
        <div class="col-md-1">
            <button class="btn btn-outline-secondary w-100" onclick="resetFilters()" title="Reset Filter">
                <i class="bi bi-arrow-repeat"></i>
            </button>
        </div>
    </div>
</div>

<!-- Daftar Surat -->
<div class="row" id="lettersContainer">
    @forelse($letters as $letter)
    <div class="col-md-6 col-lg-4 letter-item">
        <div class="letter-card p-3">
            <div class="d-flex gap-3">
                <div class="letter-icon flex-0">
                    <i class="bi {{ $letter['icon'] ?? 'bi-envelope-paper' }}"></i>
                </div>
                <div class="flex-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="fw-bold mb-1">{{ $letter['title'] }}</h6>
                        <span class="badge bg-light text-dark">{{ $letter['format'] }}</span>
                    </div>
                    <p class="small text-secondary mb-2">{{ $letter['description'] }}</p>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="d-flex gap-2">
                            <span class="badge-category">{{ $letter['type'] }}</span>
                            <small class="text-muted"><i class="bi bi-calendar3"></i> {{ $letter['date'] ?? $letter['year'] ?? '-' }}</small>
                        </div>
                        <div class="d-flex gap-2">
                            <small class="text-muted"><i class="bi bi-download"></i> {{ number_format($letter['download_count']) }}</small>
                            <small class="text-muted">{{ $letter['file_size'] }}</small>
                        </div>
                    </div>
                    @if(($letter['download_count'] ?? 0) > 200)
                    <div class="mt-2">
                        <span class="badge bg-success text-white"><i class="bi bi-star-fill"></i> Recommended</span>
                    </div>
                    @endif
                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('announcements.download', ['type' => 'surat', 'filename' => $letter['file_name']]) }}" 
                           class="btn btn-sm btn-warning rounded-pill px-3 download-btn"
                           data-filename="{{ $letter['file_name'] }}"
                           data-title="{{ $letter['title'] }}">
                            <i class="bi bi-download"></i> Download
                        </a>
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 edit-btn" data-title="{{ $letter['title'] }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        @auth
                            @if(Auth::user()->hasRole('admin') && isset($letter['id']))
                            <form action="{{ route('announcements.destroy', ['id' => $letter['id']]) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');" class="d-inline">
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
        <p>Belum ada template surat yang tersedia.</p>
    </div>
    @endforelse
</div>

<!-- Quick Actions (Admin only) -->
@auth
@if(Auth::user()->hasRole('admin'))
<div class="row mt-4">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header-custom">
                <i class="bi bi-lightning me-2"></i> Akses Cepat
            </div>
            <div class="card-body p-4">
                <div class="row g-3 justify-content-center">
                    <div class="col-md-4">
                        <a href="{{ route('announcements.create') }}" class="btn btn-warning w-100 py-2 rounded-pill">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Template Surat
                        </a>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-secondary w-100 py-2 rounded-pill" onclick="location.reload()">
                            <i class="bi bi-arrow-repeat me-1"></i> Refresh Data
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-warning w-100 py-2 rounded-pill" id="quickTemplateBtn">
                            <i class="bi bi-lightning me-1"></i> Buat Cepat
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
                <h5 class="modal-title fw-bold text-warning">
                    <i class="bi bi-download me-2"></i> Konfirmasi Download Template
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan mengunduh template surat:</p>
                <div class="alert alert-warning py-2 rounded-pill">
                    <strong id="downloadTitle"></strong>
                </div>
                <p class="text-muted small mb-0">
                    <i class="bi bi-info-circle"></i> File akan diunduh dalam format yang dapat diedit.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-warning rounded-pill px-4" id="confirmDownloadLink">
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

    // Edit button dummy
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert('Fitur edit template akan segera tersedia.');
        });
    });

    // Quick template button
    const quickBtn = document.getElementById('quickTemplateBtn');
    if (quickBtn) {
        quickBtn.addEventListener('click', function() {
            alert('Fitur buat cepat akan segera tersedia.');
        });
    }

    // Filter functions
    function filterLetters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value;
        const formatFilter = document.getElementById('formatFilter').value;
        
        const items = document.querySelectorAll('.letter-item');
        let visibleCount = 0;
        
        items.forEach(item => {
            const title = item.querySelector('.fw-bold').textContent.toLowerCase();
            const typeElem = item.querySelector('.badge-category');
            const type = typeElem ? typeElem.textContent : '';
            const formatElem = item.querySelector('.badge.bg-light');
            const format = formatElem ? formatElem.textContent : '';
            
            const matchesSearch = title.includes(searchTerm);
            const matchesType = !typeFilter || type.includes(typeFilter);
            const matchesFormat = !formatFilter || format === formatFilter;
            
            if (matchesSearch && matchesType && matchesFormat) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        let noResults = document.getElementById('noResults');
        if (visibleCount === 0) {
            if (!noResults) {
                const container = document.getElementById('lettersContainer');
                const message = document.createElement('div');
                message.id = 'noResults';
                message.className = 'col-12 text-center py-5 text-muted';
                message.innerHTML = `
                    <i class="bi bi-search fs-1 d-block mb-2"></i>
                    <p>Tidak ada template surat yang ditemukan</p>
                    <small>Coba gunakan kata kunci atau filter yang berbeda</small>
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

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('typeFilter').value = '';
    document.getElementById('formatFilter').value = '';
    document.getElementById('searchInput').dispatchEvent(new Event('input'));
    document.getElementById('typeFilter').dispatchEvent(new Event('change'));
    document.getElementById('formatFilter').dispatchEvent(new Event('change'));
}
</script>
@endpush