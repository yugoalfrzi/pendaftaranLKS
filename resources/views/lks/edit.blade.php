@extends('layouts.app')

@section('title', 'Edit Data LKS')
@section('page-title', 'Edit LKS')

@section('content')
<style>
    .search-box {
        position: relative;
    }
    .search-box .bi-search {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #6c757d;
    }
    .search-box input {
        padding-left: 30px;
    }
    .checkbox-container {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 10px;
        background-color: #f8f9fa;
    }
    .checkbox-item {
        margin-bottom: 5px;
    }
    .checkbox-item:last-child {
        margin-bottom: 0;
    }
    .selected-items {
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        background-color: #e9ecef;
    }
    .counter-badge {
        background-color: #0d6efd;
        color: white;
        border-radius: 50%;
        padding: 5px 10px;
        font-size: 0.9em;
    }
    .action-buttons {
        margin-top: 10px;
    }
    .btn-action {
        min-width: 120px;
    }
    .btn-select-all {
        background-color: #198754;
        color: white;
    }
    .btn-select-all:hover {
        background-color: #157347;
        color: white;
    }
    .custom-file-upload {
        border: 2px dashed #dee2e6;
        border-radius: 0.375rem;
        padding: 0.75rem;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }
    .file-input-wrapper {
        transition: all 0.3s ease;
    }
    .file-input-wrapper .input-group {
        gap: 0.25rem;
    }
    .file-list-container {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.75rem;
        background-color: #f8f9fa;
        font-size: 0.875rem;
    }
    .file-list-container .selected-files ul {
        margin-bottom: 0.5rem;
        padding-left: 0;
    }
    .file-list-container .selected-files li {
        padding: 0.5rem;
        border-bottom: 1px solid #e9ecef;
        background: white;
        border-radius: 0.25rem;
        margin-bottom: 0.25rem;
    }
    .file-list-container .selected-files li:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    .status-alert .alert {
        font-size: 0.875rem;
        margin-bottom: 0;
        padding: 0.5rem 0.75rem;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    /* Custom scrollbar for file list */
    .file-list-container::-webkit-scrollbar {
        width: 6px;
    }
    .file-list-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .file-list-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .file-list-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    .selected-item {
        display: flex;
        justify-content: between;
        align-items: center;
        padding: 5px 10px;
        margin-bottom: 5px;
        background: white;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
    .remove-btn {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: auto;
        cursor: pointer;
    }
    .required-label::after {
        content: " *";
        color: #dc3545;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil-square"></i> Edit Data LKS
            </h1>
            <a href="{{ route('lks.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-file-earmark-text"></i> Form Edit LKS
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('lks.update', $lks->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Informasi Umum -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-info-circle"></i> Informasi Umum
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nama_lks" class="form-label required-label">Nama LKS</label>
                            <input type="text" class="form-control @error('nama_lks') is-invalid @enderror" 
                                   placeholder="Nama Sesuai Akta Notaris"
                                   id="nama_lks" name="nama_lks" value="{{ old('nama_lks', $lks->nama_lks) }}" required>
                            @error('nama_lks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nama_ketua_lks" class="form-label required-label">Nama Ketua LKS</label>
                            <input type="text" class="form-control @error('nama_ketua_lks') is-invalid @enderror"
                                   id="nama_ketua_lks" name="nama_ketua_lks" value="{{ old('nama_ketua_lks', $lks->nama_ketua_lks) }}" required>
                            @error('nama_ketua_lks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="alamat_lks" class="form-label required-label">Alamat LKS</label>
                            <textarea class="form-control @error('alamat_lks') is-invalid @enderror" 
                                      placeholder="Alamat Sesuai Surat Keterangan Domisili"  
                                      id="alamat_lks" name="alamat_lks" rows="3" required>{{ old('alamat_lks', $lks->alamat_lks) }}</textarea>
                            @error('alamat_lks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label required-label">Jenis Pelayanan</label>
                            <input type="hidden" id="jenis_pelayanan" name="jenis_pelayanan" value="{{ old('jenis_pelayanan', $lks->jenis_pelayanan) }}">
                            <div class="checkbox-container" id="jenisPelayananList">
                                @php
                                $opsiPelayanan = [
                                    'Anak balita terlantar',
                                    'Anak terlantar',
                                    'Anak yang berhadapan dengan hukum',
                                    'Anak jalanan',
                                    'Anak dengan kedisabilitasan (ADK)',
                                    'Anak menjadi korban tindak kekerasan',
                                    'Anak yang memerlukan perlindungan khusus',
                                    'Lansia',
                                    'Penyandang disabilitas',
                                    'Tuna Susila',
                                    'Gelandangan',
                                    'Pengemis',
                                    'Pemulung',
                                    'Kelompok minoritas',
                                    'Bekas warga binaan Lembaga Permasyarakatan (BWBLP)',
                                    'Orang dengan HIV/AIDS',
                                    'Korban penyalahgunaan NAPZA (Narkotika, Psikotropika, dan Zat Adiktif)',
                                    'Korban trafficking',
                                    'Korban tindak kekerasan',
                                    'Pekerja migran bermasalah sosial (PMBS)',
                                    'Korban bencana alam',
                                    'Korban bencana sosial',
                                    'Perempuan rawan sosial ekonomi',
                                    'Fakir miskin',
                                    'Keluarga bermasalah sosial psikologis',
                                    'Komunitas adat terpencil',
                                ];
                                $selected = collect(explode(',', old('jenis_pelayanan', $lks->jenis_pelayanan)))->map(fn($v) => trim($v));
                                @endphp
                                @foreach($opsiPelayanan as $idx => $opsi)
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input jenis-pelayanan-checkbox" type="checkbox" value="{{ $opsi }}" id="jp_{{ $idx }}" {{ $selected->contains($opsi) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="jp_{{ $idx }}">{{ $opsi }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('jenis_pelayanan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Centang satu atau lebih sesuai layanan.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jumlah_binaan_dalam_panti" class="form-label required-label">Jumlah Binaan Dalam Panti</label>
                            <input type="number" class="form-control @error('jumlah_binaan_dalam_panti') is-invalid @enderror" 
                                   placeholder="Jumlah Binaan"
                                   id="jumlah_binaan_dalam_panti" name="jumlah_binaan_dalam_panti" 
                                   value="{{ old('jumlah_binaan_dalam_panti', $lks->jumlah_binaan_dalam_panti) }}" min="0" required>
                            @error('jumlah_binaan_dalam_panti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jumlah_binaan_luar_panti" class="form-label required-label">Jumlah Binaan Luar Panti</label>
                            <input type="number" class="form-control @error('jumlah_binaan_luar_panti') is-invalid @enderror" 
                                   placeholder="Jumlah Binaan"
                                   id="jumlah_binaan_luar_panti" name="jumlah_binaan_luar_panti" 
                                   value="{{ old('jumlah_binaan_luar_panti', $lks->jumlah_binaan_luar_panti) }}" min="0" required>
                            @error('jumlah_binaan_luar_panti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nomor_kontak" class="form-label required-label">Nomor Kontak</label>
                            <input type="text" class="form-control @error('nomor_kontak') is-invalid @enderror" 
                                   placeholder="Nomor kontak aktif"
                                   id="nomor_kontak" name="nomor_kontak" value="{{ old('nomor_kontak', $lks->nomor_kontak) }}" required>
                            @error('nomor_kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="lokasi_lks" class="form-label required-label">Kabupaten/Kota</label>
                            <select class="form-select @error('lokasi_lks') is-invalid @enderror" 
                                    id="lokasi_lks" name="lokasi_lks" required>
                                <option value="">Pilih Kabupaten/Kota</option>
                                <option value="Kabupaten Bogor" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Bogor' ? 'selected' : ''}}>Kabupaten Bogor</option>
                                <option value="Kabupaten Sukabumi" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Sukabumi' ? 'selected' : '' }}>Kabupaten Sukabumi</option>
                                <option value="Kabupaten Cianjur" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Cianjur' ? 'selected' : ''}}>Kabupaten Cianjur</option>
                                <option value="Kabupaten Bandung" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Bandung' ? 'selected' : '' }}>Kabupaten Bandung</option>
                                <option value="Kabupaten Garut" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Garut' ? 'selected' : ''}}>Kabupaten Garut</option>
                                <option value="Kabupaten Tasikmalaya" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Tasikmalaya' ? 'selected' : '' }}>Kabupaten Tasikmalaya</option>
                                <option value="Kabupaten Ciamis" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Ciamis' ? 'selected' : ''}}>Kabupaten Ciamis</option>
                                <option value="Kabupaten Kuningan" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Kuningan' ? 'selected' : '' }}>Kabupaten Kuningan</option>
                                <option value="Kabupaten Cirebon" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Cirebon' ? 'selected' : ''}}>Kabupaten Cirebon</option>
                                <option value="Kabupaten Majalengka" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Majalengka' ? 'selected' : '' }}>Kabupaten Majalengka</option>
                                <option value="Kabupaten Sumedang" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Sumedang' ? 'selected' : ''}}>Kabupaten Sumedang</option>
                                <option value="Kabupaten Indramayu" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Indramayu' ? 'selected' : '' }}>Kabupaten Indramayu</option>
                                <option value="Kabupaten Subang" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Subang' ? 'selected' : ''}}>Kabupaten Subang</option>
                                <option value="Kabupaten Purwakarta" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Purwakarta' ? 'selected' : '' }}>Kabupaten Purwakarta</option>
                                <option value="Kabupaten Karawang" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Karawang' ? 'selected' : ''}}>Kabupaten Karawang</option>
                                <option value="Kabupaten Bekasi" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Bekasi' ? 'selected' : '' }}>Kabupaten Bekasi</option>
                                <option value="Kabupaten Bandung Barat" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Bandung Barat' ? 'selected' : ''}}>Kabupaten Bandung Barat</option>
                                <option value="Kabupaten Pangandaran" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kabupaten Pangandaran' ? 'selected' : '' }}>Kabupaten Pangandaran</option>
                                <option value="Kota Bogor" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kota Bogor' ? 'selected' : ''}}>Kota Bogor</option>
                                <option value="Kota Sukabumi" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kota Sukabumi' ? 'selected' : '' }}>Kota Sukabumi</option>
                                <option value="Kota Bandung" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kota Bandung' ? 'selected' : '' }}>Kota Bandung</option>
                                <option value="Kota Cirebon" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kota Cirebon' ? 'selected' : ''}}>Kota Cirebon</option>
                                <option value="Kota Bekasi" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kota Bekasi' ? 'selected' : '' }}>Kota Bekasi</option>
                                <option value="Kota Depok" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kota Depok' ? 'selected' : ''}}>Kota Depok</option>
                                <option value="Kota Cimahi" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kota Cimahi' ? 'selected' : '' }}>Kota Cimahi</option>
                                <option value="Kota Tasikmalaya" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kota Tasikmalaya' ? 'selected' : ''}}>Kota Tasikmalaya</option>
                                <option value="Kota Banjar" {{ old('lokasi_lks', $lks->lokasi_lks) == 'Kota Banjar' ? 'selected' : '' }}>Kota Banjar</option>
                            </select>
                            @error('lokasi_lks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pusat & Cabang LKS: hanya tampil untuk kewenangan Provinsi --}}
                        <div id="pusat_cabang_section" style="{{ old('kewenangan_type', $lks->kewenangan_type) === 'kabkota' ? 'display:none;' : '' }}">
                        <div class="col-md-6 mb-3">
                            <label for="pusat_lks" class="form-label required-label">Pusat LKS</label>
                            <select class="form-select @error('pusat_lks') is-invalid @enderror" 
                                    id="pusat_lks" name="pusat_lks">
                                <option value="">Pilih Kabupaten/Kota</option>
                                <option value="Kabupaten Bogor" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Bogor' ? 'selected' : ''}}>Kabupaten Bogor</option>
                                <option value="Kabupaten Sukabumi" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Sukabumi' ? 'selected' : '' }}>Kabupaten Sukabumi</option>
                                <option value="Kabupaten Cianjur" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Cianjur' ? 'selected' : ''}}>Kabupaten Cianjur</option>
                                <option value="Kabupaten Bandung" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Bandung' ? 'selected' : '' }}>Kabupaten Bandung</option>
                                <option value="Kabupaten Garut" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Garut' ? 'selected' : ''}}>Kabupaten Garut</option>
                                <option value="Kabupaten Tasikmalaya" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Tasikmalaya' ? 'selected' : '' }}>Kabupaten Tasikmalaya</option>
                                <option value="Kabupaten Ciamis" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Ciamis' ? 'selected' : ''}}>Kabupaten Ciamis</option>
                                <option value="Kabupaten Kuningan" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Kuningan' ? 'selected' : '' }}>Kabupaten Kuningan</option>
                                <option value="Kabupaten Cirebon" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Cirebon' ? 'selected' : ''}}>Kabupaten Cirebon</option>
                                <option value="Kabupaten Majalengka" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Majalengka' ? 'selected' : '' }}>Kabupaten Majalengka</option>
                                <option value="Kabupaten Sumedang" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Sumedang' ? 'selected' : ''}}>Kabupaten Sumedang</option>
                                <option value="Kabupaten Indramayu" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Indramayu' ? 'selected' : '' }}>Kabupaten Indramayu</option>
                                <option value="Kabupaten Subang" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Subang' ? 'selected' : ''}}>Kabupaten Subang</option>
                                <option value="Kabupaten Purwakarta" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Purwakarta' ? 'selected' : '' }}>Kabupaten Purwakarta</option>
                                <option value="Kabupaten Karawang" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Karawang' ? 'selected' : ''}}>Kabupaten Karawang</option>
                                <option value="Kabupaten Bekasi" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Bekasi' ? 'selected' : '' }}>Kabupaten Bekasi</option>
                                <option value="Kabupaten Bandung Barat" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Bandung Barat' ? 'selected' : ''}}>Kabupaten Bandung Barat</option>
                                <option value="Kabupaten Pangandaran" {{ old('pusat_lks', $lks->pusat_lks) == 'Kabupaten Pangandaran' ? 'selected' : '' }}>Kabupaten Pangandaran</option>
                                <option value="Kota Bogor" {{ old('pusat_lks', $lks->pusat_lks) == 'Kota Bogor' ? 'selected' : ''}}>Kota Bogor</option>
                                <option value="Kota Sukabumi" {{ old('pusat_lks', $lks->pusat_lks) == 'Kota Sukabumi' ? 'selected' : '' }}>Kota Sukabumi</option>
                                <option value="Kota Bandung" {{ old('pusat_lks', $lks->pusat_lks) == 'Kota Bandung' ? 'selected' : '' }}>Kota Bandung</option>
                                <option value="Kota Cirebon" {{ old('pusat_lks', $lks->pusat_lks) == 'Kota Cirebon' ? 'selected' : ''}}>Kota Cirebon</option>
                                <option value="Kota Bekasi" {{ old('pusat_lks', $lks->pusat_lks) == 'Kota Bekasi' ? 'selected' : '' }}>Kota Bekasi</option>
                                <option value="Kota Depok" {{ old('pusat_lks', $lks->pusat_lks) == 'Kota Depok' ? 'selected' : ''}}>Kota Depok</option>
                                <option value="Kota Cimahi" {{ old('pusat_lks', $lks->pusat_lks) == 'Kota Cimahi' ? 'selected' : '' }}>Kota Cimahi</option>
                                <option value="Kota Tasikmalaya" {{ old('pusat_lks', $lks->pusat_lks) == 'Kota Tasikmalaya' ? 'selected' : ''}}>Kota Tasikmalaya</option>
                                <option value="Kota Banjar" {{ old('pusat_lks', $lks->pusat_lks) == 'Kota Banjar' ? 'selected' : '' }}>Kota Banjar</option>
                            </select>
                            @error('pusat_lks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label required-label">Cabang LKS</label>
                            <input type="hidden" name="cabang_lks" id="cabang_lks_hidden" value="{{ old('cabang_lks', $lks->cabang_lks) }}">
                            <div class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" id="searchInput" class="form-control" placeholder="Ketik nama kabupaten/kota...">
                            </div>
                            <div class="checkbox-container" id="checkboxList">
                                <!-- Kabupaten Options -->
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Bogor" id="bogorKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Bogor') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bogorKab">Kabupaten Bogor</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Sukabumi" id="sukabumiKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Sukabumi') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sukabumiKab">Kabupaten Sukabumi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Cianjur" id="cianjurKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Cianjur') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cianjurKab">Kabupaten Cianjur</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Bandung" id="bandungKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Bandung') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bandungKab">Kabupaten Bandung</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Garut" id="garutKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Garut') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="garutKab">Kabupaten Garut</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Tasikmalaya" id="tasikmalayaKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Tasikmalaya') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tasikmalayaKab">Kabupaten Tasikmalaya</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Ciamis" id="ciamisKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Ciamis') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ciamisKab">Kabupaten Ciamis</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Kuningan" id="kuninganKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Kuningan') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kuninganKab">Kabupaten Kuningan</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Cirebon" id="cirebonKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Cirebon') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cirebonKab">Kabupaten Cirebon</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Majalengka" id="majalengkaKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Majalengka') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="majalengkaKab">Kabupaten Majalengka</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Sumedang" id="sumedangKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Sumedang') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sumedangKab">Kabupaten Sumedang</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Indramayu" id="indramayuKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Indramayu') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="indramayuKab">Kabupaten Indramayu</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Subang" id="subangKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Subang') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="subangKab">Kabupaten Subang</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Purwakarta" id="purwakartaKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Purwakarta') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="purwakartaKab">Kabupaten Purwakarta</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Karawang" id="karawangKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Karawang') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="karawangKab">Kabupaten Karawang</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Bekasi" id="bekasiKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Bekasi') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bekasiKab">Kabupaten Bekasi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Bandung Barat" id="bandungBaratKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Bandung Barat') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bandungBaratKab">Kabupaten Bandung Barat</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kabupaten Pangandaran" id="pangandaranKab" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kabupaten Pangandaran') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pangandaranKab">Kabupaten Pangandaran</label>
                                    </div>
                                </div>
                            
                                <!-- Kota Options -->
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Bogor" id="bogorKota" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Bogor') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bogorKota">Kota Bogor</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Sukabumi" id="sukabumiKota" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Sukabumi') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sukabumiKota">Kota Sukabumi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Bandung" id="bandungKota" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Bandung') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bandungKota">Kota Bandung</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Cirebon" id="cirebonKota" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Cirebon') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cirebonKota">Kota Cirebon</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Bekasi" id="bekasiKota" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Bekasi') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bekasiKota">Kota Bekasi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Depok" id="depokKota" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Depok') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="depokKota">Kota Depok</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Cimahi" id="cimahiKota" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Cimahi') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cimahiKota">Kota Cimahi</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Tasikmalaya" id="tasikmalayaKota" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Tasikmalaya') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tasikmalayaKota">Kota Tasikmalaya</label>
                                    </div>
                                </div>
                                <div class="checkbox-item">
                                    <div class="form-check">
                                        <input class="form-check-input cabang-checkbox" type="checkbox" value="Kota Banjar" id="banjarKota" {{ str_contains(old('cabang_lks', $lks->cabang_lks), 'Kota Banjar') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="banjarKota">Kota Banjar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-4 action-buttons">
                                <button type="button" class="btn btn-select-all" id="selectAllBtn">
                                    <i class="bi bi-check-all"></i> Pilih Semua
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-action" id="clearAllBtn">
                                    <i class="bi bi-x-circle"></i> Hapus Semua
                                </button>
                            </div>

                            <div class="selected-items" id="selectedItems">
                                <!-- Selected items will be displayed here -->
                            </div>
                        </div>
                        </div>{{-- end pusat_cabang_section --}}

                        <div class="col-md-6 mb-3">
                            <label for="tanda_pendaftaran" class="form-label required-label">Tanda Pendaftaran</label>
                            <select class="form-select @error('tanda_pendaftaran') is-invalid @enderror" 
                                id="tanda_pendaftaran" name="tanda_pendaftaran" required>
                                <option value="">Pilih Tanda Pendaftaran</option>
                                <option value="Baru" {{ old('tanda_pendaftaran', $lks->tanda_pendaftaran) == 'Baru' ? 'selected' : ''}}>Baru</option>
                                <option value="Perpanjangan" {{ old('tanda_pendaftaran', $lks->tanda_pendaftaran) == 'Perpanjangan' ? 'selected' : '' }}>Perpanjangan</option>
                            </select>
                            @error('tanda_pendaftaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="tanggal_masuk_dokumen" class="form-label required-label">Tanggal Masuk Dokumen</label>
                            <input type="date" class="form-control @error('tanggal_masuk_dokumen') is-invalid @enderror" 
                                   id="tanggal_masuk_dokumen" name="tanggal_masuk_dokumen" 
                                   value="{{ old('tanggal_masuk_dokumen', $lks->tanggal_masuk_dokumen ? $lks->tanggal_masuk_dokumen->format('Y-m-d') : '') }}" required>
                            @error('tanggal_masuk_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Checklist Dokumen -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-check2-square"></i> Edit Checklist Kelengkapan Dokumen
                            </h6>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> 
                                <strong>Petunjuk:</strong> Klik "Tambah File" untuk menambahkan multiple files. File akan ditambahkan satu per satu.
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="25%">Nama Dokumen</th>
                                            <th width="25%">Upload File Baru</th>
                                            <th width="30%">File Sebelumnya</th>
                                            <th width="15%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lks->checklists as $index => $checklist)
                                        @php
                                            $docName = $checklist->document->nama_dokumen ?? '';
                                            $isPerpanjanganKabkota = str_contains($docName, 'sebelumnya') && str_contains(strtolower($docName), 'kabupaten kota');
                                            $isPerpanjanganProvinsi = str_contains($docName, 'sebelumnya') && str_contains(strtolower($docName), 'provinsi');
                                            $editRowClass = '';
                                            if ($isPerpanjanganKabkota) {
                                                $editRowClass = 'doc-perpanjangan-kabkota';
                                            } elseif ($isPerpanjanganProvinsi) {
                                                $editRowClass = 'doc-perpanjangan-provinsi doc-provinsi-only';
                                            } elseif (($checklist->document->urutan ?? 0) >= 17) {
                                                $editRowClass = 'doc-provinsi-only';
                                            }
                                        @endphp
                                        <tr class="{{ $editRowClass }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $checklist->document->nama_dokumen }}</strong>
                                                @if($checklist->document->wajib)
                                                    <span class="badge bg-danger ms-2">Wajib</span>
                                                @endif
                                                <input type="hidden" name="documents[{{ $index }}][document_id]" value="{{ $checklist->document_id }}">
                                                <input type="hidden" name="documents[{{ $index }}][kelengkapan]" id="kelengkapan_{{ $index }}" value="{{ $checklist->kelengkapan }}">
                                            </td>
                                            <td>
                                                <!-- File Upload Container -->
                                                <div id="file_upload_container_{{ $index }}">
                                                    <!-- Dynamic file inputs will be added here -->
                                                    <div class="file-input-wrapper mb-2">
                                                        <input type="file" 
                                                               class="form-control form-control-sm single-file-input" 
                                                               name="documents[{{ $index }}][files][]" 
                                                               data-index="{{ $index }}"
                                                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                    </div>
                                                </div>
                                                
                                                <!-- Add More Files Button -->
                                                <button type="button" class="btn btn-outline-primary btn-sm add-more-files" data-index="{{ $index }}">
                                                    <i class="bi bi-plus-circle"></i> Tambah File Lain
                                                </button>
                                                
                                                <small class="text-muted d-block mt-1">PDF, JPG, PNG, DOC (Max 2MB per file)</small>
                                            </td>
                                            <td>
                                                @if($checklist->has_files)
                                                    <div class="existing-files-container">
                                                        <small class="text-success fw-bold d-block mb-2">
                                                            <i class="bi bi-folder-check"></i> 
                                                            File saat ini ({{ $checklist->file_count }})
                                                        </small>
                                                        @foreach($checklist->getFilesInfo() as $fileIndex => $file)
                                                        <div class="existing-file-item d-flex justify-content-between align-items-center p-2 mb-2 border rounded bg-white">
                                                            <div class="file-info">
                                                                <i class="bi bi-file-earmark-check text-success"></i>
                                                                <a href="{{ route('lks.files.show', [$lks->id, $checklist->id, $file['index']]) }}" target="_blank" class="text-decoration-none ms-2">
                                                                    <small>{{ $file['name'] }}</small>
                                                                </a>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-primary">File {{ $fileIndex + 1 }}</span>
                                                                <button type="button" class="btn btn-sm btn-outline-danger delete-file-btn"
                                                                        data-url="{{ route('lks.files.destroy', [$lks->id, $checklist->id, $file['index']]) }}"
                                                                        data-confirm="Hapus file ini?">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="bi bi-file-earmark-x"></i> Belum ada file
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" 
                                                       name="documents[{{ $index }}][keterangan]" 
                                                       value="{{ $checklist->keterangan ?? '' }}" 
                                                       placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('lks.show', $lks->id) }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Update Data
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== KEWENANGAN & PERPANJANGAN TOGGLE DOKUMEN ==========
    const kewRadios = document.querySelectorAll('input[name="kewenangan_type"]');
    const tandaPendaftaranSelect = document.getElementById('tanda_pendaftaran');

    function toggleDokumen() {
        const isProvinsi = document.querySelector('input[name="kewenangan_type"]:checked')?.value === 'provinsi';
        const isPerpanjangan = tandaPendaftaranSelect?.value === 'Perpanjangan';

        // Baris provinsi-only biasa
        document.querySelectorAll('tr.doc-provinsi-only').forEach(row => {
            if (row.classList.contains('doc-perpanjangan-provinsi')) return;
            const show = isProvinsi;
            row.style.display = show ? '' : 'none';
            row.querySelectorAll('input, textarea, select').forEach(el => el.disabled = !show);
        });

        // Baris perpanjangan kabkota: tampil hanya jika kabkota + perpanjangan
        document.querySelectorAll('tr.doc-perpanjangan-kabkota').forEach(row => {
            const show = !isProvinsi && isPerpanjangan;
            row.style.display = show ? '' : 'none';
            row.querySelectorAll('input, textarea, select').forEach(el => el.disabled = !show);
        });

        // Baris perpanjangan provinsi: tampil hanya jika provinsi + perpanjangan
        document.querySelectorAll('tr.doc-perpanjangan-provinsi').forEach(row => {
            const show = isProvinsi && isPerpanjangan;
            row.style.display = show ? '' : 'none';
            row.querySelectorAll('input, textarea, select').forEach(el => el.disabled = !show);
        });

        // Toggle pusat & cabang LKS
        const pusatCabangSection = document.getElementById('pusat_cabang_section');
        if (pusatCabangSection) {
            pusatCabangSection.style.display = isProvinsi ? '' : 'none';
            const pusatSelect = document.getElementById('pusat_lks');
            if (pusatSelect) pusatSelect.required = isProvinsi;
            pusatCabangSection.querySelectorAll('input, select').forEach(el => {
                el.disabled = !isProvinsi;
            });
        }
    }

    toggleDokumen();
    kewRadios.forEach(radio => radio.addEventListener('change', toggleDokumen));
    if (tandaPendaftaranSelect) {
        tandaPendaftaranSelect.addEventListener('change', toggleDokumen);
    }

    // Auto-fill today's date for tanggal_masuk_dokumen if empty
    const tanggalMasukInput = document.getElementById('tanggal_masuk_dokumen');
    if (tanggalMasukInput && !tanggalMasukInput.value) {
        tanggalMasukInput.value = new Date().toISOString().split('T')[0];
    }

    // ========== JENIS PELAYANAN FUNCTIONALITY ==========
    const jenisPelayananCheckboxes = document.querySelectorAll('.jenis-pelayanan-checkbox');
    const jenisPelayananHidden = document.getElementById('jenis_pelayanan');

    function updateJenisPelayanan() {
        const selectedValues = Array.from(jenisPelayananCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);
        
        jenisPelayananHidden.value = selectedValues.join(', ');
        
        console.log('Jenis Pelayanan Selected:', selectedValues); // Debug
        console.log('Hidden Input Value:', jenisPelayananHidden.value); // Debug
    }

    // Initialize jenis pelayanan
    updateJenisPelayanan();

    // Add event listeners for jenis pelayanan checkboxes
    jenisPelayananCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateJenisPelayanan);
    });

    // Form validation for jenis pelayanan
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const selectedValues = Array.from(jenisPelayananCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            
            if (selectedValues.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu jenis pelayanan');
                return false;
            }
            
            // Final update before submit
            updateJenisPelayanan();
        });
    }

    // ========== CABANG LKS FUNCTIONALITY ==========
    const cabangCheckboxes = document.querySelectorAll('.cabang-checkbox');
    const selectedItemsContainer = document.getElementById('selectedItems');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const clearAllBtn = document.getElementById('clearAllBtn');
    const searchInput = document.getElementById('searchInput');
    const cabangLksHidden = document.getElementById('cabang_lks_hidden');

    // Function to update selected items display and hidden input
    function updateSelectedItems() {
        const selectedCheckboxes = Array.from(cabangCheckboxes).filter(checkbox => checkbox.checked);
        const selectedValues = selectedCheckboxes.map(checkbox => checkbox.value);

        // Update hidden input
        cabangLksHidden.value = selectedValues.join(', ');

        if (selectedValues.length === 0) {
            selectedItemsContainer.innerHTML = '<div class="text-muted">Belum ada pilihan. Silakan pilih dari daftar di atas.</div>';
            return;
        }
        
        selectedItemsContainer.innerHTML = '';
        selectedValues.forEach(value => {
            const item = document.createElement('div');
            item.className = 'selected-item';
            item.innerHTML = `
                ${value}
                <button type="button" class="remove-btn" data-value="${value}">
                    <i class="bi bi-x"></i>
                </button>
            `;
            selectedItemsContainer.appendChild(item);
        });

        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const valueToRemove = this.getAttribute('data-value');
                const checkboxToUncheck = Array.from(cabangCheckboxes).find(cb => cb.value === valueToRemove);
                if (checkboxToUncheck) {
                    checkboxToUncheck.checked = false;
                    updateSelectedItems();
                }
            });
        });
    }

    // Initial update for cabang LKS
    updateSelectedItems();

    // Event listener for cabang checkbox changes
    cabangCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedItems);
    });

    // Select all functionality
    selectAllBtn.addEventListener('click', function() {
        cabangCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateSelectedItems();
    });

    // Clear all functionality
    clearAllBtn.addEventListener('click', function() {
        cabangCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectedItems();
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const checkboxItems = document.querySelectorAll('.checkbox-item');

        checkboxItems.forEach(item => {
            const label = item.querySelector('.form-check-label');
            if (label.textContent.toLowerCase().includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // ========== FILE UPLOAD FUNCTIONALITY ==========
    const fileStorage = {};
    
    // Add more files functionality
    document.querySelectorAll('.add-more-files').forEach(button => {
        button.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            addFileInput(index);
        });
    });

    // Handle file input changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('single-file-input')) {
            const index = e.target.getAttribute('data-index');
            handleFileChange(index);
        }
    });

    // Handle file removal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-file') || 
            e.target.closest('.remove-file')) {
            const button = e.target.classList.contains('remove-file') ? e.target : e.target.closest('.remove-file');
            const index = button.getAttribute('data-index');
            const fileName = button.getAttribute('data-filename');
            removeFile(index, fileName);
        }
    });

    function addFileInput(index) {
        const container = document.getElementById(`file_upload_container_${index}`);
        const inputCount = container.querySelectorAll('.single-file-input').length;
        
        const inputWrapper = document.createElement('div');
        inputWrapper.className = 'file-input-wrapper mb-2';
        inputWrapper.innerHTML = `
            <div class="input-group input-group-sm">
                <input type="file" 
                       class="form-control form-control-sm single-file-input" 
                       name="documents[${index}][files][]" 
                       data-index="${index}"
                       accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                <button type="button" class="btn btn-outline-danger btn-sm remove-input">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        
        container.appendChild(inputWrapper);

        // Add remove functionality for this specific input
        inputWrapper.querySelector('.remove-input').addEventListener('click', function() {
            inputWrapper.remove();
            handleFileChange(index);
        });
    }

    function handleFileChange(index) {
        const container = document.getElementById(`file_upload_container_${index}`);
        const inputs = container.querySelectorAll('.single-file-input');
        const kelengkapanInput = document.getElementById(`kelengkapan_${index}`);

        // Collect all files
        const allFiles = [];
        inputs.forEach(input => {
            if (input.files.length > 0) {
                allFiles.push(input.files[0]);
            }
        });

        // Initialize storage for this index if not exists
        if (!fileStorage[index]) {
            fileStorage[index] = [];
        }

        // Update storage with current files
        fileStorage[index] = allFiles;

        // Update UI
        updateFileList(index);
        updateStatus(index, allFiles.length);
    }

    function updateFileList(index) {
        const files = fileStorage[index] || [];
        const fileListContainer = document.getElementById(`file_list_${index}`);

        if (files.length > 0) {
            let fileListHTML = '<div class="selected-files mt-2">';
            fileListHTML += '<small class="text-success fw-bold">File terpilih (' + files.length + '):</small>';
            fileListHTML += '<ul class="list-unstyled mt-1 mb-2">';

            let totalSize = 0;
            let validFiles = 0;

            files.forEach((file, i) => {
                const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
                totalSize += parseFloat(fileSizeMB);

                if (file.size <= 2 * 1024 * 1024) {
                    fileListHTML += `
                        <li class="mb-1 d-flex justify-content-between align-items-center">
                            <small class="text-success">
                                <i class="bi bi-file-earmark-check"></i>
                                ${file.name}
                                <span class="text-muted">(${fileSizeMB} MB)</span>
                            </small>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-file" 
                                    data-index="${index}" data-filename="${file.name}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </li>
                    `;
                    validFiles++;
                } else {
                    fileListHTML += `
                        <li class="mb-1 d-flex justify-content-between align-items-center">
                            <small class="text-danger">
                                <i class="bi bi-file-earmark-x"></i>
                                ${file.name}
                                <span class="badge bg-danger">${fileSizeMB} MB</span>
                            </small>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-file" 
                                    data-index="${index}" data-filename="${file.name}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </li>
                    `;
                }
            });

            fileListHTML += '</ul>';
            fileListHTML += `<small class="text-muted">Total size: ${totalSize.toFixed(2)} MB</small>`;
            
            if (validFiles < files.length) {
                fileListHTML += '<div class="alert alert-warning mt-2 py-1">';
                fileListHTML += '<small><i class="bi bi-exclamation-triangle"></i> Beberapa file melebihi 2MB</small>';
                fileListHTML += '</div>';
            }
            
            fileListHTML += '</div>';

            fileListContainer.innerHTML = fileListHTML;
        } else {
            fileListContainer.innerHTML = '';
        }
    }

    function updateStatus(index, fileCount) {
        const kelengkapanInput = document.getElementById(`kelengkapan_${index}`);

        if (fileCount > 0) {
            kelengkapanInput.value = 'Ada';
        } else {
            kelengkapanInput.value = 'Tidak Ada';
        }
    }

    function removeFile(index, fileName) {
        if (fileStorage[index]) {
            fileStorage[index] = fileStorage[index].filter(file => file.name !== fileName);
            
            // Also remove the corresponding file input
            const container = document.getElementById(`file_upload_container_${index}`);
            const inputs = container.querySelectorAll('.single-file-input');
            inputs.forEach(input => {
                if (input.files[0] && input.files[0].name === fileName) {
                    input.value = ''; // Clear the input
                }
            });
            
            updateFileList(index);
            updateStatus(index, fileStorage[index].length);
        }
    }

    // Initialize with one file input per row
    document.querySelectorAll('[id^="file_upload_container_"]').forEach(container => {
        const index = container.id.split('_').pop();
        if (!fileStorage[index]) {
            fileStorage[index] = [];
        }
    });

    // Handle delete single file
    document.querySelectorAll('.delete-file-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const confirmMsg = this.getAttribute('data-confirm') || 'Hapus file ini?';
            if (!url) return;
            if (!confirm(confirmMsg)) return;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: new URLSearchParams({ _method: 'DELETE' })
            }).then(resp => {
                if (resp.ok) {
                    window.location.reload();
                } else {
                    alert('Gagal menghapus file.');
                }
            }).catch(() => alert('Gagal menghapus file.'));
        });
    });

    // Handle delete all files for a checklist
    document.querySelectorAll('.delete-all-files-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const confirmMsg = this.getAttribute('data-confirm') || 'Hapus semua file untuk dokumen ini?';
            if (!url) return;
            if (!confirm(confirmMsg)) return;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: new URLSearchParams({ _method: 'DELETE' })
            }).then(resp => {
                if (resp.ok) {
                    window.location.reload();
                } else {
                    alert('Gagal menghapus semua file.');
                }
            }).catch(() => alert('Gagal menghapus semua file.'));
        });
    });
});
</script>
@endpush