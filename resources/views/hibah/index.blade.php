@extends('layouts.app')

@section('content')
<style>
    .card {
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem;
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }
    
    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 50rem;
        padding: 0.3rem 0.6rem;
    }
    
    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .file-link {
        color: #0d6efd;
        text-decoration: none;
        font-size: 0.875rem;
    }
    
    .file-link:hover {
        text-decoration: underline;
    }
    
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }
    
    .empty-state-row td {
        border: 0 !important;
        padding-top: 1rem !important;
        padding-bottom: 2rem !important;
    }
    
    .progress-info {
        font-size: 0.75rem;
        color: #6c757d;
    }
    
    .progress {
        height: 6px;
        margin-top: 0.25rem;
    }
    
    .progress-bar {
        border-radius: 1rem;
    }
    
    .document-count {
        font-size: 0.7rem;
        color: #6c757d;
    }
    
    .filter-card .card-body {
        padding: 1.25rem;
    }
    
    .stat-card {
        transition: transform 0.2s ease-in-out;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .document-modal .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .document-item {
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    
    .document-item:hover {
        border-color: #007bff;
        box-shadow: 0 0.125rem 0.5rem rgba(0, 123, 255, 0.1);
    }
    
    .document-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .document-title {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .document-description {
        font-size: 0.75rem;
        color: #6c757d;
    }
    
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .upload-area:hover {
        border-color: #007bff;
        background-color: #f8f9fa;
    }
    
    .document-actions .btn {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Data Hibah LKS - {{ $selectedYear ?? now()->year }}</h4>
        <p class="text-muted mb-0">Kelola data proposal dan realisasi hibah LKS</p>
    </div>
    <div>
        <a href="{{ route('hibah.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Data Hibah
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $totalProposal }}</h4>
                        <p class="mb-0">Total Proposal</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-file-text fs-3 opacity-75"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">Semua data hibah tahun {{ $selectedYear }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $proposalTerupload }}</h4>
                        <p class="mb-0">Proposal Terupload</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-3 opacity-75"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        @if($totalProposal > 0)
                            {{ number_format(($proposalTerupload / $totalProposal) * 100, 1) }}% dari total
                        @else
                            0% dari total
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $lpjTerupload }}</h4>
                        <p class="mb-0">LPJ Terupload</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-file-earmark-text fs-3 opacity-75"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        @if($totalProposal > 0)
                            {{ number_format(($lpjTerupload / $totalProposal) * 100, 1) }}% dari total
                        @else
                            0% dari total
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $dokumenLengkap }}</h4>
                        <p class="mb-0">Dokumen Lengkap</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-folder-check fs-3 opacity-75"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        @if($totalProposal > 0)
                            {{ number_format(($dokumenLengkap / $totalProposal) * 100, 1) }}% dari total
                        @else
                            0% dari total
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4 filter-card">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <form id="tahunForm" method="GET" action="{{ route('hibah.index') }}">
                    <div class="input-group">
                        <input id="tahunInput" type="number" name="tahun" class="form-control" 
                               value="{{ $selectedYear ?? now()->year }}" min="2023" max="2100">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status Dokumen</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="proposal">Proposal Terupload</option>
                    <option value="lpj">LPJ Terupload</option>
                    <option value="lengkap">Dokumen Lengkap</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-outline-secondary w-100" id="resetFilter">
                    <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Main Table for Proposal and LPJ -->
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Dokumen Utama</h5>
            <div class="d-flex align-items-center">
                <small class="text-muted me-3">
                    Menampilkan {{ $items->count() }} dari {{ $items->total() }} data
                </small>
                <div class="btn-group">
                    <button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()" title="Refresh">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" id="exportBtn" title="Export Data">
                        <i class="bi bi-download"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table id="hibahTable" class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama LKS</th>
                        <th width="120">Proposal</th>
                        <th width="120">LPJ</th>
                        <th width="150">Progress Dokumen</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $row)
                    @php
                        $uploadedDocs = 0;
                        $totalDocs = 8; // Total jenis dokumen pendukung
                        $docFields = [
                            'hasil_verifikasi_path', 'pergub_penjabaran_apbd_path','dpa_path',
                            'hasil_identifikasi_path', 'data_penerima_hibah_path',
                            'spm_path', 'sp2d_path', 'petunjuk_teknis_path'
                        ];
                        
                        foreach ($docFields as $field) {
                            if ($row->$field) $uploadedDocs++;
                        }
                        
                        $percentage = ($uploadedDocs / $totalDocs) * 100;
                        
                        if ($percentage == 100) {
                            $statusClass = 'success';
                            $statusText = 'Lengkap';
                        } elseif ($percentage >= 50) {
                            $statusClass = 'warning';
                            $statusText = 'Sebagian';
                        } else {
                            $statusClass = 'danger';
                            $statusText = 'Minimal';
                        }
                    @endphp
                    <tr>
                            <td class="text-center">{{ $items->firstItem() + $index }}</td> <!-- Kolom 1 -->
                            <td>
                                <div>
                                    <strong>{{ $row->nama_lks }}</strong>
                                    <br>
                                    <small class="text-muted">Tahun: {{ $row->tahun }}</small>
                                </div>
                            </td> <!-- Kolom 2 -->
                            <td>
                                @if($row->proposal_path)
                                    <a class="file-link" target="_blank" href="{{ Storage::disk('public')->url($row->proposal_path) }}">
                                        <i class="bi bi-file-pdf me-1"></i>Lihat
                                    </a>
                                    <br>
                                    <small class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>Tersedia
                                    </small>
                                @else
                                    <span class="badge bg-danger status-badge">
                                        <i class="bi bi-x-circle me-1"></i>Belum
                                    </span>
                                @endif
                            </td> <!-- Kolom 3 -->
                            <td>
                                @if($row->lpj_path)
                                    <a class="file-link" target="_blank" href="{{ Storage::disk('public')->url($row->lpj_path) }}">
                                        <i class="bi bi-file-pdf me-1"></i>Lihat
                                    </a>
                                    <br>
                                    <small class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>Tersedia
                                    </small>
                                @else
                                    <span class="badge bg-warning status-badge">
                                        <i class="bi bi-clock me-1"></i>Belum
                                    </span>
                                @endif
                            </td> <!-- Kolom 4 -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="grow me-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="badge bg-{{ $statusClass }} status-badge">
                                                {{ $statusText }}
                                            </span>
                                            <small class="document-count">{{ $uploadedDocs }}/{{ $totalDocs }}</small>
                                        </div>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-{{ $statusClass }}" 
                                                 style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </td> <!-- Kolom 5 -->
                            <td>
                                <div class="action-buttons">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('hibah.edit', $row) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('hibah.show', $row) }}" class="btn btn-sm btn-outline-success" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('hibah.documents', $row->id) }}" 
                                           class="btn btn-sm btn-outline-dark" 
                                           title="Kelola Dokumen Pendukung">
                                            <i class="bi bi-folder2-open"></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('hibah.destroy', $row) }}" method="POST" class="d-inline mt-1" onsubmit="return confirm('Hapus data hibah {{ $row->nama_lks }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger w-100" title="Hapus">
                                            <i class="bi bi-trash me-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td> <!-- Kolom 6 -->
                        </tr>
                    @empty
                        <tr class="empty-state-row">
                            <td colspan="6"> <!-- Pastikan colspan sesuai jumlah kolom -->
                                <div class="empty-state">
                                    <i class="bi bi-inbox display-4"></i>
                                    <h5 class="mt-3">Belum ada data hibah</h5>
                                    <p class="text-muted">Tidak ada data hibah LKS untuk tahun {{ $selectedYear }}.</p>
                                    <a href="{{ route('hibah.create') }}" class="btn btn-primary mt-2">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Data Hibah Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($items->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <small class="text-muted">
                    Menampilkan {{ $items->firstItem() }} - {{ $items->lastItem() }} dari {{ $items->total() }} data
                </small>
            </div>
            <div>
                {{ $items->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
     $(document).ready(function() {
        // Tahun form submission (opsional, form sudah method GET)
        $('#tahunForm').on('submit', function(e) {
            // Biarkan form submit GET secara default supaya tetap jalan tanpa JS
        });

        // Reset filter
        $('#resetFilter').on('click', function() {
            $('#statusFilter').val('');
            $('#progressFilter').val('');
            window.location.href = "{{ url('/hibah') }}?tahun={{ $selectedYear ?? now()->year }}";
        });

        // Export functionality
        $('#exportBtn').on('click', function() {
            const tahun = '{{ $selectedYear ?? now()->year }}';
            if(confirm(`Export data hibah tahun ${tahun}?`)) {
                alert(`Fitur export data tahun ${tahun} akan diimplementasikan`);
            }
        });
    });
</script>
@endpush

@endsection