@extends('layouts.app')

@section('title', 'Tambah Dokumen Baru')
@section('page-title', 'Tambah Dokumen')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-plus-circle"></i> Tambah Dokumen Baru
            </h1>
            <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-file-earmark-text"></i> Form Tambah Dokumen
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('documents.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_dokumen" class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" 
                               id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen') }}" required>
                        @error('nama_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Deskripsi singkat tentang dokumen ini (opsional)</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input @error('wajib') is-invalid @enderror" 
                                   type="checkbox" id="wajib" name="wajib" value="1" 
                                   {{ old('wajib') ? 'checked' : '' }}>
                            <label class="form-check-label" for="wajib">
                                Dokumen Wajib
                            </label>
                            @error('wajib')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Centang jika dokumen ini wajib dilengkapi untuk pendaftaran LKS</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="urutan" class="form-label">Urutan</label>
                        <input type="number" class="form-control @error('urutan') is-invalid @enderror" 
                               id="urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0">
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Urutan tampilan dokumen (0 = paling atas)</div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
