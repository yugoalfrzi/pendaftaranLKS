@extends('layouts.app')

@section('title', 'Detail Data Kewenangan Kabupaten/Kota')

@section('styles')
<style>
    /* Main Layout */
    .detail-container {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .main-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1.5rem 2rem;
        border-bottom: none;
    }

    /* Navigation Tabs */
    .detail-tabs {
        background: white;
        border-radius: 0.5rem;
        padding: 0;
        margin-bottom: 2rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .nav-tabs-custom {
        border-bottom: 3px solid #e9ecef;
        padding: 0 1rem;
    }

    .nav-tabs-custom .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-tabs-custom .nav-link:hover {
        color: #495057;
        border-bottom: 3px solid #dee2e6;
    }

    .nav-tabs-custom .nav-link.active {
        color: #667eea;
        border-bottom: 3px solid #667eea;
        background: transparent;
    }

    /* Content Sections */
    .tab-content {
        padding: 2rem;
    }

    .section-card {
        background: white;
        border: 1px solid #e3f2fd;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .section-card:hover {
        border-color: #2196f3;
        box-shadow: 0 0.25rem 0.5rem rgba(33, 150, 243, 0.1);
    }

    .section-title {
        color: #2c3e50;
        font-weight: 800;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #3498db;
        font-size: 1.2rem;
    }

    .section-title i {
        color: #667eea;
        margin-right: 0.5rem;
    }

    /* Info Grid Layout */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.25rem;
        border-left: 4px solid #3498db;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    }

    .info-label {
        font-weight: 800;
        color: #2c3e50;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }

    .info-label:before {
        content: "•";
        color: #3498db;
        font-weight: bold;
        margin-right: 0.5rem;
    }

    .info-value {
        color: #1a1a1a;
        font-size: 1.05rem;
        font-weight: 600;
        line-height: 1.4;
        padding: 0.5rem 0;
        border-bottom: 1px dashed #e0e0e0;
    }

    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(102, 126, 234, 0.3);
    }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        font-weight: 600;
        opacity: 0.9;
    }

    /* PPKS Grid */
    .ppks-section {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .ppks-header {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .ppks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }

    .ppks-item {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .ppks-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    }

    .ppks-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        text-align: center;
    }

        .ppks-total {
        font-size: 1.35rem;
        font-weight: 800;
        color: #e74c3c;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .ppks-detail {
        display: flex;
        justify-content: space-around;
        font-size: 0.75rem;
        color: #666;
    }

    /* Badges & Labels */
    .badge-custom {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.5rem 0.85rem;
        border-radius: 0.5rem;
    }

    /* Action Buttons */
    .btn-action {
        border-radius: 0.5rem;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        margin-left: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
    }

    /* Contact & System Info */
    .contact-card {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
    }

    .system-card {
        background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);
        color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .detail-container {
            padding: 1rem 0;
        }

        .card-header-custom {
            padding: 1rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .ppks-grid {
            grid-template-columns: 1fr;
        }

        .nav-tabs-custom .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .tab-content {
            padding: 1rem;
        }

        .btn-action {
            margin: 0.25rem;
            width: calc(100% - 0.5rem);
        }
    }

    @media (max-width: 576px) {
        .stats-container {
            grid-template-columns: 1fr;
        }

        .section-card {
            padding: 1rem;
        }
    }
</style>

