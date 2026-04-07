@extends('layouts.app')

@section('title', 'Data Kewenangan Kabupaten/Kota')

@push('styles')
<style>
.table-row-hover:hover {
    background-color: #f8f9fa !important;
    transition: background-color 0.2s ease;
}

.nav-pills .nav-link {
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background-color: #e9ecef;
}

.nav-pills .nav-link.active {
    background-color: #0d6efd;
    box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: box-shadow 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin: 0 1px;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
}

.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    border-radius: 0.375rem;
    margin: 0 2px;
    border: 1px solid #dee2e6;
    color: #6c757d;
}

.pagination .page-link:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #495057;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
</style>
@endpush

@section('content')
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Data Kewenangan Kabupaten/Kota</h2>
                <p class="text-muted mb-0">Kelola data kewenangan LKS tingkat Kabupaten/Kota</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('kewenangan-kabkota.export-excel') }}?search={{ request('search') }}" 
                   class="btn btn-success">
                    <i class="fas fa-file-excel me-2"></i>Export Excel
                </a>
                @auth
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('kewenangan-kabkota.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Data
                        </a>
                    @endif
                @endauth
            </div>
        </div>    
    </div>
</div>    

<!-- Level Filter Tabs -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills nav-fill" id="levelTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" href="{{ route('kewenangan-kabkota.index') }}">
                            <i class="bi bi-geo-alt-fill"></i> Kab/Kota
                        </a>
                    </li>
                    @auth
                        @if (Auth::user()->hasRole('admin'))
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('kewenangan-provinsi.index') }}">
                                <i class="bi bi-building-fill"></i> Provinsi
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('kewenangan-kemensos.index') }}">
                                <i class="bi bi-house-gear"></i> Kemensos
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-2 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ number_format($statistics['total']['total_lks']) }}</h4>
                        <p class="mb-0">Total LKS</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-list-ul fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $kewenangan->where('status', 'pusat')->count() }}</h4>
                        <p class="mb-0">Pusat</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-building-fill fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $kewenangan->where('status', 'cabang')->count() }}</h4>
                        <p class="mb-0">Cabang</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-geo-alt fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ number_format($statistics['total']['seluruh_binaan'] ?? 0, 0, ',', '.') }}</h4>
                        <p class="mb-0">Total Binaan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people-fill fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ number_format($statistics['total']['dalam_panti'] ?? 0, 0, ',', '.') }}</h4>
                        <p class="mb-0">Binaan Dalam Panti</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-house-door-fill fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ number_format($statistics['total']['luar_panti'] ?? 0, 0, ',', '.') }}</h4>
                        <p class="mb-0">Binaan Luar Panti</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-house-up-fill fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- Statistics by Jenis Pelayanan -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pie-chart"></i> Statistik Berdasarkan Jenis Pelayanan PPKS
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis Pelayanan PPKS</th>
                                <th class="text-center">Jumlah LKS</th>
                                <th class="text-center"> Binaan Dalam Panti</th>
                                <th class="text-center">Binaan Luar Panti</th>
                                <th class="text-center">Total Binaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalLKS = $statistics['total']['total_lks'] ?? 0;
                                $byJenisPelayanan = $statistics['by_jenis_pelayanan'] ?? [];
                            @endphp
                            @foreach($byJenisPelayanan as $jenis => $data)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $jenis }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ number_format($data['total_lks'] ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">{{ number_format($data['total_dalam_panti'] ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ number_format($data['total_luar_panti'] ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ number_format($data['total_seluruh_binaan'] ?? 0, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @if(count($byJenisPelayanan) > 0)
                        <tfoot class="table-light">
                            <tr>
                                <th class="text-end">Total:</th>
                                <th class="text-center">{{ $totalLKS }}</th>
                                <th class="text-center">{{ number_format($statistics['total']['dalam_panti'] ?? 0, 0, ',', '.') }}</th>
                                <th class="text-center">{{ number_format($statistics['total']['luar_panti'] ?? 0, 0, ',', '.') }}</th>
                                <th class="text-center">{{ number_format($statistics['total']['seluruh_binaan'] ?? 0, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-table"></i> Data Kewenangan Kabupaten/Kota
                </h5>
            </div>
            <div class="card-body">
                <!-- Enhanced Search and Filter Section -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <form method="GET" class="d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama yayasan, LKS, atau kabupaten/kota..." 
                                       value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('kewenangan-kabkota.index') }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Reset
                                </a>
                            @endif
                        </form>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <span class="badge bg-primary fs-6">
                                {{ $kewenangan->count() }} dari {{ $kewenangan->total() }} data
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Data Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th>Nama Yayasan</th>
                                <th>Nama LKS</th>
                                <th>Kab/Kota</th>
                                <th>Jenis Pelayanan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Warga Binaan</th>
                                @auth
                                    @if(Auth::user()->hasRole('admin'))
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kewenangan as $item)
                            <tr class="table-row-hover">
                                <td class="text-center fw-bold">{{ ($kewenangan->currentPage() - 1) * $kewenangan->perPage() + $loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $item->Nama_Lembaga_Yayasan }}</div>
                                    <small class="text-muted">{{ $item->ketua_yayasan }}</small>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $item->nama_lks }}</div>
                                    <small class="text-muted">{{ $item->nama_ketua_lks }}</small>
                                </td>
                                <td>
                                    <div>{{ $item->kabupaten_kota }}</div>
                                    <small class="text-muted">{{ $item->alamat }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $item->jenis_pelayanan_PPKS }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $item->status == 'pusat' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $item->pusat_cabang }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column gap-1">
                                        <span class="badge bg-danger">
                                            <i class="bi bi-house-door"></i> {{ $item->jumlah_dalam_panti }}
                                        </span>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-house-up"></i> {{ $item->jumlah_luar_panti }}
                                        </span>
                                        <span class="badge bg-warning">
                                            <i class="bi bi-people"></i> {{ $item->jumlah_seluruh_binaan }}
                                        </span>
                                    </div>
                                </td>
                                @auth
                                    @if(Auth::user()->hasRole('admin'))
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('kewenangan-kabkota.show', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-info" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('kewenangan-kabkota.edit', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        title="Hapus" onclick="confirmDelete({{ $item->id }}, '{{ $item->Nama_Lembaga_Yayasan }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    @endif
                                @endauth
                            </tr>
                            @empty
                            <tr>
                                <td colspan="@auth @if(Auth::user()->hasRole('admin')) 8 @else 7 @endif @endauth" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        <h5>Tidak ada data ditemukan</h5>
                                        <p>Silakan tambah data baru atau ubah kata kunci pencarian</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Enhanced Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $kewenangan->firstItem() ?? 0 }} sampai {{ $kewenangan->lastItem() ?? 0 }} 
                        dari {{ $kewenangan->total() }} data
                    </div>
                    <div>
                        {{ $kewenangan->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@auth
    @if(Auth::user()->hasRole('admin'))
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">
                            <i class="bi bi-exclamation-triangle text-warning"></i> Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data kewenangan:</p>
                        <div class="alert alert-warning">
                            <strong id="deleteItemName"></strong>
                        </div>
                        <p class="text-danger">
                            <i class="bi bi-exclamation-circle"></i> 
                            <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan!
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <form id="deleteForm" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endauth
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteForm').action = `/kewenangan-kabkota/${id}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Add hover effect to table rows
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('.table-row-hover');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
});
</script>
@endpush