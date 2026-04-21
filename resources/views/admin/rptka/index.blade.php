@extends('layouts.app')
@section('title', 'Admin - Verifikasi RPTKA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-file-earmark-person"></i> Verifikasi Permohonan RPTKA</h1>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
    @foreach([
        ['label'=>'Total','val'=>$stats['total'],'color'=>'primary','icon'=>'folder2-open'],
        ['label'=>'Menunggu','val'=>$stats['menunggu'],'color'=>'warning','icon'=>'hourglass-split'],
        ['label'=>'Diterima','val'=>$stats['diterima'],'color'=>'success','icon'=>'check-circle'],
        ['label'=>'Ditolak','val'=>$stats['ditolak'],'color'=>'danger','icon'=>'x-circle'],
        ['label'=>'Dikembalikan','val'=>$stats['dikembalikan'],'color'=>'info','icon'=>'arrow-return-left'],
        ['label'=>'Terverifikasi','val'=>$stats['terverifikasi'],'color'=>'secondary','icon'=>'patch-check'],
    ] as $s)
    <div class="col-md-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center py-3">
                <i class="bi bi-{{ $s['icon'] }} fs-3 text-{{ $s['color'] }}"></i>
                <h4 class="mb-0 mt-1">{{ $s['val'] }}</h4>
                <small class="text-muted">{{ $s['label'] }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama LKS atau TKA...">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    @foreach(['Menunggu','Diterima','Ditolak','Dikembalikan','Terverifikasi'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Cari</button>
                <a href="{{ route('admin.rptka.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel -->
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        @if($rptkas->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama LKS / TKA</th>
                        <th>Jenis</th>
                        <th>Tgl Masuk</th>
                        <th>Status</th>
                        <th>Surat Rekomendasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rptkas as $i => $item)
                    <tr>
                        <td>{{ $rptkas->firstItem() + $i }}</td>
                        <td>
                            <strong>{{ $item->nama_lks }}</strong><br>
                            <small class="text-muted">TKA: {{ $item->nama_tka_pemohon }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $item->permohonan_rptka == 'Baru' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $item->permohonan_rptka == 'Ulang' ? 'Perpanjangan' : 'Baru' }}
                            </span>
                        </td>
                        <td>{{ $item->tanggal_masuk_dokumen->format('d/m/Y') }}</td>
                        <td><span class="badge {{ $item->status_badge }}">{{ $item->status_permohonan }}</span></td>
                        <td>
                            @if($item->surat_rekomendasi_rptka_path)
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.rptka.preview-surat', $item->id) }}" class="btn btn-outline-info" target="_blank" title="Preview"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.rptka.download-surat', $item->id) }}" class="btn btn-outline-success" title="Download"><i class="bi bi-download"></i></a>
                                </div>
                            @else
                                <span class="badge bg-secondary">Belum Ada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.rptka.verification', $item->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-shield-check"></i> Verifikasi
                            </a>
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
            <p class="text-muted mt-2">Belum ada permohonan RPTKA</p>
        </div>
        @endif
    </div>
</div>
@endsection