@section('content')
<div class="detail-container">
    <div class="container">
        <!-- Header Section -->
        <div class="main-card">
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><i class="bi bi-eye-fill me-2"></i>Detail Data Kewenangan Kabupaten/Kota</h4>
                        <p class="mb-0 opacity-75">Detail lengkap data Lembaga Kesejahteraan Sosial</p>
                    </div>
                    <div class="d-flex flex-wrap">
                        <a href="{{ route('kewenangan-kabkota.edit', $kewenangan->id) }}" class="btn btn-warning btn-action">
                            <i class="bi bi-pencil-square me-2"></i>Edit Data
                        </a>
                        <a href="{{ route('kewenangan-kabkota.index') }}" class="btn btn-secondary btn-action">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="detail-tabs">
            <ul class="nav nav-tabs nav-tabs-custom" id="detailTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="identitas-tab" data-bs-toggle="tab" data-bs-target="#identitas" type="button" role="tab">
                        <i class="bi bi-building me-2"></i>Profil Yayasan & LKS
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab">
                        <i class="bi bi-folder me-2"></i>Dokumen Yasasan & LKS
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pelayanan-tab" data-bs-toggle="tab" data-bs-target="#pelayanan" type="button" role="tab">
                        <i class="bi bi-heart-pulse me-2"></i>Pelayanan PPKS
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="kontak-tab" data-bs-toggle="tab" data-bs-target="#kontak" type="button" role="tab">
                        <i class="bi bi-telephone me-2"></i>Kontak & Sistem
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="detailTabsContent">
                <!-- TAB 1: IDENTITAS -->
                <div class="tab-pane fade show active" id="identitas" role="tabpanel">
                    <!-- Identitas Yayasan -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-building"></i>Identitas Yayasan</h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nama Lembaga/Yayasan</div>
                                <div class="info-value">{{ $kewenangan->Nama_Lembaga_Yayasan }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    <span class="badge badge-custom {{ $kewenangan->status == 'pusat' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($kewenangan->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Kabupaten/Kota</div>
                                <div class="info-value">{{ $kewenangan->kabupaten_kota }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Ketua Yayasan</div>
                                <div class="info-value">{{ $kewenangan->ketua_yayasan }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Alamat</div>
                                <div class="info-value">{{ $kewenangan->alamat }}</div>
                            </div>
                            @if($kewenangan->no)
                            <div class="info-item">
                                <div class="info-label">No. Telepon</div>
                                <div class="info-value">{{ $kewenangan->no }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Identitas LKS -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-house-gear"></i>Identitas LKS</h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nama LKS</div>
                                <div class="info-value">{{ $kewenangan->nama_lks }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Pusat/Cabang</div>
                                <div class="info-value">{{ $kewenangan->pusat_cabang }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Kabupaten/Kota LKS</div>
                                <div class="info-value">{{ $kewenangan->kabupaten_kota_lks }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Alamat LKS</div>
                                <div class="info-value">{{ $kewenangan->alamat_lks }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kepengurusan LKS -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-people-fill"></i>Kepengurusan LKS</h5>
                        <div class="stats-container">
                            <div class="stat-card">
                                <div class="stat-value"><i class="bi bi-person-badge"></i></div>
                                <div class="stat-label">Ketua LKS</div>
                                <div class="info-value">{{ $kewenangan->nama_ketua_lks }}</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value"><i class="bi bi-person-lines-fill"></i></div>
                                <div class="stat-label">Sekretaris</div>
                                <div class="info-value">{{ $kewenangan->nama_sekretaris }}</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value"><i class="bi bi-wallet2"></i></div>
                                <div class="stat-label">Bendahara</div>
                                <div class="info-value">{{ $kewenangan->nama_bendahara }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: DOKUMEN LEGAL -->
                <div class="tab-pane fade" id="dokumen" role="tabpanel">
                    <!-- Akta Pendirian -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-file-text"></i>Akta Pendirian Yayasan</h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nama Notaris</div>
                                <div class="info-value">{{ $kewenangan->nama_notaris }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Nomor Notaris</div>
                                <div class="info-value">{{ $kewenangan->nomor_notaris }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tanggal Akta</div>
                                <div class="info-value">{{ $kewenangan->tanggal_akta?->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengesahan -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-check-circle"></i>Pengesahan Pendirian</h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nomor Pengesahan</div>
                                <div class="info-value">{{ $kewenangan->nomor_pengesahan }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tanggal Pengesahan</div>
                                <div class="info-value">{{ $kewenangan->tanggal_pengesahan?->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- NPWP -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-receipt"></i>NPWP</h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nama NPWP</div>
                                <div class="info-value">{{ $kewenangan->nama_npwp }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Nomor NPWP</div>
                                <div class="info-value">{{ $kewenangan->nomor_npwp }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Status & Akreditasi -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-award"></i>Status & Akreditasi</h5>
                        <div class="stats-container">
                            <div class="stat-card">
                                <div class="stat-value">
                                    <span class="badge badge-custom bg-info">
                                        {{ ucfirst(str_replace('_', ' ', $kewenangan->status_bangunan)) }}
                                    </span>
                                </div>
                                <div class="stat-label">Status Bangunan</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">
                                    <span class="badge badge-custom {{ $kewenangan->akreditasi == 'a' ? 'bg-success' : ($kewenangan->akreditasi == 'b' ? 'bg-warning' : ($kewenangan->akreditasi == 'c' ? 'bg-danger' : 'bg-secondary')) }}">
                                        {{ strtoupper($kewenangan->akreditasi) }}
                                    </span>
                                </div>
                                <div class="stat-label">Akreditasi</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanda Daftar -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-file-earmark-check"></i>Tanda Daftar</h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nomor Tanda Daftar</div>
                                <div class="info-value">{{ $kewenangan->nomor_tandaDaftar }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tanggal Tanda Daftar</div>
                                <div class="info-value">{{ $kewenangan->tanggal_tandaDaftar?->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: PELAYANAN PPKS -->
                <div class="tab-pane fade" id="pelayanan" role="tabpanel">
                    <!-- Jenis Pelayanan -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-heart-pulse"></i>Jenis Pelayanan PPKS</h5>
                        <div class="info-item">
                            <div class="info-value">
                                @php
                                    $jenisPelayanan = explode(',', $kewenangan->jenis_pelayanan_PPKS);
                                @endphp
                                @foreach($jenisPelayanan as $jenis)
                                    <span class="badge bg-primary me-2 mb-2 p-2">{{ trim($jenis) }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Warga Binaan -->
                    <div class="section-card">
                        <h5 class="section-title"><i class="bi bi-bar-chart"></i>Statistik Warga Binaan</h5>
                        <div class="stats-container">
                            <div class="stat-card">
                                <div class="stat-value">{{ number_format($kewenangan->jumlah_seluruh_binaan) }}</div>
                                <div class="stat-label">Total Binaan</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">{{ number_format($kewenangan->jumlah_dalam_panti) }}</div>
                                <div class="stat-label">Dalam Panti</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">{{ number_format($kewenangan->jumlah_luar_panti) }}</div>
                                <div class="stat-label">Luar Panti</div>
                            </div>
                        </div>
                    </div>

                    <!-- Data PPKS Detail -->
                    <div class="ppks-section">
                        <div class="ppks-header">
                            <h5 class="mb-0"><i class="bi bi-person-heart me-2"></i>Detail Data PPKS (Dalam Panti / Luar Panti)</h5>
                        </div>
                        <div class="ppks-grid">
                            @php
                                $ppksData = [
                                    'Anak Balita Terlantar' => ['dp' => $kewenangan->anak_balita_terlantar_DP, 'lp' => $kewenangan->anak_balita_terlantar_LP],
                                    'Anak Terlantar' => ['dp' => $kewenangan->anak_terlantar_DP, 'lp' => $kewenangan->anak_terlantar_LP],
                                    'Anak Berhadapan dengan Hukum' => ['dp' => $kewenangan->anak_yangberhadapan_dengan_hukum_DP, 'lp' => $kewenangan->anak_yangberhadapan_dengan_hukum_LP],
                                    'Anak Jalanan' => ['dp' => $kewenangan->anak_jalanan_DP, 'lp' => $kewenangan->anak_jalanan_LP],
                                    'Anak dengan Kedisabilitas' => ['dp' => $kewenangan->anak_dengan_kedisabilitas_DP, 'lp' => $kewenangan->anak_dengan_kedisabilitas_LP],
                                    'Anak Korban Kekerasan' => ['dp' => $kewenangan->anak_yangmenjadi_tidak_kekerasan_DP, 'lp' => $kewenangan->anak_yangmenjadi_tidak_kekerasan_LP],
                                    'Anak Perlindungan Khusus' => ['dp' => $kewenangan->anak_yang_memerlukan_perlindungan_khusus_DP, 'lp' => $kewenangan->anak_yang_memerlukan_perlindungan_khusus_LP],
                                    'Lansia Terlantar' => ['dp' => $kewenangan->lanjut_usia_terlantar_DP, 'lp' => $kewenangan->lanjut_usia_terlantar_LP],
                                    'Disabilitas Fisik' => ['dp' => $kewenangan->disabilitas_fisik_DP, 'lp' => $kewenangan->disabilitas_fisik_LP],
                                    'Disabilitas Intelektual' => ['dp' => $kewenangan->disabilitas_intelektual_DP, 'lp' => $kewenangan->disabilitas_intelektual_LP],
                                    'Disabilitas Mental' => ['dp' => $kewenangan->disabilitas_mental_DP, 'lp' => $kewenangan->disabilitas_mental_LP],
                                    'Disabilitas Sensorik' => ['dp' => $kewenangan->disabilitas_sensorik_DP, 'lp' => $kewenangan->disabilitas_sensorik_LP],
                                    'Tuna Susila' => ['dp' => $kewenangan->tuna_susila_DP, 'lp' => $kewenangan->tuna_susila_LP],
                                    'Gelandangan' => ['dp' => $kewenangan->gelandangan_DP, 'lp' => $kewenangan->gelandangan_LP],
                                    'Pengemis' => ['dp' => $kewenangan->pengemis_DP, 'lp' => $kewenangan->pengemis_LP],
                                    'Pemulung' => ['dp' => $kewenangan->pemulung_DP, 'lp' => $kewenangan->pemulung_LP],
                                    'Kelompok Minoritas' => ['dp' => $kewenangan->kelompok_minoritas_DP, 'lp' => $kewenangan->kelompok_minoritas_LP],
                                    'BWBLP' => ['dp' => $kewenangan->BWBLP_DP, 'lp' => $kewenangan->BWBLP_LP],
                                    'ODHA' => ['dp' => $kewenangan->orang_dengan_hiv_aids_DP, 'lp' => $kewenangan->orang_dengan_hiv_aids_LP],
                                    'Korban Napza' => ['dp' => $kewenangan->penyalahgunaan_Napza_DP, 'lp' => $kewenangan->penyalahgunaan_Napza_LP],
                                    'Korban Trafficking' => ['dp' => $kewenangan->korban_Trafficking_DP, 'lp' => $kewenangan->korban_Trafficking_LP],
                                    'Korban Kekerasan' => ['dp' => $kewenangan->korban_tindak_kekerasan_DP, 'lp' => $kewenangan->korban_tindak_kekerasan_LP],
                                    'PMBS' => ['dp' => $kewenangan->PMBS_DP, 'lp' => $kewenangan->PMBS_LP],
                                    'Korban Bencana Alam' => ['dp' => $kewenangan->korban_bencana_alam_DP, 'lp' => $kewenangan->korban_bencana_alam_LP],
                                    'Korban Bencana Sosial' => ['dp' => $kewenangan->korban_bencana_sosial_DP, 'lp' => $kewenangan->korban_bencana_sosial_LP],
                                    'Perempuan Rawan Sosial Ekonomi' => ['dp' => $kewenangan->perempuan_rawan_sosial_ekonomi_DP, 'lp' => $kewenangan->perempuan_rawan_sosial_ekonomi_LP],
                                    'Fakir Miskin' => ['dp' => $kewenangan->fakir_miskin_DP, 'lp' => $kewenangan->fakir_miskin_LP],
                                    'Keluarga Bermasalah' => ['dp' => $kewenangan->keluarga_bermasalah_sosial_psikologis_DP, 'lp' => $kewenangan->keluarga_bermasalah_sosial_psikologis_LP],
                                    'Komunitas Adat Terpencil' => ['dp' => $kewenangan->komunitas_adat_terpencil_DP, 'lp' => $kewenangan->komunitas_adat_terpencil_LP],
                                ];
                            @endphp

                            @foreach($ppksData as $title => $data)
                                <div class="ppks-item">
                                    <div class="ppks-title">{{ $title }}</div>
                                    <div class="ppks-total">{{ $data['dp'] + $data['lp'] }}</div>
                                    <div class="ppks-detail">
                                        <span>DP: {{ $data['dp'] }}</span>
                                        <span>LP: {{ $data['lp'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TAB 4: KONTAK & SISTEM -->
                <div class="tab-pane fade" id="kontak" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-card h-100">
                                <h5 class="section-title text-white"><i class="bi bi-telephone"></i>Kontak</h5>
                                <div class="mb-3">
                                    <i class="bi bi-telephone-fill me-2"></i>
                                    <strong>Telepon:</strong> {{ $kewenangan->nomor_tlp }}
                                </div>
                                <div class="mb-3">
                                    <i class="bi bi-envelope-fill me-2"></i>
                                    <strong>Email:</strong> {{ $kewenangan->email }}
                                </div>
                                @if($kewenangan->link_tanda_daftar)
                                <div>
                                    <i class="bi bi-link-45deg me-2"></i>
                                    <strong>Link Dokumen:</strong> 
                                    <a href="{{ $kewenangan->link_tanda_daftar }}" target="_blank" class="text-white text-decoration-underline">
                                        Buka Dokumen
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="system-card h-100">
                                <h5 class="section-title text-white"><i class="bi bi-clock-history"></i>Informasi Sistem</h5>
                                <div class="mb-3">
                                    <i class="bi bi-plus-circle-fill me-2"></i>
                                    <strong>Dibuat:</strong> {{ $kewenangan->created_at?->format('d F Y H:i:s') }}
                                </div>
                                <div>
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    <strong>Diperbarui:</strong> {{ $kewenangan->updated_at?->format('d F Y H:i:s') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add active class to current tab for better UX
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('#detailTabs .nav-link');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Smooth scrolling for tab content
        const tabPanes = document.querySelectorAll('.tab-pane');
        tabPanes.forEach(pane => {
            pane.style.transition = 'opacity 0.3s ease';
        });
    });
</script>
@endpush