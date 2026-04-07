@extends('layouts.app')

@section('content')
<style>
    .year-badge {
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .document-card {
        border-left: 4px solid #007bff;
    }
    
    .shared-document {
        border-left-color: #28a745;
        background-color: #f8fff9;
    }
    
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .upload-area:hover {
        border-color: #007bff;
        background-color: #f8f9fa;
    }
    
    .bulk-upload-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 0.5rem;
    }
</style>

<div class="container-fluid">
    <!-- Header dengan info tahun -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('hibah.index') }}">Data Hibah</a></li>
                    <li class="breadcrumb-item active">Kelola Dokumen - {{ $hibah->tahun }}</li>
                </ol>
            </nav>
            <h4 class="mb-1">Kelola Dokumen Pendukung</h4>
            <p class="text-muted mb-0">
                <i class="bi bi-building me-1"></i>{{ $hibah->nama_lks }} 
                <span class="badge bg-primary year-badge ms-2">
                    <i class="bi bi-calendar me-1"></i>Tahun {{ $hibah->tahun }}
                </span>
                <span class="badge bg-success year-badge ms-2">
                    <i class="bi bi-share me-1"></i>Dokumen Pendukung Shared
                </span>
            </p>
        </div>
        <div>
            <a href="{{ route('hibah.index', ['tahun' => $hibah->tahun]) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Alert Info -->
    <div class="alert alert-info">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle me-2 fs-5"></i>
            <div>
                <strong>Sistem Dokumen Pendukung Terpusat per Tahun</strong> - 
                Dokumen pendukung diupload sekali dan berlaku untuk <strong>semua LKS tahun {{ $hibah->tahun }}</strong>. 
                @php
                    $totalLksTahunIni = $allYearsData->where('tahun', $hibah->tahun)->count();
                @endphp
                Total: <strong>{{ $totalLksTahunIni }} LKS</strong>.
            </div>
        </div>
    </div>

    <!-- Bulk Upload Section untuk Admin -->
    @if(Auth::user() && Auth::user()->role === 'admin')
    <div class="card bulk-upload-section text-white mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="card-title mb-2">
                        <i class="bi bi-upload me-2"></i>Upload Massal Dokumen Pendukung
                    </h5>
                    <p class="card-text mb-0 opacity-75">
                        Upload semua dokumen pendukung sekaligus. Dokumen akan berlaku untuk <strong>semua LKS tahun {{ $hibah->tahun }}</strong>.
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
                        <i class="bi bi-cloud-arrow-up me-2"></i>Upload Massal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="bi bi-file-text fs-1 mb-2 opacity-75"></i>
                    <h4 class="mb-1">{{ $hibah->proposal_path ? '✓' : '✗' }}</h4>
                    <p class="mb-0">Proposal {{ $hibah->tahun }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-text fs-1 mb-2 opacity-75"></i>
                    <h4 class="mb-1">{{ $hibah->lpj_path ? '✓' : '✗' }}</h4>
                    <p class="mb-0">LPJ {{ $hibah->tahun }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            @php
                $uploadedDocs = 0;
                $totalDocs = 8;
                $docFields = [
                    'hasil_verifikasi_path', 'pergub_penjabaran_apbd_path', 'dpa_path',
                    'hasil_identifikasi_path', 'data_penerima_hibah_path',
                    'spm_path', 'sp2d_path', 'petunjuk_teknis_path'
                ];
                foreach ($docFields as $field) {
                    if (!empty($hibah->$field)) $uploadedDocs++;
                }
                $percentage = $totalDocs > 0 ? ($uploadedDocs / $totalDocs) * 100 : 0;
            @endphp
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="bi bi-folder2 fs-1 mb-2 opacity-75"></i>
                    <h4 class="mb-1">{{ $uploadedDocs }}/{{ $totalDocs }}</h4>
                    <p class="mb-0">Dokumen Pendukung</p>
                    <small>Shared untuk semua LKS</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="bi bi-share fs-1 mb-2 opacity-75"></i>
                    <h4 class="mb-1">{{ $totalLksTahunIni }}</h4>
                    <p class="mb-0">LKS Tahun {{ $hibah->tahun }}</p>
                    <small>Menggunakan dokumen shared</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Grid -->
    <div class="row">
        <!-- Dokumen Spesifik Tahun -->
        <div class="col-12 mb-4">
            <h5 class="border-bottom pb-2">
                <i class="bi bi-calendar-event me-2"></i>Dokumen Spesifik Tahun {{ $hibah->tahun }}
            </h5>
        </div>
        
        <!-- Proposal -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card document-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="document-icon bg-primary text-white rounded p-2 me-3">
                            <i class="bi bi-file-text fs-4"></i>
                        </div>
                        <div class="grow 1">
                            <h6 class="card-title mb-1">Proposal</h6>
                            <span class="badge bg-primary year-badge">
                                <i class="bi bi-calendar me-1"></i>Tahun {{ $hibah->tahun }}
                            </span>
                        </div>
                    </div>

                    <div class="document-status mb-3">
                        @if($hibah->proposal_path)
                            <small class="text-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Tersedia untuk {{ $hibah->tahun }}
                            </small>
                        @else
                            <small class="text-warning">
                                <i class="bi bi-clock me-1"></i>
                                Belum tersedia
                            </small>
                        @endif
                    </div>

                    <div class="quick-actions">
                        @if($hibah->proposal_path)
                            <div class="btn-group w-100 mb-2">
                                <a href="{{ route('hibah.documents.preview', [$hibah->id, 'proposal']) }}" 
                                   class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <a href="{{ route('hibah.documents.download', [$hibah->id, 'proposal']) }}" 
                                   class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-download"></i> Unduh
                                </a>
                            </div>
                        @endif
                        
                        <a href="{{ route('hibah.edit', $hibah->id) }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="bi bi-pencil me-1"></i>Edit Proposal
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- LPJ -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card document-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="document-icon bg-success text-white rounded p-2 me-3">
                            <i class="bi bi-file-earmark-text fs-4"></i>
                        </div>
                        <div class="grow 1">
                            <h6 class="card-title mb-1">LPJ</h6>
                            <span class="badge bg-primary year-badge">
                                <i class="bi bi-calendar me-1"></i>Tahun {{ $hibah->tahun }}
                            </span>
                        </div>
                    </div>

                    <div class="document-status mb-3">
                        @if($hibah->lpj_path)
                            <small class="text-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Tersedia untuk {{ $hibah->tahun }}
                            </small>
                        @else
                            <small class="text-warning">
                                <i class="bi bi-clock me-1"></i>
                                Belum tersedia
                            </small>
                        @endif
                    </div>

                    <div class="quick-actions">
                        @if($hibah->lpj_path)
                            <div class="btn-group w-100 mb-2">
                                <a href="{{ route('hibah.documents.preview', [$hibah->id, 'lpj']) }}" 
                                   class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <a href="{{ route('hibah.documents.download', [$hibah->id, 'lpj']) }}" 
                                   class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-download"></i> Unduh
                                </a>
                            </div>
                        @endif
                        
                        @if(Auth::user() && Auth::user()->role === 'admin')
                        <form action="{{ route('hibah.documents.upload', $hibah->id) }}" method="POST" 
                              enctype="multipart/form-data" class="mb-0">
                            @csrf
                            <input type="hidden" name="document_type" value="lpj">
                            <div class="upload-area" onclick="document.getElementById('file-lpj').click()">
                                <i class="bi bi-cloud-arrow-up fs-4 text-muted mb-2"></i>
                                <p class="small mb-1">Upload LPJ untuk <strong>Tahun {{ $hibah->tahun }}</strong></p>
                                <p class="small text-muted mb-0">Format: PDF (Maks. 10MB)</p>
                                <input type="file" name="document_file" 
                                       id="file-lpj" 
                                       class="d-none" 
                                       accept=".pdf"
                                       onchange="this.form.submit()">
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen Pendukung Shared -->
        <div class="col-12 mb-4 mt-4">
            <h5 class="border-bottom pb-2">
                <i class="bi bi-share me-2"></i>Dokumen Pendukung (Shared untuk Semua LKS Tahun {{ $hibah->tahun }})
            </h5>
        </div>

        @php
            $supportingDocuments = [
                'hasil_verifikasi' => ['icon' => 'bi-clipboard-check', 'title' => 'Hasil Verifikasi', 'color' => 'primary'],
                'pergub_penjabaran_apbd' => ['icon' => 'bi-file-earmark-text', 'title' => 'Pergub Penjabaran APBD', 'color' => 'info'],
                'dpa' => ['icon' => 'bi-file-text', 'title' => 'DPA', 'color' => 'secondary'],
                'hasil_identifikasi' => ['icon' => 'bi-person-check', 'title' => 'Hasil Identifikasi', 'color' => 'success'],
                'data_penerima_hibah' => ['icon' => 'bi-people', 'title' => 'Data Penerima Hibah', 'color' => 'warning'],
                'spm' => ['icon' => 'bi-cash-coin', 'title' => 'SPM', 'color' => 'danger'],
                'sp2d' => ['icon' => 'bi-receipt', 'title' => 'SP2D', 'color' => 'dark'],
                'petunjuk_teknis' => ['icon' => 'bi-journal-text', 'title' => 'Petunjuk Teknis', 'color' => 'primary']
            ];
        @endphp

        @foreach($supportingDocuments as $docType => $docInfo)
            @php
                $fileField = $docType . '_path';
                $hasFile = !empty($hibah->$fileField);
            @endphp
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card document-card h-100 shared-document">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="document-icon bg-{{ $docInfo['color'] }} text-white rounded p-2 me-3">
                                <i class="{{ $docInfo['icon'] }} fs-4"></i>
                            </div>
                            <div class="grow 1">
                                <h6 class="card-title mb-1">{{ $docInfo['title'] }}</h6>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success year-badge">
                                        <i class="bi bi-share me-1"></i>
                                        Shared
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="document-status mb-3">
                            @if($hasFile)
                                <small class="text-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Tersedia untuk semua LKS
                                </small>
                                <br>
                                <small class="text-muted">
                                    Digunakan oleh {{ $totalLksTahunIni }} LKS
                                </small>
                            @else
                                <small class="text-warning">
                                    <i class="bi bi-clock me-1"></i>
                                    Belum tersedia
                                </small>
                            @endif
                        </div>

                        <div class="quick-actions">
                            @if($hasFile)
                                <div class="btn-group w-100 mb-2">
                                    <a href="{{ route('hibah.documents.preview', [$hibah->id, $docType]) }}" 
                                       class="btn btn-outline-primary btn-sm" target="_blank">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('hibah.documents.download', [$hibah->id, $docType]) }}" 
                                       class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-download"></i> Unduh
                                    </a>
                                    @if(Auth::user() && Auth::user()->role === 'admin')
                                    <form action="{{ route('hibah.documents.delete', $hibah->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="document_type" value="{{ $docType }}">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Hapus {{ $docInfo['title'] }} untuk semua LKS tahun {{ $hibah->tahun }}?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            @endif
                            
                            @if(Auth::user() && Auth::user()->role === 'admin')
                            <form action="{{ route('hibah.documents.upload', $hibah->id) }}" method="POST" 
                                  enctype="multipart/form-data" class="mb-0">
                                @csrf
                                <input type="hidden" name="document_type" value="{{ $docType }}">
                                <div class="upload-area" onclick="document.getElementById('file-{{ $docType }}').click()">
                                    <i class="bi bi-cloud-arrow-up fs-4 text-muted mb-2"></i>
                                    <p class="small mb-1">Upload untuk <strong>Semua LKS Tahun {{ $hibah->tahun }}</strong></p>
                                    <p class="small text-muted mb-0">Format: PDF (Maks. 10MB)</p>
                                    <input type="file" name="document_file" 
                                           id="file-{{ $docType }}" 
                                           class="d-none" 
                                           accept=".pdf"
                                           onchange="this.form.submit()">
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Info Panel -->
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Sistem Dokumen Terpusat</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Dokumen Spesifik Tahun:</h6>
                    <ul class="small">
                        <li><strong>Proposal</strong> - Diupload saat buat data baru, spesifik per LKS per tahun</li>
                        <li><strong>LPJ</strong> - Diupload terpisah untuk setiap LKS per tahun</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Dokumen Pendukung Shared:</h6>
                    <ul class="small">
                        <li>Hasil Verifikasi, Pergub APBD, DPA, dll.</li>
                        <li>Diupload <strong>sekali saja</strong> dan berlaku untuk semua LKS dalam tahun yang sama</li>
                        <li>Perubahan akan mempengaruhi semua LKS tahun {{ $hibah->tahun }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Upload Modal -->
@if(Auth::user() && Auth::user()->role === 'admin')
<div class="modal fade" id="bulkUploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-upload me-2"></i>Upload Massal Dokumen Pendukung
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('hibah.bulk-upload-supporting', $hibah->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Dokumen yang diupload akan berlaku untuk <strong>semua LKS tahun {{ $hibah->tahun }}</strong>.
                        Total: <strong>{{ $totalLksTahunIni }} LKS</strong>.
                    </div>
                    
                    <div class="row">
                        @foreach($supportingDocuments as $docType => $docInfo)
                        <div class="col-md-6 mb-3">
                            <label class="form-label small">{{ $docInfo['title'] }}</label>
                            <input type="file" name="supporting_documents[{{ $docType }}]" 
                                   class="form-control form-control-sm" accept=".pdf">
                            <small class="text-muted">Aplikasikan ke semua LKS tahun {{ $hibah->tahun }}</small>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-arrow-up me-2"></i>Upload Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    $(document).ready(function() {
        // Drag and drop functionality
        $('.upload-area').on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('dragover');
        });

        $('.upload-area').on('dragleave drop', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            $('.alert').alert('close');
        }, 5000);
    });
</script>
@endpush

@endsection