@extends('layouts.app')

@section('title', 'Tambah Data Kewenangan Provinsi')

@push('styles')
<style>
:root {
    --primary: #2c7be5;
    --primary-dark: #1a68d1;
    --secondary: #6e84a3;
    --success: #00d97e;
    --info: #39afd1;
    --warning: #f6c343;
    --danger: #e63757;
    --light: #f9fbfd;
    --dark: #12263f;
    --gradient-primary: linear-gradient(135deg, #2c7be5 0%, #1a68d1 100%);
    --gradient-success: linear-gradient(135deg, #00d97e 0%, #00b96b 100%);
    --gradient-warning: linear-gradient(135deg, #f6c343 0%, #f4b223 100%);
    --shadow-sm: 0 0.125rem 0.25rem rgba(18, 38, 63, 0.1);
    --shadow-md: 0 0.5rem 1rem rgba(18, 38, 63, 0.15);
    --shadow-lg: 0 1rem 2rem rgba(18, 38, 63, 0.2);
    --border-radius: 0.75rem;
    --border-radius-lg: 1rem;
}

.form-section {
    background: linear-gradient(135deg, #ffffff 0%, #f8fbfe 100%);
    border-radius: var(--border-radius-lg);
    padding: 2rem;
    margin-bottom: 2.5rem;
    border: 1px solid #e3ebf6;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.form-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--gradient-primary);
}

.form-section:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.form-section h6 {
    color: var(--primary);
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-section h6 i {
    font-size: 1.3rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.form-label {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control {
    border: 2px solid #e3ebf6;
    border-radius: var(--border-radius);
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fff;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
    background: #fff;
}

.form-control:hover {
    border-color: #b8c7e0;
}

.form-select {
    border: 2px solid #e3ebf6;
    border-radius: var(--border-radius);
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236e84a3' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}

.form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
}

.btn-primary {
    background: var(--gradient-primary);
    border: none;
    border-radius: var(--border-radius);
    padding: 0.75rem 2rem;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.btn-secondary {
    background: #fff;
    border: 2px solid #e3ebf6;
    color: var(--secondary);
    border-radius: var(--border-radius);
    padding: 0.75rem 2rem;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #f8fbfe;
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-1px);
}

.required {
    color: var(--danger);
    font-weight: 700;
}

.card {
    border: none;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-lg);
    background: #fff;
}

.card-header {
    background: var(--gradient-primary);
    border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0 !important;
    padding: 1.5rem 2rem;
    border: none;
}

.card-title {
    color: white;
    font-weight: 700;
    font-size: 1.3rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-body {
    padding: 2.5rem;
}

.table {
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    margin-bottom: 0;
}

.table th {
    background: var(--gradient-primary);
    color: white;
    font-weight: 600;
    padding: 1rem;
    border: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-color: #e3ebf6;
    background: #fff;
    transition: background-color 0.3s ease;
}

.table tbody tr:hover td {
    background: #f8fbfe;
}

.alert-danger {
    background: linear-gradient(135deg, #ffe6ea 0%, #ffd6dc 100%);
    border: none;
    border-radius: var(--border-radius);
    border-left: 4px solid var(--danger);
    color: var(--dark);
    box-shadow: var(--shadow-sm);
    padding: 1.25rem;
}

.section-divider {
    height: 2px;
    background: linear-gradient(90deg, transparent 0%, var(--primary) 50%, transparent 100%);
    margin: 2rem 0;
    opacity: 0.3;
}

.input-group-text {
    background: var(--gradient-primary);
    border: 2px solid #e3ebf6;
    border-right: none;
    color: white;
    font-weight: 600;
}

.badge-section {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--gradient-success);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-optional {
    background: var(--gradient-warning);
}

.progress-section {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: #e3ebf6;
    z-index: 9999;
}

.progress-bar {
    height: 100%;
    background: var(--gradient-primary);
    transition: width 0.3s ease;
    width: 0%;
}

.form-help {
    font-size: 0.8rem;
    color: var(--secondary);
    margin-top: 0.25rem;
}

.field-group {
    background: #f8fbfe;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e3ebf6;
}

.field-group-title {
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 1rem;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Dropdown Search Styles */
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

@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-section {
    animation: fadeInUp 0.5s ease-out;
}

.form-section:nth-child(even) {
    animation-delay: 0.1s;
}

.form-section:nth-child(odd) {
    animation-delay: 0.2s;
}

/* Custom checkbox and radio */
.form-check-input:checked {
    background-color: var(--primary);
    border-color: var(--primary);
}

.form-check-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
}

/* Province specific styling */
.province-badge {
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
}

.province-header {
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important;
}
</style>
@endpush

@section('content')
<div class="progress-section">
    <div class="progress-bar" id="formProgress"></div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header province-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-building-check"></i> Tambah Data Kewenangan Provinsi
                </h5>
            </div>
            <div class="card-body">
                {{-- Tampilkan error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <strong class="me-2">Perhatian!</strong> Terdapat kesalahan dalam pengisian form.
                        </div>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('kewenangan-provinsi.store') }}" method="POST" id="mainForm">
                    @csrf
                    
                    <!-- Identitas Yayasan -->
                    <div class="form-section">
                        <h6><i class="bi bi-building"></i> IDENTITAS YAYASAN</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lembaga/Yayasan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="Nama_Lembaga_Yayasan" rows="3" required placeholder="Masukkan nama lengkap lembaga/yayasan">{{ old('Nama_Lembaga_Yayasan') }}</textarea>
                                    @error('Nama_Lembaga_Yayasan')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="pusat" {{ old('status') == 'pusat' ? 'selected' : '' }}>Pusat</option>
                                        <option value="cabang" {{ old('status') == 'cabang' ? 'selected' : '' }}>Cabang</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                    <select class="form-select" name="kabupaten_kota" required>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        <option value="Kabupaten Bogor" {{ old('kabupaten_kota') == 'Kabupaten Bogor' ? 'selected' : '' }}>Kabupaten Bogor</option>
                                        <option value="Kabupaten Sukabumi" {{ old('kabupaten_kota') == 'Kabupaten Sukabumi' ? 'selected' : '' }}>Kabupaten Sukabumi</option>
                                        <option value="Kabupaten Cianjur" {{ old('kabupaten_kota') == 'Kabupaten Cianjur' ? 'selected' : '' }}>Kabupaten Cianjur</option>
                                        <option value="Kabupaten Bandung" {{ old('kabupaten_kota') == 'Kabupaten Bandung' ? 'selected' : '' }}>Kabupaten Bandung</option>
                                        <option value="Kabupaten Garut" {{ old('kabupaten_kota') == 'Kabupaten Garut' ? 'selected' : '' }}>Kabupaten Garut</option>
                                        <option value="Kabupaten Tasikmalaya" {{ old('kabupaten_kota') == 'Kabupaten Tasikmalaya' ? 'selected' : '' }}>Kabupaten Tasikmalaya</option>
                                        <option value="Kabupaten Ciamis" {{ old('kabupaten_kota') == 'Kabupaten Ciamis' ? 'selected' : '' }}>Kabupaten Ciamis</option>
                                        <option value="Kabupaten Kuningan" {{ old('kabupaten_kota') == 'Kabupaten Kuningan' ? 'selected' : '' }}>Kabupaten Kuningan</option>
                                        <option value="Kabupaten Cirebon" {{ old('kabupaten_kota') == 'Kabupaten Cirebon' ? 'selected' : '' }}>Kabupaten Cirebon</option>
                                        <option value="Kabupaten Majalengka" {{ old('kabupaten_kota') == 'Kabupaten Majalengka' ? 'selected' : '' }}>Kabupaten Majalengka</option>
                                        <option value="Kabupaten Sumedang" {{ old('kabupaten_kota') == 'Kabupaten Sumedang' ? 'selected' : '' }}>Kabupaten Sumedang</option>
                                        <option value="Kabupaten Indramayu" {{ old('kabupaten_kota') == 'Kabupaten Indramayu' ? 'selected' : '' }}>Kabupaten Indramayu</option>
                                        <option value="Kabupaten Subang" {{ old('kabupaten_kota') == 'Kabupaten Subang' ? 'selected' : '' }}>Kabupaten Subang</option>
                                        <option value="Kabupaten Purwakarta" {{ old('kabupaten_kota') == 'Kabupaten Purwakarta' ? 'selected' : '' }}>Kabupaten Purwakarta</option>
                                        <option value="Kabupaten Karawang" {{ old('kabupaten_kota') == 'Kabupaten Karawang' ? 'selected' : '' }}>Kabupaten Karawang</option>
                                        <option value="Kabupaten Bekasi" {{ old('kabupaten_kota') == 'Kabupaten Bekasi' ? 'selected' : '' }}>Kabupaten Bekasi</option>
                                        <option value="Kabupaten Bandung Barat" {{ old('kabupaten_kota') == 'Kabupaten Bandung Barat' ? 'selected' : '' }}>Kabupaten Bandung Barat</option>
                                        <option value="Kabupaten Pangandaran" {{ old('kabupaten_kota') == 'Kabupaten Pangandaran' ? 'selected' : '' }}>Kabupaten Pangandaran</option>
                                        <option value="Kota Bogor" {{ old('kabupaten_kota') == 'Kota Bogor' ? 'selected' : '' }}>Kota Bogor</option>
                                        <option value="Kota Sukabumi" {{ old('kabupaten_kota') == 'Kota Sukabumi' ? 'selected' : '' }}>Kota Sukabumi</option>
                                        <option value="Kota Bandung" {{ old('kabupaten_kota') == 'Kota Bandung' ? 'selected' : '' }}>Kota Bandung</option>
                                        <option value="Kota Cirebon" {{ old('kabupaten_kota') == 'Kota Cirebon' ? 'selected' : '' }}>Kota Cirebon</option>
                                        <option value="Kota Bekasi" {{ old('kabupaten_kota') == 'Kota Bekasi' ? 'selected' : '' }}>Kota Bekasi</option>
                                        <option value="Kota Depok" {{ old('kabupaten_kota') == 'Kota Depok' ? 'selected' : '' }}>Kota Depok</option>
                                        <option value="Kota Cimahi" {{ old('kabupaten_kota') == 'Kota Cimahi' ? 'selected' : '' }}>Kota Cimahi</option>
                                        <option value="Kota Tasikmalaya" {{ old('kabupaten_kota') == 'Kota Tasikmalaya' ? 'selected' : '' }}>Kota Tasikmalaya</option>
                                        <option value="Kota Banjar" {{ old('kabupaten_kota') == 'Kota Banjar' ? 'selected' : '' }}>Kota Banjar</option>
                                    </select>
                                    @error('kabupaten_kota')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ketua Yayasan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ketua_yayasan" value="{{ old('ketua_yayasan') }}" required placeholder="Masukkan nama ketua yayasan">
                                    @error('ketua_yayasan')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No. Telepon<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="no" value="{{ old('no') }}" placeholder="Masukkan nomor telepon">
                                    @error('no')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Identitas LKS -->
                    <div class="form-section">
                        <h6><i class="bi bi-house-gear"></i> IDENTITAS LKS</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama LKS <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="nama_lks" rows="3" required placeholder="Masukkan nama lengkap LKS">{{ old('nama_lks') }}</textarea>
                                    @error('nama_lks')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pusat/Cabang <span class="text-danger">*</span></label>
                                    <select class="form-select" name="pusat_cabang" id="pusat_cabang" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Pusat" {{ old('pusat_cabang') == 'pusat' ? 'selected' : '' }}>Pusat</option>
                                        <option value="Cabang" {{ old('pusat_cabang') == 'cabang' ? 'selected' : '' }}>Cabang</option>
                                    </select>
                                    @error('pusat_cabang')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kabupaten/Kota LKS <span class="text-danger">*</span></label>
                                    <select class="form-select" name="kabupaten_kota_lks" required>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        <option value="Kabupaten Bogor" {{ old('kabupaten_kota_lks') == 'Kabupaten Bogor' ? 'selected' : '' }}>Kabupaten Bogor</option>
                                        <option value="Kabupaten Sukabumi" {{ old('kabupaten_kota_lks') == 'Kabupaten Sukabumi' ? 'selected' : '' }}>Kabupaten Sukabumi</option>
                                        <option value="Kabupaten Cianjur" {{ old('kabupaten_kota_lks') == 'Kabupaten Cianjur' ? 'selected' : '' }}>Kabupaten Cianjur</option>
                                        <option value="Kabupaten Bandung" {{ old('kabupaten_kota_lks') == 'Kabupaten Bandung' ? 'selected' : '' }}>Kabupaten Bandung</option>
                                        <option value="Kabupaten Garut" {{ old('kabupaten_kota_lks') == 'Kabupaten Garut' ? 'selected' : '' }}>Kabupaten Garut</option>
                                        <option value="Kabupaten Tasikmalaya" {{ old('kabupaten_kota_lks') == 'Kabupaten Tasikmalaya' ? 'selected' : '' }}>Kabupaten Tasikmalaya</option>
                                        <option value="Kabupaten Ciamis" {{ old('kabupaten_kota_lks') == 'Kabupaten Ciamis' ? 'selected' : '' }}>Kabupaten Ciamis</option>
                                        <option value="Kabupaten Kuningan" {{ old('kabupaten_kota_lks') == 'Kabupaten Kuningan' ? 'selected' : '' }}>Kabupaten Kuningan</option>
                                        <option value="Kabupaten Cirebon" {{ old('kabupaten_kota_lks') == 'Kabupaten Cirebon' ? 'selected' : '' }}>Kabupaten Cirebon</option>
                                        <option value="Kabupaten Majalengka" {{ old('kabupaten_kota_lks') == 'Kabupaten Majalengka' ? 'selected' : '' }}>Kabupaten Majalengka</option>
                                        <option value="Kabupaten Sumedang" {{ old('kabupaten_kota_lks') == 'Kabupaten Sumedang' ? 'selected' : '' }}>Kabupaten Sumedang</option>
                                        <option value="Kabupaten Indramayu" {{ old('kabupaten_kota_lks') == 'Kabupaten Indramayu' ? 'selected' : '' }}>Kabupaten Indramayu</option>
                                        <option value="Kabupaten Subang" {{ old('kabupaten_kota_lks') == 'Kabupaten Subang' ? 'selected' : '' }}>Kabupaten Subang</option>
                                        <option value="Kabupaten Purwakarta" {{ old('kabupaten_kota_lks') == 'Kabupaten Purwakarta' ? 'selected' : '' }}>Kabupaten Purwakarta</option>
                                        <option value="Kabupaten Karawang" {{ old('kabupaten_kota_lks') == 'Kabupaten Karawang' ? 'selected' : '' }}>Kabupaten Karawang</option>
                                        <option value="Kabupaten Bekasi" {{ old('kabupaten_kota_lks') == 'Kabupaten Bekasi' ? 'selected' : '' }}>Kabupaten Bekasi</option>
                                        <option value="Kabupaten Bandung Barat" {{ old('kabupaten_kota_lks') == 'Kabupaten Bandung Barat' ? 'selected' : '' }}>Kabupaten Bandung Barat</option>
                                        <option value="Kabupaten Pangandaran" {{ old('kabupaten_kota_lks') == 'Kabupaten Pangandaran' ? 'selected' : '' }}>Kabupaten Pangandaran</option>
                                        <option value="Kota Bogor" {{ old('kabupaten_kota_lks') == 'Kota Bogor' ? 'selected' : '' }}>Kota Bogor</option>
                                        <option value="Kota Sukabumi" {{ old('kabupaten_kota_lks') == 'Kota Sukabumi' ? 'selected' : '' }}>Kota Sukabumi</option>
                                        <option value="Kota Bandung" {{ old('kabupaten_kota_lks') == 'Kota Bandung' ? 'selected' : '' }}>Kota Bandung</option>
                                        <option value="Kota Cirebon" {{ old('kabupaten_kota_lks') == 'Kota Cirebon' ? 'selected' : '' }}>Kota Cirebon</option>
                                        <option value="Kota Bekasi" {{ old('kabupaten_kota_lks') == 'Kota Bekasi' ? 'selected' : '' }}>Kota Bekasi</option>
                                        <option value="Kota Depok" {{ old('kabupaten_kota_lks') == 'Kota Depok' ? 'selected' : '' }}>Kota Depok</option>
                                        <option value="Kota Cimahi" {{ old('kabupaten_kota_lks') == 'Kota Cimahi' ? 'selected' : '' }}>Kota Cimahi</option>
                                        <option value="Kota Tasikmalaya" {{ old('kabupaten_kota_lks') == 'Kota Tasikmalaya' ? 'selected' : '' }}>Kota Tasikmalaya</option>
                                        <option value="Kota Banjar" {{ old('kabupaten_kota_lks') == 'Kota Banjar' ? 'selected' : '' }}>Kota Banjar</option>
                                    </select>
                                    @error('kabupaten_kota_lks')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat LKS <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="alamat_lks" rows="3" required placeholder="Masukkan alamat lengkap LKS">{{ old('alamat_lks') }}</textarea>
                                    @error('alamat_lks')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kepengurusan LKS -->
                    <div class="form-section">
                        <h6><i class="bi bi-people"></i> KEPENGURUSAN LKS</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Nama Ketua LKS <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_ketua_lks" value="{{ old('nama_ketua_lks') }}" required placeholder="Masukkan nama ketua LKS">
                                    @error('nama_ketua_lks')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Nama Sekretaris <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_sekretaris" value="{{ old('nama_sekretaris') }}" required placeholder="Masukkan nama sekretaris">
                                    @error('nama_sekretaris')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Nama Bendahara <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_bendahara" value="{{ old('nama_bendahara') }}" required placeholder="Masukkan nama bendahara">
                                    @error('nama_bendahara')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Akta Pendirian Yayasan -->
                    <div class="form-section">
                        <h6><i class="bi bi-file-text"></i> AKTA PENDIRIAN YAYASAN</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Notaris <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="nama_notaris" rows="2" required placeholder="Masukkan nama notaris">{{ old('nama_notaris') }}</textarea>
                                    @error('nama_notaris')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Notaris <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor_notaris" value="{{ old('nomor_notaris') }}" required placeholder="Masukkan nomor notaris">
                                    @error('nomor_notaris')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Akta <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_akta" value="{{ old('tanggal_akta') }}" required>
                                    @error('tanggal_akta')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengesahan Pendirian Yayasan -->
                    <div class="form-section">
                        <h6><i class="bi bi-check-circle"></i> PENGESAHAN PENDIRIAN YAYASAN</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Pengesahan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor_pengesahan" value="{{ old('nomor_pengesahan') }}" required placeholder="Masukkan nomor pengesahan">
                                    @error('nomor_pengesahan')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengesahan <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_pengesahan" value="{{ old('tanggal_pengesahan') }}" required>
                                    @error('tanggal_pengesahan')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NPWP -->
                    <div class="form-section">
                        <h6><i class="bi bi-receipt"></i> NPWP</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama NPWP <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="nama_npwp" rows="2" required placeholder="Masukkan nama NPWP">{{ old('nama_npwp') }}</textarea>
                                    @error('nama_npwp')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor NPWP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor_npwp" value="{{ old('nomor_npwp') }}" required placeholder="Masukkan nomor NPWP">
                                    @error('nomor_npwp')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Bangunan & Akreditasi -->
                    <div class="form-section">
                        <h6><i class="bi bi-building"></i> STATUS BANGUNAN & AKREDITASI</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status Bangunan <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status_bangunan" required>
                                        <option value="">Pilih Status Bangunan</option>
                                        <option value="milik_sendiri" {{ old('status_bangunan') == 'milik_sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                        <option value="sewa/kontrak" {{ old('status_bangunan') == 'sewa/kontrak' ? 'selected' : '' }}>Sewa/Kontrak</option>
                                        <option value="wakaf" {{ old('status_bangunan') == 'wakaf' ? 'selected' : '' }}>Wakaf</option>
                                    </select>
                                    @error('status_bangunan')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Akreditasi <span class="text-danger">*</span></label>
                                    <select class="form-select" name="akreditasi" required>
                                        <option value="">Pilih Akreditasi</option>
                                        <option value="a" {{ old('akreditasi') == 'a' ? 'selected' : '' }}>A</option>
                                        <option value="b" {{ old('akreditasi') == 'b' ? 'selected' : '' }}>B</option>
                                        <option value="c" {{ old('akreditasi') == 'c' ? 'selected' : '' }}>C</option>
                                        <option value="tidak_terakreditasi" {{ old('akreditasi') == 'tidak_terakreditasi' ? 'selected' : '' }}>Tidak Terakreditasi</option>
                                    </select>
                                    @error('akreditasi')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanda Pendaftaran Pusat -->
                    <div class="form-section">
                        <h6><i class="bi bi-file-earmark-check"></i> TANDA PENDAFTARAN PUSAT</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Kab/Kota Pusat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tanda_pendaftaran_pusat_nama_kab_kota" value="{{ old('tanda_pendaftaran_pusat_nama_kab_kota') }}" required placeholder="Masukkan nama kabupaten/kota pusat">
                                    @error('tanda_pendaftaran_pusat_nama_kab_kota')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Tanda Daftar Pusat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tanda_pendaftaran_pusat_nomor" value="{{ old('tanda_pendaftaran_pusat_nomor') }}" required placeholder="Masukkan nomor tanda daftar pusat">
                                    @error('tanda_pendaftaran_pusat_nomor')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Tanda Daftar Pusat <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanda_pendaftaran_pusat_tanggal" value="{{ old('tanda_pendaftaran_pusat_tanggal') }}" required>
                                    @error('tanda_pendaftaran_pusat_tanggal')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanda Pendaftaran Cabang -->
                    <div class="form-section">
                        <h6><i class="bi bi-file-earmark-check"></i> TANDA PENDAFTARAN CABANG</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Kab/Kota Cabang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tanda_pendaftaran_cabang_nama_kab_kota" value="{{ old('tanda_pendaftaran_cabang_nama_kab_kota') }}" required placeholder="Masukkan nama kabupaten/kota cabang">
                                    @error('tanda_pendaftaran_cabang_nama_kab_kota')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Tanda Daftar Cabang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tanda_pendaftaran_cabang_nomor" value="{{ old('tanda_pendaftaran_cabang_nomor') }}" required placeholder="Masukkan nomor tanda daftar cabang">
                                    @error('tanda_pendaftaran_cabang_nomor')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Tanda Daftar Cabang <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanda_pendaftaran_cabang_tanggal" value="{{ old('tanda_pendaftaran_cabang_tanggal') }}" required>
                                    @error('tanda_pendaftaran_cabang_tanggal')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rekomendasi Dinsos -->
                    <div class="form-section">
                        <h6><i class="bi bi-file-earmark-text"></i> REKOMENDASI DINSOS KAB/KOTA</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Rekomendasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="rekom_dinsos_nomor" value="{{ old('rekom_dinsos_nomor') }}" required placeholder="Masukkan nomor rekomendasi">
                                    @error('rekom_dinsos_nomor')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Rekomendasi <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="rekom_dinsos_tanggal" value="{{ old('rekom_dinsos_tanggal') }}" required>
                                    @error('rekom_dinsos_tanggal')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanda Pendaftaran Provinsi -->
                    <div class="form-section">
                        <h6><i class="bi bi-file-earmark-check"></i> TANDA PENDAFTARAN PROVINSI</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Tanda Daftar Provinsi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tanda_pendaftaran_provinsi_nomor" value="{{ old('tanda_pendaftaran_provinsi_nomor') }}" required placeholder="Masukkan nomor tanda daftar provinsi">
                                    @error('tanda_pendaftaran_provinsi_nomor')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Tanda Daftar Provinsi <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanda_pendaftaran_provinsi_tanggal" value="{{ old('tanda_pendaftaran_provinsi_tanggal') }}" required>
                                    @error('tanda_pendaftaran_provinsi_tanggal')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Jenis Pelayanan PPKS-->
                    <div class="form-section">
                        <h6><i class="bi bi-heart-pulse"></i> JENIS PELAYANAN PPKS</h6>
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Jenis Pelayanan PPKS <span class="text-danger">*</span></label>
                                <input type="hidden" id="jenis_pelayanan_PPKS" name="jenis_pelayanan_PPKS" value="{{ old('jenis_pelayanan_PPKS') }}">

                                <div class="search-box mb-3">
                                    <i class="bi bi-search"></i>
                                    <input type="text" id="searchJenisPelayanan" class="form-control" placeholder="Ketik untuk mencari jenis pelayanan...">
                                </div>

                                <div class="checkbox-container" id="jenisPelayananList">
                                    @php
                                    $jenisPelayanan = [
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
                                    $selectedPelayanan = collect(explode(',', old('jenis_pelayanan_PPKS')))->map(fn($v) => trim($v));
                                    @endphp
                                    @foreach($jenisPelayanan as $idx => $pelayanan)
                                    <div class="checkbox-item">
                                        <div class="form-check">
                                            <input class="form-check-input jenis-pelayanan-checkbox" type="checkbox" value="{{ $pelayanan }}" id="jp_{{ $idx }}" {{ $selectedPelayanan->contains($pelayanan) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jp_{{ $idx }}">{{ $pelayanan }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="d-flex justify-content-between mb-3 action-buttons">
                                    <button type="button" class="btn btn-select-all" id="selectAllJenisPelayanan">
                                        <i class="bi bi-check-all"></i> Pilih Semua
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-action" id="clearAllJenisPelayanan">
                                        <i class="bi bi-x-circle"></i> Hapus Semua
                                    </button>
                                </div>
                            
                                <div class="selected-items" id="selectedJenisPelayanan">
                                    @if($selectedPelayanan->count() > 0)
                                        @foreach($selectedPelayanan as $selected)
                                            @if($selected)
                                            <div class="selected-item">
                                                {{ $selected }}
                                                <button type="button" class="remove-btn" data-value="{{ $selected }}">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="text-muted">Belum ada pilihan. Silakan pilih dari daftar di atas.</div>
                                    @endif
                                </div>

                                @error('jenis_pelayanan_PPKS')
                                    <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Warga Binaan -->
                    <div class="form-section">
                        <h6><i class="bi bi-people-fill"></i> JUMLAH WARGA BINAAN</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Seluruh Binaan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="jumlah_seluruh_binaan" value="{{ old('jumlah_seluruh_binaan', 0) }}" min="0" required>
                                    @error('jumlah_seluruh_binaan')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Dalam Panti <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="jumlah_dalam_panti" value="{{ old('jumlah_dalam_panti', 0) }}" min="0" required>
                                    @error('jumlah_dalam_panti')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Luar Panti <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="jumlah_luar_panti" value="{{ old('jumlah_luar_panti', 0) }}" min="0" required>
                                    @error('jumlah_luar_panti')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data PPKS -->
                    <div class="form-section">
                        <h6><i class="bi bi-person-lines-fill"></i> DATA PPKS</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40%">Jenis PPKS</th>
                                        <th width="30%">Dalam Panti</th>
                                        <th width="30%">Luar Panti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $ppksFields = [
                                            'anak_balita_terlantar' => 'Anak Balita Terlantar',
                                            'anak_terlantar' => 'Anak Terlantar',
                                            'anak_yangberhadapan_dengan_hukum' => 'Anak yang Berhadapan dengan Hukum',
                                            'anak_jalanan' => 'Anak Jalanan',
                                            'anak_dengan_kedisabilitas' => 'Anak dengan Kedisabilitas',
                                            'anak_yangmenjadi_tidak_kekerasan' => 'Anak yang Menjadi Tidak Kekerasan',
                                            'anak_yang_memerlukan_perlindungan_khusus' => 'Anak yang Memerlukan Perlindungan Khusus',
                                            'lanjut_usia_terlantar' => 'Lanjut Usia Terlantar',
                                            'disabilitas_fisik' => 'Disabilitas Fisik',
                                            'disabilitas_intelektual' => 'Disabilitas Intelektual',
                                            'disabilitas_mental' => 'Disabilitas Mental',
                                            'disabilitas_sensorik' => 'Disabilitas Sensorik',
                                            'tuna_susila' => 'Tuna Susila',
                                            'gelandangan' => 'Gelandangan',
                                            'pengemis' => 'Pengemis',
                                            'pemulung' => 'Pemulung',
                                            'kelompok_minoritas' => 'Kelompok Minoritas',
                                            'BWBLP' => 'BWBLP',
                                            'orang_dengan_hiv_aids' => 'Orang dengan HIV/AIDS',
                                            'penyalahgunaan_Napza' => 'Penyalahgunaan Napza',
                                            'korban_Trafficking' => 'Korban Trafficking',
                                            'korban_tindak_kekerasan' => 'Korban Tindak Kekerasan',
                                            'PMBS' => 'PMBS',
                                            'korban_bencana_alam' => 'Korban Bencana Alam',
                                            'korban_bencana_sosial' => 'Korban Bencana Sosial',
                                            'perempuan_rawan_sosial_ekonomi' => 'Perempuan Rawan Sosial Ekonomi',
                                            'fakir_miskin' => 'Fakir Miskin',
                                            'keluarga_bermasalah_sosial_psikologis' => 'Keluarga Bermasalah Sosial Psikologis',
                                            'komunitas_adat_terpencil' => 'Komunitas Adat Terpencil'
                                        ];
                                    @endphp
                                    @foreach($ppksFields as $field => $label)
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td>
                                            <input type="number" class="form-control" name="{{ $field }}_DP" value="{{ old($field.'_DP', 0) }}" min="0" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="{{ $field }}_LP" value="{{ old($field.'_LP', 0) }}" min="0" required>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="form-section">
                        <h6><i class="bi bi-telephone"></i> KONTAK</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nomor_tlp" value="{{ old('nomor_tlp') }}" required placeholder="Masukkan nomor telepon">
                                    @error('nomor_tlp')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Masukkan alamat email">
                                    @error('email')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Link Tanda Daftar</label>
                                    <input type="url" class="form-control" name="link_tanda_daftar" value="{{ old('link_tanda_daftar') }}" placeholder="Masukkan link tanda daftar (opsional)">
                                    @error('link_tanda_daftar')
                                        <div class="text-danger mt-1"><small><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-section text-center bg-light">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="{{ route('kewenangan-provinsi.index') }}" class="btn btn-secondary btn-lg me-md-2">
                                        <i class="bi bi-arrow-left-circle me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle me-2"></i>Simpan Data
                                    </button>
                                </div>
                                <p class="text-muted mt-3 mb-0">
                                    <small><i class="bi bi-info-circle me-1"></i>Pastikan semua data yang wajib diisi telah terisi dengan benar</small>
                                </p>
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
// Progress bar calculation
function updateProgressBar() {
    const form = document.getElementById('mainForm');
    const totalFields = form.querySelectorAll('input[required], select[required], textarea[required]').length;
    const filledFields = form.querySelectorAll('input[required]:valid, select[required]:valid, textarea[required]:valid').length;
    
    if (totalFields > 0) {
        const progress = (filledFields / totalFields) * 100;
        document.getElementById('formProgress').style.width = progress + '%';
    }
}

// Add event listeners to all required fields
document.addEventListener('DOMContentLoaded', function() {
    const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('input', updateProgressBar);
        field.addEventListener('change', updateProgressBar);
    });
    
    // Initial progress calculation
    updateProgressBar();
});

// Form submission animation
document.getElementById('mainForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Re-enable button after 5 seconds (safety measure)
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }, 5000);
});

// Add smooth scrolling to form sections
document.querySelectorAll('.form-section h6').forEach(header => {
    header.style.cursor = 'pointer';
    header.addEventListener('click', function() {
        this.closest('.form-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});

// ========== JENIS PELAYANAN PPKS FUNCTIONALITY ==========
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.jenis-pelayanan-checkbox');
    const hiddenInput = document.getElementById('jenis_pelayanan_PPKS');
    const selectAllBtn = document.getElementById('selectAllJenisPelayanan');
    const clearAllBtn = document.getElementById('clearAllJenisPelayanan');
    const searchInput = document.getElementById('searchJenisPelayanan');

    // Function utama untuk update data
    function updateSelectedData() {
        const selectedValues = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedValues.push(checkbox.value);
            }
        });
        
        // PASTIKAN: Update hidden input dengan data yang dipilih
        hiddenInput.value = selectedValues.join(',');
    }

    // Event untuk setiap checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedData);
    });

    // Select All
    selectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => checkbox.checked = true);
        updateSelectedData();
    });

    // Clear All  
    clearAllBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => checkbox.checked = false);
        updateSelectedData();
    });

    // Search
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        checkboxes.forEach(checkbox => {
            const label = checkbox.closest('.checkbox-item');
            if (checkbox.value.toLowerCase().includes(searchTerm)) {
                label.style.display = 'block';
            } else {
                label.style.display = 'none';
            }
        });
    });

    // PASTIKAN: Update data sebelum form submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        updateSelectedData(); // Update terakhir sebelum kirim data
        
        // Validasi client-side
        if (hiddenInput.value === '') {
            alert('Pilih minimal satu jenis pelayanan PPKS');
            return false;
        }
    });

    // Inisialisasi pertama
    updateSelectedData();
});
</script>
@endpush