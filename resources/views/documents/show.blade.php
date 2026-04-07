@extends('layouts.app')

@section('title', 'Detail Dokumen - ' . $document->nama_dokumen)
@section('page-title', 'Detail Dokumen')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-eye"></i> Detail Dokumen
            </h1>
            <div>
                <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-file-earmark-text"></i> Informasi Dokumen
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Nama Dokumen</strong></td>
                        <td width="70%">{{ $document->nama_dokumen }}</td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi</strong></td>
                        <td>
                            @if($document->deskripsi)
                                {{ $document->deskripsi }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            @if($document->wajib)
                                <span class="badge bg-danger">Wajib</span>
                                <small class="text-muted ms-2">Dokumen ini harus dilengkapi untuk pendaftaran LKS</small>
                            @else
                                <span class="badge bg-secondary">Opsional</span>
                                <small class="text-muted ms-2">Dokumen ini bersifat opsional</small>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Urutan</strong></td>
                        <td>{{ $document->urutan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat</strong></td>
                        <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Terakhir Diupdate</strong></td>
                        <td>{{ $document->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Penggunaan -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-bar-chart"></i> Statistik Penggunaan
                </h5>
            </div>
            <div class="card-body">
                @php
                    $totalLKS = \App\Models\LKS::count();
                    $lksWithDocument = \App\Models\Checklist::where('document_id', $document->id)->count();
                    $lksWithDocumentAda = \App\Models\Checklist::where('document_id', $document->id)
                        ->where('kelengkapan', 'Ada')->count();
                    $percentage = $totalLKS > 0 ? ($lksWithDocumentAda / $totalLKS) * 100 : 0;
                @endphp
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <h4 class="text-primary">{{ $totalLKS }}</h4>
                            <small class="text-muted">Total LKS</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <h4 class="text-info">{{ $lksWithDocument }}</h4>
                            <small class="text-muted">LKS dengan Dokumen Ini</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <h4 class="text-success">{{ $lksWithDocumentAda }}</h4>
                            <small class="text-muted">LKS dengan Dokumen Ada</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <h4 class="text-{{ $percentage == 100 ? 'success' : 'warning' }}">
                                {{ number_format($percentage, 1) }}%
                            </h4>
                            <small class="text-muted">Tingkat Kelengkapan</small>
                        </div>
                    </div>
                </div>
                
                <div class="progress mb-3">
                    <div class="progress-bar bg-{{ $percentage == 100 ? 'success' : 'warning' }}" 
                         role="progressbar" style="width: {{ $percentage }}%">
                        {{ number_format($percentage, 1) }}%
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
