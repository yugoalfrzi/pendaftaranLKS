@extends('layouts.app')

@section('title', 'Peraturan Perundang-Undangan LKS')
@section('page-title', 'Regulasi')

@section('content')
<style>
    /* Gaya modern khas SIPINJAM */
    .hero-gradient {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
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
        background: #eef2ff;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
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
    .regulation-item {
        margin-bottom: 1.2rem;
    }
    .regulation-card {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid #edf2f7;
        transition: all 0.2s;
        overflow: hidden;
    }
    .regulation-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }
    .regulation-icon {
        width: 48px;
        height: 48px;
        background: #eef2ff;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #2563eb;
    }
    .badge-category {
        font-size: 0.7rem;
        padding: 0.2rem 0.7rem;
        border-radius: 2rem;
        font-weight: 500;
    }
    .badge-undang { background: #fee2e2; color: #b91c1c; }
    .badge-pp { background: #fef3c7; color: #b45309; }
    .badge-permen { background: #e0e7ff; color: #1e40af; }
    .badge-perda { background: #e6f7e6; color: #2e7d32; }
    .badge-surat { background: #f3e8ff; color: #6b21a5; }
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
    .info-alert {
        background: #eef2ff;
        border-left: 4px solid #2563eb;
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 768px) {
        .hero-gradient { padding: 1.5rem; }
        .stat-value { font-size: 1.4rem; }
        .regulation-icon { width: 40px; height: 40px; font-size: 1.2rem; }
    }
</style>

<!-- Hero Section -->
<div class="hero-gradient text-white">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h1 class="display-5 fw-bold mb-3">
                <i class="bi bi-journal-bookmark-fill me-2"></i> Peraturan Perundang-Undangan
            </h1>
            <p class="lead mb-0">Mengenai Lembaga Kesejahteraan Sosial (LKS) di Indonesia</p>
        </div>
        <div class="col-md-5 text-center">
            <i class="bi bi-file-earmark-text" style="font-size: 6rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Regulasi</div>
                    <div class="stat-value">{{ count($regulations) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Jenis Regulasi</div>
                    <div class="stat-value">{{ count(array_unique(array_column($regulations, 'category'))) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-tags"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Download</div>
                    <div class="stat-value">{{ number_format(array_sum(array_column($regulations, 'download_count'))) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-download"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Tahun Terbaru</div>
                    <div class="stat-value">{{ !empty($years) ? max($years) : date('Y') }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-calendar"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Penting -->
<div class="info-alert">
    <div class="d-flex gap-3 align-items-start">
        <i class="bi bi-info-circle-fill fs-4 text-primary"></i>
        <div>
            <h6 class="fw-semibold mb-1">Informasi Penting</h6>
            <p class="mb-0 small text-secondary">Berikut adalah kumpulan peraturan perundang-undangan yang mengatur tentang Lembaga Kesejahteraan Sosial (LKS). Silakan unduh dokumen yang diperlukan untuk referensi dalam proses pendaftaran dan pengelolaan LKS.</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-card">
    <div class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Cari Regulasi</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 ps-0" placeholder="Judul atau kata kunci..." id="searchInput">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Kategori</label>
            <select class="form-select" id="categoryFilter">
                <option value="">Semua Kategori</option>
                <option value="Undang-Undang">Undang-Undang</option>
                <option value="Peraturan Pemerintah">Peraturan Pemerintah</option>
                <option value="Peraturan Menteri">Peraturan Menteri</option>
                <option value="Peraturan Daerah">Peraturan Daerah</option>
                <option value="Surat Edaran">Surat Edaran</option>
                <option value="Surat Pengajuan">Surat Pengajuan</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Tahun</label>
            <select class="form-select" id="yearFilter">
                <option value="">Semua Tahun</option>
                @php
                    $years = array_unique(array_column($regulations, 'year'));
                    rsort($years);
                @endphp
                @foreach($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button class="btn btn-outline-secondary w-100" onclick="resetFilters()" title="Reset Filter">
                <i class="bi bi-arrow-repeat"></i>
            </button>
        </div>
    </div>
</div>

<!-- Daftar Regulasi -->
<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-book me-2"></i> Daftar Peraturan Perundang-Undangan
    </div>
    <div class="card-body p-4">
        <div class="row" id="regulationsContainer">
            @forelse($regulations as $regulation)
            <div class="col-md-6 regulation-item">
                <div class="regulation-card p-3">
                    <div class="d-flex gap-3">
                        <div class="regulation-icon flex-0">
                            <i class="bi {{ $regulation['icon'] ?? 'bi-file-earmark-text' }}"></i>
                        </div>
                        <div class="flex-1">
                            <h6 class="fw-bold mb-1">{{ $regulation['title'] }}</h6>
                            <p class="small text-secondary mb-2">{{ $regulation['description'] }}</p>
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div class="d-flex gap-2 align-items-center">
                                    @php
                                        $cat = $regulation['category'];
                                        $badgeClass = match($cat) {
                                            'Undang-Undang' => 'badge-undang',
                                            'Peraturan Pemerintah' => 'badge-pp',
                                            'Peraturan Menteri' => 'badge-permen',
                                            'Peraturan Daerah' => 'badge-perda',
                                            default => 'badge-surat'
                                        };
                                    @endphp
                                    <span class="badge-category {{ $badgeClass }}">{{ $cat }}</span>
                                    <small class="text-muted"><i class="bi bi-calendar3"></i> {{ $regulation['year'] }}</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <small class="text-muted"><i class="bi bi-download"></i> {{ number_format($regulation['download_count']) }}</small>
                                    <small class="text-muted">{{ $regulation['file_size'] }}</small>
                                </div>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('announcements.download', ['type' => 'regulasi', 'filename' => $regulation['file_name']]) }}" 
                                   class="btn btn-sm btn-primary rounded-pill px-3 download-btn"
                                   data-filename="{{ $regulation['file_name'] }}"
                                   data-title="{{ $regulation['title'] }}">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                @if(pathinfo($regulation['file_name'], PATHINFO_EXTENSION) === 'pdf')
                                <a href="{{ route('announcements.preview', ['type' => 'regulasi', 'filename' => $regulation['file_name']]) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="bi bi-eye"></i> Preview
                                </a>
                                @endif
                                @auth
                                    @if(Auth::user()->hasRole('admin') && isset($regulation['id']))
                                    <form action="{{ route('announcements.destroy', ['id' => $regulation['id']]) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="bi bi-trash3"></i> Hapus
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
                <p>Belum ada regulasi yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
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
                            <a href="{{ route('announcements.create') }}" class="btn btn-primary w-100 py-2 rounded-pill">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Dokumen Regulasi
                            </a>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-secondary w-100 py-2 rounded-pill" onclick="location.reload()">
                                <i class="bi bi-arrow-repeat me-1"></i> Refresh Data
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
                <h5 class="modal-title fw-bold text-primary">
                    <i class="bi bi-download me-2"></i> Konfirmasi Download
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan mengunduh dokumen:</p>
                <div class="alert alert-info py-2 rounded-pill">
                    <strong id="downloadTitle"></strong>
                </div>
                <p class="text-muted small mb-0">
                    <i class="bi bi-info-circle"></i> Pastikan koneksi internet Anda stabil.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-primary rounded-pill px-4" id="confirmDownloadLink">
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
    function filterRegulations() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value;
        const yearFilter = document.getElementById('yearFilter').value;
        
        const items = document.querySelectorAll('.regulation-item');
        let visibleCount = 0;
        
        items.forEach(item => {
            const title = item.querySelector('.fw-bold').textContent.toLowerCase();
            const categoryElem = item.querySelector('.badge-category');
            const category = categoryElem ? categoryElem.textContent : '';
            const yearElem = item.querySelector('.bi-calendar3')?.parentNode;
            const year = yearElem ? yearElem.textContent.trim() : '';
            
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = !categoryFilter || category.includes(categoryFilter);
            const matchesYear = !yearFilter || year.includes(yearFilter);
            
            if (matchesSearch && matchesCategory && matchesYear) {
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
                const container = document.getElementById('regulationsContainer');
                const message = document.createElement('div');
                message.id = 'noResults';
                message.className = 'col-12 text-center py-5 text-muted';
                message.innerHTML = `
                    <i class="bi bi-search fs-1 d-block mb-2"></i>
                    <p>Tidak ada regulasi yang ditemukan</p>
                    <small>Coba gunakan kata kunci atau filter yang berbeda</small>
                `;
                container.appendChild(message);
            }
        } else if (noResults) {
            noResults.remove();
        }
    }

    document.getElementById('searchInput').addEventListener('input', filterRegulations);
    document.getElementById('categoryFilter').addEventListener('change', filterRegulations);
    document.getElementById('yearFilter').addEventListener('change', filterRegulations);
});

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('yearFilter').value = '';
    // Trigger filter
    const event = new Event('input');
    document.getElementById('searchInput').dispatchEvent(event);
    document.getElementById('categoryFilter').dispatchEvent(new Event('change'));
    document.getElementById('yearFilter').dispatchEvent(new Event('change'));
}
</script>
@endpush