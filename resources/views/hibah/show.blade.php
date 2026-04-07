@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Detail Hibah LKS</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('hibah.index') }}" class="btn btn-outline-secondary">Kembali</a>
            @if(Auth::user() && Auth::user()->role === 'admin')
            <a href="{{ route('hibah.documents', $hibah) }}" class="btn btn-dark">
                <i class="bi bi-folder2-open me-1"></i> Kelola Dokumen
            </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Nama LKS:</strong>
                    <div>{{ $hibah->nama_lks ?? '-' }}</div>
                </div>
            </div>

            <div class="row g-3">
                @php
                    $files = [

                        'Hasil Verifikasi' => $hibah->hasil_verifikasi_path ?? null,
                        'Pergub Penjabaran APBD' => $hibah->pergub_penjabaran_apbd_path ?? null,
                        'DPA' => $hibah->dpa_path ?? null,
                        'Hasil Identifikasi' => $hibah->hasil_identifikasi_path ?? null,
                        'Data Penerima Hibah' => $hibah->data_penerima_hibah_path ?? null,
                        'SPM' => $hibah->spm_path ?? null,
                        'SP2D' => $hibah->sp2d_path ?? null,
                        'Petunjuk Teknis' => $hibah->petunjuk_teknis_path ?? null,
                    ];
                @endphp

                @foreach($files as $label => $path)
                <div class="col-md-6">
                    <div class="p-3 border rounded d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold">{{ $label }}</div>
                            <div class="text-muted small">PDF</div>
                        </div>
                        <div>
                            @if($path)
                                <a href="{{ route('files.local', ['path' => $path]) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-pdf"></i> Lihat
                                </a>
                            @else
                                <span class="badge bg-warning">Belum ada</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection


