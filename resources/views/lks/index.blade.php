@extends('layouts.app')

@section('title', 'Data LKS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-list-check"></i> Data LKS
            </h1>
            <div class="justify-content-end btn-group">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
                @if(auth()->user()->hasRole(['super_admin', 'admin']))
                    <a href="{{ route('lks.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Pendaftaran Baru
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-table"></i> Daftar Pendaftaran LKS
        </h5>
    </div>
    <div class="card-body">
        @if($lks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama LKS</th>
                            <th>Tanda Pendaftaran</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Kelengkapan</th>
                            <th>Sertifikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lks as $index => $lksItem)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $lksItem->nama_lks }}</td>
                                <td>{{ $lksItem->tanda_pendaftaran }}</td>
                                <td>{{ \Carbon\Carbon::parse($lksItem->tanggal_masuk_dokumen)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $lksItem->status_badge }} text-dark">
                                        {{ $lksItem->status_permohonan }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $lksItem->pendaftaran_lengkap ? 'bg-success' : 'bg-warning' }} text-dark">
                                        {{ $lksItem->pendaftaran_lengkap ? 'Lengkap' : 'Tidak Lengkap' }}
                                    </span>
                                </td>
                                <td>
                                    @if($lksItem->sertifikat_path)
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.verification.download-sertifikat', $lksItem->id) }}" 
                                               class="btn btn-sm btn-success" 
                                               title="Download Sertifikat"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <a href="{{ route('admin.verification.preview-sertifikat', $lksItem->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Preview Sertifikat"
                                               target="_blank"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if(auth()->user()->role === 'admin')
                                                <form action="{{ route('admin.verification.delete-sertifikat', $lksItem->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Sertifikat">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @else
                                        <span class="badge bg-secondary" data-bs-toggle="tooltip" title="Belum ada sertifikat">
                                            <i class="bi bi-file-earmark-pdf"></i> Tidak Ada
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('lks.show', $lksItem->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->hasRole(['super_admin', 'admin']))
                                            <a href="{{ route('lks.edit', $lksItem->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if(auth()->user()->role === 'admin')
                                                <a href="{{ route('admin.verification', $lksItem->id) }}" class="btn btn-sm btn-primary" title="Verifikasi">
                                                    <i class="bi bi-clipboard-check"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('lks.destroy', $lksItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $lks->links() }}
            </div>
        @else
            <p class="text-muted">Belum ada data LKS yang terdaftar.</p>
        @endif
    </div>
</div>

<!-- Modal untuk Preview Sertifikat -->
<div class="modal fade" id="sertifikatModal" tabindex="-1" aria-labelledby="sertifikatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sertifikatModalLabel">Preview Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="sertifikatFrame" src="" width="100%" height="600px" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <a href="#" id="downloadSertifikat" class="btn btn-success">
                    <i class="bi bi-download"></i> Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.btn-group .btn {
    margin-right: 2px;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
.table td {
    vertical-align: middle;
}
</style>

<script>
// Inisialisasi tooltip
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Modal untuk preview sertifikat
    var sertifikatModal = document.getElementById('sertifikatModal');
    if (sertifikatModal) {
        sertifikatModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var sertifikatUrl = button.getAttribute('data-sertifikat-url');
            var downloadUrl = button.getAttribute('data-download-url');
            
            var modalTitle = sertifikatModal.querySelector('.modal-title');
            var sertifikatFrame = document.getElementById('sertifikatFrame');
            var downloadLink = document.getElementById('downloadSertifikat');
            
            modalTitle.textContent = 'Preview Sertifikat - ' + button.getAttribute('data-lks-name');
            sertifikatFrame.src = sertifikatUrl;
            downloadLink.href = downloadUrl;
        });
        
        sertifikatModal.addEventListener('hidden.bs.modal', function () {
            var sertifikatFrame = document.getElementById('sertifikatFrame');
            sertifikatFrame.src = '';
        });
    }
});
</script>
@endsection