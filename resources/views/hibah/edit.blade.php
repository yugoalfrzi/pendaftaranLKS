@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Data Hibah LKS</h4>
        <a href="{{ route('hibah.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('hibah.update', $hibah) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama LKS</label>
                    <input type="text" name="nama_lks" class="form-control" value="{{ old('nama_lks', $hibah->nama_lks) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $hibah->tahun ?? now()->year) }}" min="2023" max="2100">
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Proposal (PDF)</label>
                        <input type="file" name="proposal" class="form-control" accept="application/pdf">
                        @if($hibah->proposal_path)
                        <div class="mt-1">
                            <a href="{{ route('storage.local', ['path' => $hibah->proposal_path]) }}" target="_blank" class="file-link">
                                <i class="bi bi-file-pdf me-1"></i> File saat ini
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">LPJ (PDF)</label>
                        <input type="file" name="proposal" class="form-control" accept="application/pdf">
                        @if($hibah->lpj_path)
                        <div class="mt-1">
                            <a href="{{ route('storage.local', ['path' => $hibah->lpj_path]) }}" target="_blank" class="file-link">
                                <i class="bi bi-file-pdf me-1"></i> File saat ini
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


