@extends('layouts.app')

@section('title', 'Edit Data LKS - Super Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil-square"></i> Edit Data LKS
            </h1>
            <a href="{{ route('superadmin.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-building"></i> Form Edit LKS
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('superadmin.update', $lks->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nama_lks" class="form-label">
                                Nama LKS <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_lks') is-invalid @enderror" 
                                   id="nama_lks" 
                                   name="nama_lks" 
                                   value="{{ old('nama_lks', $lks->nama_lks) }}" 
                                   required>
                            @error('nama_lks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="alamat_lks" class="form-label">
                                Alamat LKS <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('alamat_lks') is-invalid @enderror" 
                                      id="alamat_lks" 
                                      name="alamat_lks" 
                                      rows="3" 
                                      required>{{ old('alamat_lks', $lks->alamat_lks) }}</textarea>
                            @error('alamat_lks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nomor_kontak" class="form-label">
                                Nomor Kontak
                            </label>
                            <input type="text" 
                                   class="form-control @error('nomor_kontak') is-invalid @enderror" 
                                   id="nomor_kontak" 
                                   name="nomor_kontak" 
                                   value="{{ old('nomor_kontak', $lks->nomor_kontak) }}" 
                                   placeholder="08xxxxxxxxxx">
                            @error('nomor_kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kabupaten_kota" class="form-label">
                                Kabupaten/Kota
                            </label>
                            <input type="text" 
                                   class="form-control @error('kabupaten_kota') is-invalid @enderror" 
                                   id="kabupaten_kota" 
                                   name="kabupaten_kota" 
                                   value="{{ old('kabupaten_kota', $lks->kabupaten_kota) }}" 
                                   placeholder="Nama kabupaten/kota">
                            @error('kabupaten_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="lokasi_lks" class="form-label">
                                Lokasi LKS
                            </label>
                            <input type="text" 
                                   class="form-control @error('lokasi_lks') is-invalid @enderror" 
                                   id="lokasi_lks" 
                                   name="lokasi_lks" 
                                   value="{{ old('lokasi_lks', $lks->lokasi_lks) }}" 
                                   placeholder="Lokasi detail">
                            @error('lokasi_lks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status_permohonan" class="form-label">
                                Status Permohonan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status_permohonan') is-invalid @enderror" 
                                    id="status_permohonan" 
                                    name="status_permohonan" 
                                    required>
                                <option value="Menunggu" {{ old('status_permohonan', $lks->status_permohonan) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Diterima untuk proses" {{ old('status_permohonan', $lks->status_permohonan) == 'Diterima untuk proses' ? 'selected' : '' }}>Diterima untuk proses</option>
                                <option value="Diterima" {{ old('status_permohonan', $lks->status_permohonan) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Ditolak" {{ old('status_permohonan', $lks->status_permohonan) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="Dikembalikan" {{ old('status_permohonan', $lks->status_permohonan) == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                            @error('status_permohonan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Info User -->
                    @if($lks->user)
                    <div class="alert alert-info">
                        <strong><i class="bi bi-person"></i> Informasi Pendaftar:</strong><br>
                        Nama: {{ $lks->user->name }}<br>
                        Email: {{ $lks->user->email }}
                    </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('superadmin.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
