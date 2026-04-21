@extends('layouts.app')
@section('title', 'Super Admin - Verval RPTKA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="bi bi-patch-check"></i> Verifikasi & Validasi RPTKA</h1>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
    @foreach([
        ['label'=>'Total Masuk','val'=>$stats['total'],'color'=>'primary','icon'=>'folder2-open'],
        ['label'=>'Belum Verval','val'=>$stats['belum_verval'],'color'=>'warning','icon'=>'hourglass-split'],
        ['label'=>'Sudah Verval','val'=>$stats['sudah_verval'],'color'=>'success','icon'=>'check-circle'],
        ['label'=>'Terverifikasi','val'=>$stats['terverifikasi'],'color'=>'info','icon'=>'patch-check'],
    ] as $s)
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $s['val'] }}</h4>
                    <small class="text-muted">{{ $s['label'] }}</small>
                </div>
                <i class="bi bi-{{ $s['icon'] }} fs-2 text-{{ $s['color'] }}"></i>
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
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama LKS atau TKA...">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="has_final">
                    <option value="">Semua</option>
                    <option value="no" {{ request('has_final') == 'no' ? 'selected' : '' }}>Belum Ada Surat Final</option>
                    <option value="yes" {{ request('has_final') == 'yes' ? 'selected' : '' }}>Sudah Ada Surat Final</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Cari</button>
                <a href="{{ route('superadmin.rptka.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
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
                        <th>Surat Rekomendasi (Admin)</th>
                        <th>Surat Final (Verval)</th>
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
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.rptka.preview-surat', $item->id) }}" class="btn btn-outline-info" target="_blank" title="Preview"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.rptka.download-surat', $item->id) }}" class="btn btn-outline-success" title="Download"><i class="bi bi-download"></i></a>
                            </div>
                        </td>
                        <td>
                            @if($item->surat_rekomendasi_rptka_final_path)
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('superadmin.rptka.preview-final', $item->id) }}" class="btn btn-outline-info" target="_blank" title="Preview"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('superadmin.rptka.download-final', $item->id) }}" class="btn btn-outline-success" title="Download"><i class="bi bi-download"></i></a>
                                </div>
                            @else
                                <span class="badge bg-secondary">Belum Ada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('superadmin.rptka.verification', $item->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-patch-check"></i> Verval
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
            <p class="text-muted mt-2">Belum ada RPTKA yang siap diverval</p>
        </div>
        @endif
    </div>
</div>
@endsection
