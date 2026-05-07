@extends('layouts.app')

@section('title', 'Data Kewenangan Kabupaten/Kota')

@section('content')
<style>
    /* Gaya modern khas SIPINJAM - versi biru */
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
        color: #0d6efd;
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
    .nav-pills-custom {
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .nav-pills-custom .nav-link {
        border-radius: 2rem;
        padding: 0.5rem 1.2rem;
        font-weight: 500;
        transition: all 0.2s;
        color: #334155;
    }
    .nav-pills-custom .nav-link i {
        margin-right: 0.5rem;
    }
    .nav-pills-custom .nav-link.active {
        background: #0d6efd;
        color: white;
        box-shadow: 0 2px 8px rgba(13,110,253,0.2);
    }
    .nav-pills-custom .nav-link:not(.active):hover {
        background: #eef2ff;
        color: #0d6efd;
    }
    .table-modern {
        margin-bottom: 0;
    }
    .table-modern th {
        background: #f8fafc;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #475569;
        padding: 0.8rem 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-modern td {
        padding: 0.8rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.85rem;
    }
    .table-modern tr:last-child td {
        border-bottom: none;
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.7rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 500;
    }
    .badge-pusat { 
        background: #e6f7e6; 
        color: #2e7d32; 
    }
    .badge-cabang { 
        background: #fef3c7; 
        color: #b45309; 
    }
    .badge-pelayanan {
        background: #e0e7ff;
        color: #1e40af;
        font-size: 0.7rem;
        padding: 0.2rem 0.7rem;
        border-radius: 2rem;
    }
    .info-alert {
        background: #eef2ff;
        border-left: 4px solid #0d6efd;
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 768px) {
        .stat-value { font-size: 1.4rem; }
        .table-modern th, .table-modern td { padding: 0.5rem; }
        .btn-group { flex-wrap: wrap; gap: 0.5rem; }
    }
</style>

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-semibold mb-1">
            <i class="bi bi-geo-alt-fill me-2" style="color: #0d6efd;"></i> Data Kewenangan Kabupaten/Kota
        </h2>
        <p class="text-muted small mb-0">Kelola data kewenangan LKS tingkat Kabupaten/Kota se-Jawa Barat</p>
    </div>
    <div class="d-flex gap-2 mt-2 mt-sm-0">
        @auth
                @if(Auth::user()->hasRole(['super_admin']))
                <a href="{{ route('kewenangan-kabkota.export-excel') }}?search={{ request('search') }}" class="btn btn-success rounded-pill px-3">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </a>
                @endif
        @endauth
    </div>
</div>

<!-- Tab Navigasi (Kab/Kota, Provinsi, Kemensos) super admin -->
@auth
    @if (Auth::user()->hasRole('super_admin'))
        <div class="mb-4">
            <ul class="nav nav-pills nav-pills-custom" id="levelTabs">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('kewenangan-kabkota.index') }}">
                        <i class="bi bi-geo-alt-fill"></i> Kab/Kota
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kewenangan-provinsi.index') }}">
                        <i class="bi bi-building-fill"></i> Provinsi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kewenangan-kemensos.index') }}">
                        <i class="bi bi-house-gear"></i> Kemensos
                    </a>
                </li>
            </ul>
        </div>
    @endif
@endauth


