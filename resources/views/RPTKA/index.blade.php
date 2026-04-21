@extends('layouts.app')

@section('title', 'Daftar Permohonan RPTKA')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0"><i class="bi bi-file-earmark-text"></i> Permohonan RPTKA</h1>
            @if(auth()->user()->role === 'user')
            <a href="{{ route('rptka.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Daftar RPTKA Baru
            </a>
            @endif
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $stats['total'] }}</h4>
                    <small class="text-muted">Total Permohonan</small>
                </div>
                <i class="bi bi-folder2-open fs-2 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $stats['menunggu'] }}</h4>
                    <small class="text-muted">Menunggu Verifikasi</small>
                </div>
                <i class="bi bi-hourglass-split fs-2 text-warning"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $stats['diterima'] }}</h4>
                    <small class="text-muted">Diterima</small>
                </div>
                <i class="bi bi-check-circle fs-2 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $stats['terverifikasi'] }}</h4>
                    <small class="text-muted">Terverifikasi</small>
                </div>
                <i class="bi bi-patch-check fs-2 text-info"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('rptka.index') }}" class="row g-3">
            <div class="col-md-5">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama LKS atau nama TKA...">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="jenis">
                    <option value="">Semua Jenis</option>
                    <option value="Baru" {{ request('jenis') == 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Ulang" {{ request('jenis') == 'Ulang' ? 'selected' : '' }}>Perpanjangan</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Cari</button>
                <a href="{{ route('rptka.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel -->
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($rptkas->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama LKS</th>
                        <th>Nama TKA Pemohon</th>
                        <th>Jenis</th>
                        <th>Tgl Masuk</th>
                        <th>Kelengkapan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rptkas as $i => $item)
                    <tr>
                        <td>{{ $rptkas->firstItem() + $i }}</td>
                        <td>
                            <strong>{{ $item->nama_lks }}</strong><br>
                            <small class="text-muted">{{ Str::limit($item->alamat_lks, 50) }}</small>
                        </td>
                        <td>{{ $item->nama_tka_pemohon }}</td>
                        <td>
                            <span class="badge {{ $item->permohonan_rptka == 'Baru' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $item->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru' }}
                            </span>
                        </td>
                        <td>{{ $item->tanggal_masuk_dokumen->format('d/m/Y') }}</td>
                        <td>
                            @if($item->tanggal_persyaratan_lengkap)
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Lengkap</span>
                            @else
                                @php $pct = $item->completionPercentage() @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-1" style="height:8px;">
                                        <div class="progress-bar" style="width:{{ $pct }}%"></div>
                                    </div>
                                    <small>{{ $pct }}%</small>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('rptka.show', $item->id) }}" class="btn btn-outline-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('rptka.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('rptka.destroy', $item->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus data RPTKA ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $rptkas->links() }}</div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-2">Belum ada data permohonan RPTKA</p>
            <a href="{{ route('rptka.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Daftar Sekarang
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
