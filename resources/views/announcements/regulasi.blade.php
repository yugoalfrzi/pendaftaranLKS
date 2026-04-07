@extends('layouts.app')

@section('title', 'Peraturan Perundang-Undangan LKS')
@section('page-title', 'Regulasi')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header Section -->
        <div class="card mb-4" style="background: linear-gradient(135deg, #178fff 0%, #0166e2 100%); color: white;">
            <div class="card-body text-center py-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="display-4 fw-bold mb-3">
                            <i class="bi bi-book"></i>
                            PERATURAN PERUNDANG-UNDANGAN
                        </h1>
                        <p class="lead">Mengenai Lembaga Kesejahteraan Sosial (LKS)</p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <i class="bi bi-file-earmark-text" style="font-size: 8rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ count($regulations) }}</h4>
                                <small>Total Regulasi</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-journal-text fs-1 opacity-50"></i>
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
                                <h4 class="mb-0">{{ count(array_unique(array_column($regulations, 'category'))) }}</h4>
                                <small>Jenis Regulasi</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-tags fs-1 opacity-50"></i>
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
                                <h4 class="mb-0">{{ array_sum(array_column($regulations, 'download_count')) }}</h4>
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
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                @php
                                    $years = array_column($regulations, 'year');
                                    $latestYear = !empty($years) ? max($years) : date('Y');
                                @endphp
                                <h4 class="mb-0">{{ $latestYear }}</h4>
                                <small>Tahun Terbaru</small>
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
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Cari regulasi..." id="searchInput">
                                </div>
                            </div>
                            <div class="col-md-3">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Peraturan -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5 class="alert-heading">
                        <i class="bi bi-info-circle"></i> Informasi Penting
                    </h5>
                    <p class="mb-0">
                        Berikut adalah kumpulan peraturan perundang-undangan yang mengatur tentang Lembaga Kesejahteraan Sosial (LKS). 
                        Silakan unduh dokumen yang diperlukan untuk referensi dalam proses pendaftaran dan pengelolaan LKS.
                    </p>
                </div>
            </div>
        </div>

        <!-- Peraturan Perundang-Undangan -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-book"></i> Daftar Peraturan Perundang-Undangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row" id="regulationsContainer">
                            @foreach($regulations as $regulation)
                            <div class="col-md-6 mb-4 regulation-card">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="shrink-0 me-3">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="bi {{ $regulation['icon'] }}"></i>
                                                </div>
                                            </div>
                                            <div class="grow 1">
                                                <h6 class="card-title fw-bold text-primary mb-2">
                                                    {{ $regulation['title'] }}
                                                </h6>
                                                <p class="card-text text-muted small mb-2">
                                                    {{ $regulation['description'] }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        @php
                                                            $badgeClass = match($regulation['category']) {
                                                                'Undang-Undang' => 'danger',
                                                                'Peraturan Pemerintah' => 'warning',
                                                                'Peraturan Menteri' => 'info',
                                                                'Peraturan Daerah' => 'success',
                                                                default => 'secondary'
                                                            };
                                                        @endphp
                                                        <span class="badge bg-{{ $badgeClass }} me-2">
                                                            {{ $regulation['category'] }}
                                                        </span>
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar"></i> {{ $regulation['year'] }}
                                                        </small>
                                                    </div>
                                                    <div class="text-end">
                                                        <small class="text-muted d-block">
                                                            <i class="bi bi-download"></i> {{ $regulation['download_count'] }} downloads
                                                        </small>
                                                        <small class="text-muted d-block mb-1">{{ $regulation['file_size'] }}</small>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('announcements.download', ['type' => 'regulasi', 'filename' => $regulation['file_name']]) }}" 
                                                               class="btn btn-outline-primary btn-sm download-btn"
                                                               data-filename="{{ $regulation['file_name'] }}"
                                                               data-title="{{ $regulation['title'] }}">
                                                                <i class="bi bi-download"></i> Download
                                                            </a>
                                                            @if(pathinfo($regulation['file_name'], PATHINFO_EXTENSION) === 'pdf')
                                                            <a href="{{ route('announcements.preview', ['type' => 'regulasi', 'filename' => $regulation['file_name']]) }}" 
                                                               target="_blank"
                                                               class="btn btn-outline-info btn-sm">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            @endif

                                                            @if(isset($regulation['id']))
                                                            <form action="{{ route('announcements.destroy', ['id' => $regulation['id']]) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning"></i> Akses Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center justify-content-center">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('announcements.create') }}" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-plus-circle"></i><br>
                                    <small>Tambah Dokumen</small>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-outline-primary btn-lg w-100" onclick="location.reload()">
                                    <i class="bi bi-arrow-clockwise"></i><br>
                                    <small>Refresh Data</small>
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
                <h5 class="modal-title text-primary">
                    <i class="bi bi-download"></i> Konfirmasi Download
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan mengunduh dokumen:</p>
                <div class="alert alert-info">
                    <strong id="downloadTitle"></strong>
                </div>
                <p class="text-muted small">
                    <i class="bi bi-info-circle"></i> 
                    Pastikan koneksi internet Anda stabil untuk proses download.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-primary" id="confirmDownloadLink">
                    <i class="bi bi-download"></i> Download
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
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.regulation-card .card {
    border-left: 4px solid #007bff;
}

.bg-danger { background-color: #dc3545 !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-info { background-color: #17a2b8 !important; }
.bg-success { background-color: #28a745 !important; }
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
    function filterRegulations() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value;
        const yearFilter = document.getElementById('yearFilter').value;
        
        const cards = document.querySelectorAll('.regulation-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const category = card.querySelector('.badge').textContent;
            const year = card.querySelector('.text-muted .bi-calendar').parentNode.textContent.trim();
            
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = !categoryFilter || category.includes(categoryFilter);
            const matchesYear = !yearFilter || year.includes(yearFilter);
            
            if (matchesSearch && matchesCategory && matchesYear) {
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
                const container = document.getElementById('regulationsContainer');
                const message = document.createElement('div');
                message.id = 'noResults';
                message.className = 'col-12 text-center py-5';
                message.innerHTML = `
                    <div class="text-muted">
                        <i class="bi bi-search fs-1"></i>
                        <h4 class="mt-3">Tidak ada regulasi yang ditemukan</h4>
                        <p>Coba gunakan kata kunci atau filter yang berbeda</p>
                    </div>
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
</script>
@endpush