<!-- Statistik Utama -->
<div class="row g-4 mb-5">
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total LKS</div>
                    <div class="stat-value">{{ number_format($statistics['total']['total_lks'] ?? 0) }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-list-ul"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Pusat</div>
                    <div class="stat-value">{{ $kewenangan->where('status', 'pusat')->count() }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-building"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Cabang</div>
                    <div class="stat-value">{{ $kewenangan->where('status', 'cabang')->count() }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-diagram-3"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Binaan</div>
                    <div class="stat-value">{{ number_format($statistics['total']['seluruh_binaan'] ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Dalam Panti</div>
                    <div class="stat-value">{{ number_format($statistics['total']['dalam_panti'] ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-house-door"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Luar Panti</div>
                    <div class="stat-value">{{ number_format($statistics['total']['luar_panti'] ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon"><i class="bi bi-house-up"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Berdasarkan Jenis Pelayanan -->
<div class="card-modern mb-4">
    <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-pie-chart me-2"></i> Statistik Berdasarkan Jenis Pelayanan PPKS</span>
        <form method="GET" action="{{ route('kewenangan-kabkota.index') }}" class="d-flex align-items-center gap-2" id="filterKabkotaForm">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            @if(!$isAdmin)
            <select name="filter_kabkota" class="form-select form-select-sm rounded-pill" style="min-width:220px; font-size:.82rem;"
                    onchange="document.getElementById('filterKabkotaForm').submit()">
                <option value="">— Semua Kabupaten/Kota —</option>
                @php
                $kabupatenList = [
                    'Kabupaten Bogor','Kabupaten Sukabumi','Kabupaten Cianjur','Kabupaten Bandung',
                    'Kabupaten Garut','Kabupaten Tasikmalaya','Kabupaten Ciamis','Kabupaten Kuningan',
                    'Kabupaten Cirebon','Kabupaten Majalengka','Kabupaten Sumedang','Kabupaten Indramayu',
                    'Kabupaten Subang','Kabupaten Purwakarta','Kabupaten Karawang','Kabupaten Bekasi',
                    'Kabupaten Bandung Barat','Kabupaten Pangandaran',
                    'Kota Bogor','Kota Sukabumi','Kota Bandung','Kota Cirebon','Kota Bekasi',
                    'Kota Depok','Kota Cimahi','Kota Tasikmalaya','Kota Banjar',
                ];
                @endphp
                @foreach($kabupatenList as $kab)
                    <option value="{{ $kab }}" {{ $filterKabkota == $kab ? 'selected' : '' }}>{{ $kab }}</option>
                @endforeach
            </select>
            @if($filterKabkota)
                <a href="{{ route('kewenangan-kabkota.index', request()->except('filter_kabkota')) }}"
                   class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Reset filter">
                    <i class="bi bi-x-circle"></i>
                </a>
            @endif
            @endif
        </form>
    </div>
    @if($filterKabkota)
    <div class="px-3 pt-2 pb-0">
        <span class="badge bg-primary rounded-pill" style="font-size:.75rem;">
            <i class="bi bi-geo-alt me-1"></i>{{ $filterKabkota }}
        </span>
    </div>
    @endif
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th>Jenis Pelayanan PPKS</th>
                        <th class="text-center">Jumlah LKS</th>
                        <th class="text-center">Binaan Dalam Panti</th>
                        <th class="text-center">Binaan Luar Panti</th>
                        <th class="text-center">Total Binaan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $byJenisPelayanan = $statistics['by_jenis_pelayanan'] ?? [];
                    @endphp
                    @forelse($byJenisPelayanan as $jenis => $data)
                        <tr>
                            <td><span class="fw-semibold">{{ $jenis }}</span></td>
                            <td class="text-center"><span class="badge bg-primary">{{ number_format($data['total_lks'] ?? 0) }}</span></td>
                            <td class="text-center"><span class="badge bg-danger">{{ number_format($data['total_dalam_panti'] ?? 0) }}</span></td>
                            <td class="text-center"><span class="badge bg-secondary">{{ number_format($data['total_luar_panti'] ?? 0) }}</span></td>
                            <td class="text-center"><span class="badge bg-success">{{ number_format($data['total_seluruh_binaan'] ?? 0) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data</td></tr>
                    @endforelse
                </tbody>
                @if(count($byJenisPelayanan) > 0)
                <tfoot class="table-light">
                    <tr>
                        <th class="text-end">Total:</th>
                        <th class="text-center">{{ number_format($statistics['total']['total_lks'] ?? 0) }}</th>
                        <th class="text-center">{{ number_format($statistics['total']['dalam_panti'] ?? 0) }}</th>
                        <th class="text-center">{{ number_format($statistics['total']['luar_panti'] ?? 0) }}</th>
                        <th class="text-center">{{ number_format($statistics['total']['seluruh_binaan'] ?? 0) }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<!-- Filter & Tabel Data Utama -->
<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-table me-2"></i> Data Kewenangan Kabupaten/Kota
    </div>
    <div class="card-body p-4">
        <!-- Form Pencarian -->
        <div class="filter-card p-0 mb-4 border-0 bg-transparent">
            <form method="GET" class="row g-3">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                               placeholder="Cari nama yayasan, LKS, atau kabupaten/kota..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
                @if(request('search'))
                <div class="col-md-2">
                    <a href="{{ route('kewenangan-kabkota.index') }}" class="btn btn-outline-secondary rounded-pill w-100">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
                @endif
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
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
                    <tr>
                        <td class="text-center fw-semibold">{{ ($kewenangan->currentPage() - 1) * $kewenangan->perPage() + $loop->iteration }}</td>
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
                            <small class="text-muted">{{ Str::limit($item->alamat, 40) }}</small>
                        </td>
                        <td><span class="badge-pelayanan">{{ $item->jenis_pelayanan_PPKS }}</span></td>
                        <td class="text-center">
                            <span class="badge-status {{ $item->status == 'pusat' ? 'badge-pusat' : 'badge-cabang' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                            <br><small class="text-muted">{{ $item->pusat_cabang }}</small>
                        </td>
                        <td class="text-center">
                            <div class="d-flex flex-column gap-1">
                                <span class="badge bg-danger bg-opacity-10 text-danger"><i class="bi bi-house-door"></i> Dalam: {{ $item->jumlah_dalam_panti }}</span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-house-up"></i> Luar: {{ $item->jumlah_luar_panti }}</span>
                                <span class="badge bg-warning bg-opacity-10 text-warning"><i class="bi bi-people"></i> Total: {{ $item->jumlah_seluruh_binaan }}</span>
                            </div>
                        </td>
                        @auth
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('kewenangan-kabkota.show', $item->id) }}" class="btn btn-sm btn-outline-info rounded-pill me-1" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(Auth::user()->hasRole('super_admin'))
                                        <a href="{{ route('kewenangan-kabkota.edit', $item->id) }}" class="btn btn-sm btn-outline-warning rounded-pill me-1" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill"
                                                title="Hapus" onclick="confirmDelete({{ $item->id }}, '{{ $item->Nama_Lembaga_Yayasan }}')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        @endauth
                    </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user() && Auth::user()->hasRole('admin') ? '8' : '7' }}" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                <p>Tidak ada data ditemukan</p>
                                <small>Coba ubah kata kunci pencarian</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Menampilkan {{ $kewenangan->firstItem() ?? 0 }} - {{ $kewenangan->lastItem() ?? 0 }} dari {{ $kewenangan->total() }} data
            </div>
            <div>
                {{ $kewenangan->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
@auth
    @if(Auth::user()->hasRole(['super_admin', 'admin']))
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data kewenangan:</p>
                        <div class="alert alert-warning py-2 rounded-pill">
                            <strong id="deleteItemName"></strong>
                        </div>
                        <p class="text-danger small mb-0">
                            <i class="bi bi-exclamation-circle"></i> Tindakan ini tidak dapat dibatalkan!
                        </p>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <form id="deleteForm" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                <i class="bi bi-trash3 me-1"></i> Hapus Data
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
</script>
@endpush
