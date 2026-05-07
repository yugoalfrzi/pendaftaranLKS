@extends('layouts.app')

@section('content')
<style>
    .card-modern { 
        border-radius:1.25rem; 
        border:1px solid #edf2f7; 
        background:#fff; 
        box-shadow:0 2px 8px rgba(0,0,0,0.02); 
        overflow:hidden; 
    }
    .card-header-custom { 
        background:#fff; 
        border-bottom:1px solid #eef2f6; 
        padding:0.9rem 1.25rem; 
        font-weight:600; 
        font-size:0.9rem; 
        display:flex; 
        align-items:center; 
        gap:0.5rem; 
    }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-semibold mb-1">Edit Data Hibah LKS</h4>
        <p class="text-muted small mb-0">Perbarui informasi dan dokumen hibah</p>
    </div>
    <a href="{{ route('hibah.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card-modern">
    <div class="card-header-custom">
        <i class="bi bi-pencil-square text-primary"></i> Form Edit Hibah
    </div>
    <div class="card-body p-4">
        <form action="{{ route('hibah.update', $hibah) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Nama LKS</label>
                    <input type="text" name="nama_lks" class="form-control form-control-sm"
                           value="{{ old('nama_lks', $hibah->nama_lks) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Tahun</label>
                    <input type="number" name="tahun" class="form-control form-control-sm"
                           value="{{ old('tahun', $hibah->tahun ?? now()->year) }}" min="2023" max="2100">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Proposal</label>
                    <input type="file" name="proposal" class="form-control form-control-sm" accept="*">
                    @if($hibah->proposal_path)
                    <div class="mt-1">
                        <a href="{{ route('storage.local', ['path' => $hibah->proposal_path]) }}" target="_blank"
                           class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-1">
                            <i class="bi bi-file-pdf me-1"></i> File saat ini
                        </a>
                    </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">LPJ</label>
                    <input type="file" name="lpj" class="form-control form-control-sm" accept="*">
                    @if($hibah->lpj_path)
                    <div class="mt-1">
                        <a href="{{ route('storage.local', ['path' => $hibah->lpj_path]) }}" target="_blank"
                           class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-1">
                            <i class="bi bi-file-pdf me-1"></i> File saat ini
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <button class="btn btn-primary btn-sm rounded-pill px-4" type="submit">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('hibah.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
