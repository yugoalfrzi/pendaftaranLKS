@extends('layouts.app')

@section('title', 'Manajemen Pengumuman')
@section('page-title', 'Manajemen Pengumuman')

@section('content')

{{-- Alert --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-primary">{{ $stats['total'] }}</div>
            <div class="text-muted small">Total Dokumen</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-info">{{ $stats['regulasi'] }}</div>
            <div class="text-muted small">Regulasi</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-success">{{ $stats['panduan'] }}</div>
            <div class="text-muted small">Panduan</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-warning">{{ $stats['surat'] }}</div>
            <div class="text-muted small">Surat</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold"><i class="bi bi-megaphone me-2 text-primary"></i>Daftar Pengumuman</h5>
        <a href="{{ route('announcements.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Dokumen
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Format</th>
                        <th>Status</th>
                        <th>Unduhan</th>
                        <th>Dibuat</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($announcements as $item)
                    <tr>
                        <td class="ps-3 text-muted small">{{ $loop->iteration + ($announcements->currentPage() - 1) * $announcements->perPage() }}</td>
                        <td>
                            <div class="fw-semibold">{{ Str::limit($item->title, 50) }}</div>
                            <small class="text-muted">{{ Str::limit($item->description, 60) }}</small>
                        </td>
                        <td>
                            @php
                                $badgeColor = ['regulasi' => 'primary', 'panduan' => 'success', 'surat' => 'warning'][$item->announcement_type] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $badgeColor }}">{{ ucfirst($item->announcement_type) }}</span>
                        </td>
                        <td><small>{{ $item->category }}</small></td>
                        <td><span class="badge bg-light text-dark border">{{ $item->format }}</span></td>
                        <td>
                            @if($item->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->download_count }}</td>
                        <td><small class="text-muted">{{ $item->created_at->format('d M Y') }}</small></td>
                        <td class="text-center pe-3">
                            <div class="d-flex gap-1 justify-content-center">
                                {{-- Preview --}}
                                @if($item->isPreviewable())
                                <a href="{{ $item->getPreviewRoute() }}" target="_blank"
                                   class="btn btn-sm btn-outline-info" title="Preview">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @endif
                                {{-- Edit --}}
                                <a href="{{ route('announcements.edit', $item->id) }}"
                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                {{-- Delete --}}
                                <form action="{{ route('announcements.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada dokumen. <a href="{{ route('announcements.create') }}">Tambah sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($announcements->hasPages())
    <div class="card-footer bg-white">
        {{ $announcements->links() }}
    </div>
    @endif
</div>
@endsection
