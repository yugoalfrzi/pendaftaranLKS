<?php

namespace App\Http\Controllers;

use App\Models\KewenanganKabkota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class KewenanganKabkotaController extends Controller
{
    public function index(Request $request)
    {
        // User tidak bisa lihat daftar, redirect ke form input
        if (auth()->check() && auth()->user()->hasRole('user')) {
            return redirect()->route('kewenangan-kabkota.create');
        }

        $isAdmin = auth()->user()->hasRole('admin');
        $adminKabkota = auth()->user()->kabupaten_kota;

        $query = KewenanganKabkota::query();

        // Admin hanya melihat data sesuai kabupaten/kotanya
        if ($isAdmin && $adminKabkota) {
            $query->where('kabupaten_kota', $adminKabkota);
        }
        
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('Nama_Lembaga_Yayasan', 'like', "%{$search}%")
                  ->orWhere('nama_lks', 'like', "%{$search}%")
                  ->orWhere('kabupaten_kota', 'like', "%{$search}%");
            });
        }
        
        $kewenangan = $query->paginate(20);

        // Admin: statistik otomatis difilter per kabkota-nya, tidak bisa ganti
        $filterKabkota = $isAdmin ? $adminKabkota : $request->get('filter_kabkota');
        $statistics = $this->getStatistics($filterKabkota);
        
        return view('kewenangan.kabkota.index', compact('kewenangan', 'statistics', 'filterKabkota', 'isAdmin'));
    }

    public function create()
    {
        return view('kewenangan.kabkota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nama_Lembaga_Yayasan' => 'required|string',
            'status' => 'required|in:pusat,cabang',
            'kabupaten_kota' => 'required|string|max:255',
            'alamat' => 'required|string',
            'ketua_yayasan' => 'required|string|max:255',
            'no' => 'nullable|string|max:255',
            'nama_lks' => 'required|string',
            'pusat_cabang' => 'required|string|max:255',
            'kabupaten_kota_lks' => 'required|string|max:255',
            'alamat_lks' => 'required|string',
            'nama_ketua_lks' => 'required|string|max:255',
            'nama_sekretaris' => 'required|string|max:255',
            'nama_bendahara' => 'required|string|max:255',
            'nama_notaris' => 'required|string',
            'nomor_notaris' => 'required|string|max:255',
            'tanggal_akta' => 'required|date',
            'nomor_pengesahan' => 'required|string|max:255',
            'tanggal_pengesahan' => 'required|date',
            'nama_npwp' => 'required|string',
            'nomor_npwp' => 'required|string|max:255',
            'status_bangunan' => 'required|in:milik_sendiri,sewa/kontrak,wakaf',
            'akreditasi' => 'required|in:a,b,c,tidak_terakreditasi',
            'nomor_tandaDaftar' => 'required|string|max:255',
            'tanggal_tandaDaftar' => 'required|date',
            'jenis_pelayanan_PPKS' => 'required|string',
            'jumlah_seluruh_binaan' => 'required|integer|min:0',
            'jumlah_dalam_panti' => 'required|integer|min:0',
            'jumlah_luar_panti' => 'required|integer|min:0',
            'anak_balita_terlantar_DP' => 'required|integer|min:0',
            'anak_balita_terlantar_LP' => 'required|integer|min:0',
            'anak_terlantar_DP' => 'required|integer|min:0',
            'anak_terlantar_LP' => 'required|integer|min:0',
            'anak_yangberhadapan_dengan_hukum_DP' => 'required|integer|min:0',
            'anak_yangberhadapan_dengan_hukum_LP' => 'required|integer|min:0',
            'anak_jalanan_DP' => 'required|integer|min:0',
            'anak_jalanan_LP' => 'required|integer|min:0',
            'anak_dengan_kedisabilitas_DP' => 'required|integer|min:0',
            'anak_dengan_kedisabilitas_LP' => 'required|integer|min:0',
            'anak_yangmenjadi_tidak_kekerasan_DP' => 'required|integer|min:0',
            'anak_yangmenjadi_tidak_kekerasan_LP' => 'required|integer|min:0',
            'anak_yang_memerlukan_perlindungan_khusus_DP' => 'required|integer|min:0',
            'anak_yang_memerlukan_perlindungan_khusus_LP' => 'required|integer|min:0',
            'lanjut_usia_terlantar_DP' => 'required|integer|min:0',
            'lanjut_usia_terlantar_LP' => 'required|integer|min:0',
            'disabilitas_fisik_DP' => 'required|integer|min:0',
            'disabilitas_fisik_LP' => 'required|integer|min:0',
            'disabilitas_intelektual_DP' => 'required|integer|min:0',
            'disabilitas_intelektual_LP' => 'required|integer|min:0',
            'disabilitas_mental_DP' => 'required|integer|min:0',
            'disabilitas_mental_LP' => 'required|integer|min:0',
            'disabilitas_sensorik_DP' => 'required|integer|min:0',
            'disabilitas_sensorik_LP' => 'required|integer|min:0',
            'tuna_susila_DP' => 'required|integer|min:0',
            'tuna_susila_LP' => 'required|integer|min:0',
            'gelandangan_DP' => 'required|integer|min:0',
            'gelandangan_LP' => 'required|integer|min:0',
            'pengemis_DP' => 'required|integer|min:0',
            'pengemis_LP' => 'required|integer|min:0',
            'pemulung_DP' => 'required|integer|min:0',
            'pemulung_LP' => 'required|integer|min:0',
            'kelompok_minoritas_DP' => 'required|integer|min:0',
            'kelompok_minoritas_LP' => 'required|integer|min:0',
            'BWBLP_DP' => 'required|integer|min:0',
            'BWBLP_LP' => 'required|integer|min:0',
            'orang_dengan_hiv_aids_DP' => 'required|integer|min:0',
            'orang_dengan_hiv_aids_LP' => 'required|integer|min:0',
            'penyalahgunaan_Napza_DP' => 'required|integer|min:0',
            'penyalahgunaan_Napza_LP' => 'required|integer|min:0',
            'korban_Trafficking_DP' => 'required|integer|min:0',
            'korban_Trafficking_LP' => 'required|integer|min:0',
            'korban_tindak_kekerasan_DP' => 'required|integer|min:0',
            'korban_tindak_kekerasan_LP' => 'required|integer|min:0',
            'PMBS_DP' => 'required|integer|min:0',
            'PMBS_LP' => 'required|integer|min:0',
            'korban_bencana_alam_DP' => 'required|integer|min:0',
            'korban_bencana_alam_LP' => 'required|integer|min:0',
            'korban_bencana_sosial_DP' => 'required|integer|min:0',
            'korban_bencana_sosial_LP' => 'required|integer|min:0',
            'perempuan_rawan_sosial_ekonomi_DP' => 'required|integer|min:0',
            'perempuan_rawan_sosial_ekonomi_LP' => 'required|integer|min:0',
            'fakir_miskin_DP' => 'required|integer|min:0',
            'fakir_miskin_LP' => 'required|integer|min:0',
            'keluarga_bermasalah_sosial_psikologis_DP' => 'required|integer|min:0',
            'keluarga_bermasalah_sosial_psikologis_LP' => 'required|integer|min:0',
            'komunitas_adat_terpencil_DP' => 'required|integer|min:0',
            'komunitas_adat_terpencil_LP' => 'required|integer|min:0',
            'nomor_tlp' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'link_tanda_daftar' => 'nullable|string|max:255',
        ]);

        KewenanganKabkota::create($validated);

        // User tidak bisa akses index, arahkan ke create
        if (auth()->user()->hasRole('user')) {
            return redirect()->route('kewenangan-kabkota.create')
                             ->with('success', 'Data Kewenangan Kabupaten/Kota berhasil ditambahkan.');
        }

        return redirect()->route('kewenangan-kabkota.index')
                         ->with('success', 'Data Kewenangan Kabupaten/Kota berhasil ditambahkan.');
    }

    public function show(KewenanganKabkota $kewenangan)
    {
        return view('kewenangan.kabkota.show', compact('kewenangan'));
    }

    public function edit(KewenanganKabkota $kewenangan)
    {
        return view('kewenangan.kabkota.edit', compact('kewenangan'));
    }

    public function update(Request $request, KewenanganKabkota $kewenangan)
    {
        $validated = $request->validate([
            'Nama_Lembaga_Yayasan' => 'required|string',
            'status' => 'required|in:pusat,cabang',
            'kabupaten_kota' => 'required|string|max:255',
            'alamat' => 'required|string',
            'ketua_yayasan' => 'required|string|max:255',
            'no' => 'nullable|string|max:255',
            'nama_lks' => 'required|string',
            'pusat_cabang' => 'required|string|max:255',
            'kabupaten_kota_lks' => 'required|string|max:255',
            'alamat_lks' => 'required|string',
            'nama_ketua_lks' => 'required|string|max:255',
            'nama_sekretaris' => 'required|string|max:255',
            'nama_bendahara' => 'required|string|max:255',
            'nama_notaris' => 'required|string',
            'nomor_notaris' => 'required|string|max:255',
            'tanggal_akta' => 'required|date',
            'nomor_pengesahan' => 'required|string|max:255',
            'tanggal_pengesahan' => 'required|date',
            'nama_npwp' => 'required|string',
            'nomor_npwp' => 'required|string|max:255',
            'status_bangunan' => 'required|in:milik_sendiri,sewa/kontrak,wakaf',
            'akreditasi' => 'required|in:a,b,c,tidak_terakreditasi',
            'nomor_tandaDaftar' => 'required|string|max:255',
            'tanggal_tandaDaftar' => 'required|date',
            'jenis_pelayanan_PPKS' => 'required|string',
            'jumlah_seluruh_binaan' => 'required|integer|min:0',
            'jumlah_dalam_panti' => 'required|integer|min:0',
            'jumlah_luar_panti' => 'required|integer|min:0',
            'anak_balita_terlantar_DP' => 'required|integer|min:0',
            'anak_balita_terlantar_LP' => 'required|integer|min:0',
            'anak_terlantar_DP' => 'required|integer|min:0',
            'anak_terlantar_LP' => 'required|integer|min:0',
            'anak_yangberhadapan_dengan_hukum_DP' => 'required|integer|min:0',
            'anak_yangberhadapan_dengan_hukum_LP' => 'required|integer|min:0',
            'anak_jalanan_DP' => 'required|integer|min:0',
            'anak_jalanan_LP' => 'required|integer|min:0',
            'anak_dengan_kedisabilitas_DP' => 'required|integer|min:0',
            'anak_dengan_kedisabilitas_LP' => 'required|integer|min:0',
            'anak_yangmenjadi_tidak_kekerasan_DP' => 'required|integer|min:0',
            'anak_yangmenjadi_tidak_kekerasan_LP' => 'required|integer|min:0',
            'anak_yang_memerlukan_perlindungan_khusus_DP' => 'required|integer|min:0',
            'anak_yang_memerlukan_perlindungan_khusus_LP' => 'required|integer|min:0',
            'lanjut_usia_terlantar_DP' => 'required|integer|min:0',
            'lanjut_usia_terlantar_LP' => 'required|integer|min:0',
            'disabilitas_fisik_DP' => 'required|integer|min:0',
            'disabilitas_fisik_LP' => 'required|integer|min:0',
            'disabilitas_intelektual_DP' => 'required|integer|min:0',
            'disabilitas_intelektual_LP' => 'required|integer|min:0',
            'disabilitas_mental_DP' => 'required|integer|min:0',
            'disabilitas_mental_LP' => 'required|integer|min:0',
            'disabilitas_sensorik_DP' => 'required|integer|min:0',
            'disabilitas_sensorik_LP' => 'required|integer|min:0',
            'tuna_susila_DP' => 'required|integer|min:0',
            'tuna_susila_LP' => 'required|integer|min:0',
            'gelandangan_DP' => 'required|integer|min:0',
            'gelandangan_LP' => 'required|integer|min:0',
            'pengemis_DP' => 'required|integer|min:0',
            'pengemis_LP' => 'required|integer|min:0',
            'pemulung_DP' => 'required|integer|min:0',
            'pemulung_LP' => 'required|integer|min:0',
            'kelompok_minoritas_DP' => 'required|integer|min:0',
            'kelompok_minoritas_LP' => 'required|integer|min:0',
            'BWBLP_DP' => 'required|integer|min:0',
            'BWBLP_LP' => 'required|integer|min:0',
            'orang_dengan_hiv_aids_DP' => 'required|integer|min:0',
            'orang_dengan_hiv_aids_LP' => 'required|integer|min:0',
            'penyalahgunaan_Napza_DP' => 'required|integer|min:0',
            'penyalahgunaan_Napza_LP' => 'required|integer|min:0',
            'korban_Trafficking_DP' => 'required|integer|min:0',
            'korban_Trafficking_LP' => 'required|integer|min:0',
            'korban_tindak_kekerasan_DP' => 'required|integer|min:0',
            'korban_tindak_kekerasan_LP' => 'required|integer|min:0',
            'PMBS_DP' => 'required|integer|min:0',
            'PMBS_LP' => 'required|integer|min:0',
            'korban_bencana_alam_DP' => 'required|integer|min:0',
            'korban_bencana_alam_LP' => 'required|integer|min:0',
            'korban_bencana_sosial_DP' => 'required|integer|min:0',
            'korban_bencana_sosial_LP' => 'required|integer|min:0',
            'perempuan_rawan_sosial_ekonomi_DP' => 'required|integer|min:0',
            'perempuan_rawan_sosial_ekonomi_LP' => 'required|integer|min:0',
            'fakir_miskin_DP' => 'required|integer|min:0',
            'fakir_miskin_LP' => 'required|integer|min:0',
            'keluarga_bermasalah_sosial_psikologis_DP' => 'required|integer|min:0',
            'keluarga_bermasalah_sosial_psikologis_LP' => 'required|integer|min:0',
            'komunitas_adat_terpencil_DP' => 'required|integer|min:0',
            'komunitas_adat_terpencil_LP' => 'required|integer|min:0',
            'nomor_tlp' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'link_tanda_daftar' => 'nullable|string|max:255',
        ]);

        $kewenangan->update($validated);

        return redirect()->route('kewenangan-kabkota.show', $kewenangan)
                         ->with('success', 'Data Kewenangan Kabupaten/Kota berhasil diperbarui.');
    }

    public function destroy(KewenanganKabkota $kewenangan)
    {
        $kewenangan->delete();

        // User tidak bisa akses index, arahkan ke create
        if (auth()->user()->hasRole('user')) {
            return redirect()->route('kewenangan-kabkota.create')
                             ->with('success', 'Data Kewenangan Kabupaten/Kota berhasil dihapus.');
        }

        return redirect()->route('kewenangan-kabkota.index')
                         ->with('success', 'Data Kewenangan Kabupaten/Kota berhasil dihapus.');
    }

    /**
     * Get statistics for dashboard
     */
    private function getStatistics($filterKabkota = null)
    {
        $baseQuery = KewenanganKabkota::query();
        if ($filterKabkota) {
            $baseQuery->where('kabupaten_kota', $filterKabkota);
        }

        $totalStats = (clone $baseQuery)->select(
            DB::raw('SUM(jumlah_dalam_panti) as total_dalam_panti'),
            DB::raw('SUM(jumlah_luar_panti) as total_luar_panti'),
            DB::raw('COUNT(*) as total_lks')
        )->first();

        // Statistics by kabupaten/kota
        $statsByKabupaten = KewenanganKabkota::select(
            'kabupaten_kota',
            DB::raw('SUM(jumlah_dalam_panti) as total_dalam_panti'),
            DB::raw('SUM(jumlah_luar_panti) as total_luar_panti'),
            DB::raw('COUNT(*) as total_lks')
        )
        ->groupBy('kabupaten_kota')
        ->orderBy('total_dalam_panti', 'desc')
        ->get();

        // statistics by jenis pelayanan (dengan filter kabkota)
        $statsByJenisPelayanan = $this->getStatsByJenisPelayanan($filterKabkota);

        return [
            'total' => [
                'dalam_panti' => $totalStats->total_dalam_panti ?? 0,
                'luar_panti' => $totalStats->total_luar_panti ?? 0,
                'seluruh_binaan' => ($totalStats->total_dalam_panti ?? 0) + ($totalStats->total_luar_panti ?? 0),
                'total_lks' => $totalStats->total_lks ?? 0
            ],
            'by_kabupaten' => $statsByKabupaten,
            'by_jenis_pelayanan' => $statsByJenisPelayanan
        ];
    }

    private function getStatsByJenisPelayanan($filterKabkota = null)
    {
        // Daftar tetap semua jenis pelayanan
        $jenisPelayananList = [
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
            'Komunitas adat terpencil'
        ];

        // Ambil semua data (dengan filter kabkota jika ada)
        $allDataQuery = KewenanganKabkota::whereNotNull('jenis_pelayanan_PPKS')
                                   ->where('jenis_pelayanan_PPKS', '!=', '');
        if ($filterKabkota) {
            $allDataQuery->where('kabupaten_kota', $filterKabkota);
        }
        $allData = $allDataQuery->get();

        // Inisialisasi statistik
        $pelayananStats = [];
        foreach ($jenisPelayananList as $pelayanan) {
            $pelayananStats[$pelayanan] = [
                'total_lks' => 0,
                'total_dalam_panti' => 0,
                'total_luar_panti' => 0,
                'total_seluruh_binaan' => 0
            ];
        }

        // Proses setiap record untuk menghitung jumlah LKS per jenis pelayanan
        foreach ($allData as $data) {
            // Split multiple jenis pelayanan oleh koma
            $jenisPelayananArray = array_map('trim', explode(',', $data->jenis_pelayanan_PPKS));
            
            foreach ($jenisPelayananArray as $singlePelayanan) {
                $singlePelayanan = trim($singlePelayanan);
                
                // Cari match dengan daftar tetap
                foreach ($jenisPelayananList as $fixedPelayanan) {
                    if ($this->normalizeString($singlePelayanan) === $this->normalizeString($fixedPelayanan)) {
                        // HANYA tambahkan counting LKS
                        $pelayananStats[$fixedPelayanan]['total_lks'] += 1;
                        break;
                    }
                }
            }
        }

        // Hitung jumlah binaan secara TERPISAH untuk menghindari double counting
        foreach ($allData as $data) {
            $jenisPelayananArray = array_map('trim', explode(',', $data->jenis_pelayanan_PPKS));
            $jumlahJenisPelayanan = count($jenisPelayananArray);
            
            // Jika hanya satu jenis pelayanan, langsung assign
            if ($jumlahJenisPelayanan === 1) {
                $singlePelayanan = trim($jenisPelayananArray[0]);
                foreach ($jenisPelayananList as $fixedPelayanan) {
                    if ($this->normalizeString($singlePelayanan) === $this->normalizeString($fixedPelayanan)) {
                        $pelayananStats[$fixedPelayanan]['total_dalam_panti'] += $data->jumlah_dalam_panti;
                        $pelayananStats[$fixedPelayanan]['total_luar_panti'] += $data->jumlah_luar_panti;
                        // TOTAL SELURUH BINAAN = dalam panti + luar panti
                        $pelayananStats[$fixedPelayanan]['total_seluruh_binaan'] += ($data->jumlah_dalam_panti + $data->jumlah_luar_panti);
                        break;
                    }
                }
            } else {
                // Jika multiple jenis pelayanan, bagi rata jumlah binaan
                $rataDalamPanti = $data->jumlah_dalam_panti / $jumlahJenisPelayanan;
                $rataLuarPanti = $data->jumlah_luar_panti / $jumlahJenisPelayanan;
                $rataSeluruhBinaan = ($data->jumlah_dalam_panti + $data->jumlah_luar_panti) / $jumlahJenisPelayanan;
                
                foreach ($jenisPelayananArray as $singlePelayanan) {
                    $singlePelayanan = trim($singlePelayanan);
                    foreach ($jenisPelayananList as $fixedPelayanan) {
                        if ($this->normalizeString($singlePelayanan) === $this->normalizeString($fixedPelayanan)) {
                            $pelayananStats[$fixedPelayanan]['total_dalam_panti'] += $rataDalamPanti;
                            $pelayananStats[$fixedPelayanan]['total_luar_panti'] += $rataLuarPanti;
                            // TOTAL SELURUH BINAAN = dalam panti + luar panti yang sudah dibagi rata
                            $pelayananStats[$fixedPelayanan]['total_seluruh_binaan'] += $rataSeluruhBinaan;
                            break;
                        }
                    }
                }
            }
        }

        // Bulatkan angka untuk menghindari desimal dan pastikan konsistensi
        foreach ($pelayananStats as &$stat) {
            $stat['total_dalam_panti'] = round($stat['total_dalam_panti']);
            $stat['total_luar_panti'] = round($stat['total_luar_panti']);
            // Pastikan total seluruh binaan = dalam panti + luar panti (untuk konsistensi)
            $stat['total_seluruh_binaan'] = $stat['total_dalam_panti'] + $stat['total_luar_panti'];
        }

        return $pelayananStats;
    }

    private function normalizeString($string)
    {
        return trim(strtolower($string));
    }

    /**
     * API untuk mendapatkan data statistik
     */
    public function getStatisticsAPI()
    {
        $statistics = $this->getStatistics();
        return response()->json($statistics);
    }

    /**
     * API untuk mendapatkan statistik jenis pelayanan
     */
    public function getJenisPelayananStatsAPI()
    {
        $stats = $this->getStatsByJenisPelayanan();
        return response()->json($stats);
    }


    /**
     * Export CSV
     */
    public function exportExcel(Request $request)
    {
        $search = $request->get('search');
        $query  = KewenanganKabkota::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('Nama_Lembaga_Yayasan', 'like', "%{$search}%")
                  ->orWhere('nama_lks', 'like', "%{$search}%")
                  ->orWhere('kabupaten_kota', 'like', "%{$search}%");
            });
        }

        $kewenangan = $query->get();
        $filename   = 'kewenangan_kabkota_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($kewenangan) {
            $file = fopen('php://output', 'w');

            // BOM UTF-8 agar Excel bisa baca karakter Indonesia
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header baris
            fputcsv($file, [
                'No', 'Nama Lembaga', 'Status', 'Kabupaten/Kota', 'Nama LKS', 'Alamat LKS', 'Ketua LKS',
                'Total Binaan', 'Dalam Panti', 'Luar Panti',
                'Anak Balita Terlantar', 'Anak Terlantar', 'Anak Berhadapan Hukum', 'Anak Jalanan',
                'Anak Disabilitas', 'Anak Korban Kekerasan', 'Anak Perlindungan Khusus',
                'Lansia', 'Disabilitas Fisik', 'Disabilitas Intelektual', 'Disabilitas Mental', 'Disabilitas Sensorik',
                'Tuna Susila', 'Gelandangan', 'Pengemis', 'Pemulung', 'Kelompok Minoritas', 'BWBLP',
                'ODHA', 'Penyalahgunaan Napza', 'Korban Trafficking', 'Korban Tindak Kekerasan', 'PMBS',
                'Korban Bencana Alam', 'Korban Bencana Sosial', 'Perempuan Rawan Sosial Ekonomi',
                'Fakir Miskin', 'Keluarga Bermasalah Sosial Psikologis', 'Komunitas Adat Terpencil',
                'Telepon', 'Email', 'Tanggal Input',
            ]);

            $i = 1;
            foreach ($kewenangan as $item) {
                fputcsv($file, [
                    $i++,
                    $item->Nama_Lembaga_Yayasan,
                    $this->getStatusLabel($item->status),
                    $item->kabupaten_kota,
                    $item->nama_lks,
                    $item->alamat_lks,
                    $item->nama_ketua_lks,
                    $item->jumlah_seluruh_binaan,
                    $item->jumlah_dalam_panti,
                    $item->jumlah_luar_panti,
                    $item->anak_balita_terlantar_DP + $item->anak_balita_terlantar_LP,
                    $item->anak_terlantar_DP + $item->anak_terlantar_LP,
                    $item->anak_yangberhadapan_dengan_hukum_DP + $item->anak_yangberhadapan_dengan_hukum_LP,
                    $item->anak_jalanan_DP + $item->anak_jalanan_LP,
                    $item->anak_dengan_kedisabilitas_DP + $item->anak_dengan_kedisabilitas_LP,
                    $item->anak_yangmenjadi_tidak_kekerasan_DP + $item->anak_yangmenjadi_tidak_kekerasan_LP,
                    $item->anak_yang_memerlukan_perlindungan_khusus_DP + $item->anak_yang_memerlukan_perlindungan_khusus_LP,
                    $item->lanjut_usia_terlantar_DP + $item->lanjut_usia_terlantar_LP,
                    $item->disabilitas_fisik_DP + $item->disabilitas_fisik_LP,
                    $item->disabilitas_intelektual_DP + $item->disabilitas_intelektual_LP,
                    $item->disabilitas_mental_DP + $item->disabilitas_mental_LP,
                    $item->disabilitas_sensorik_DP + $item->disabilitas_sensorik_LP,
                    $item->tuna_susila_DP + $item->tuna_susila_LP,
                    $item->gelandangan_DP + $item->gelandangan_LP,
                    $item->pengemis_DP + $item->pengemis_LP,
                    $item->pemulung_DP + $item->pemulung_LP,
                    $item->kelompok_minoritas_DP + $item->kelompok_minoritas_LP,
                    $item->BWBLP_DP + $item->BWBLP_LP,
                    $item->orang_dengan_hiv_aids_DP + $item->orang_dengan_hiv_aids_LP,
                    $item->penyalahgunaan_Napza_DP + $item->penyalahgunaan_Napza_LP,
                    $item->korban_Trafficking_DP + $item->korban_Trafficking_LP,
                    $item->korban_tindak_kekerasan_DP + $item->korban_tindak_kekerasan_LP,
                    $item->PMBS_DP + $item->PMBS_LP,
                    $item->korban_bencana_alam_DP + $item->korban_bencana_alam_LP,
                    $item->korban_bencana_sosial_DP + $item->korban_bencana_sosial_LP,
                    $item->perempuan_rawan_sosial_ekonomi_DP + $item->perempuan_rawan_sosial_ekonomi_LP,
                    $item->fakir_miskin_DP + $item->fakir_miskin_LP,
                    $item->keluarga_bermasalah_sosial_psikologis_DP + $item->keluarga_bermasalah_sosial_psikologis_LP,
                    $item->komunitas_adat_terpencil_DP + $item->komunitas_adat_terpencil_LP,
                    $item->nomor_tlp,
                    $item->email,
                    $item->created_at ? $item->created_at->format('d-m-Y H:i') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper untuk label status
     */
    private function getStatusLabel($status)
    {
        $statuses = [
            'pusat' => 'Pusat',
            'cabang' => 'Cabang'
        ];
        return $statuses[$status] ?? $status;
    }

    /**
     * Helper untuk label akreditasi
     */
    private function getAkreditasiLabel($akreditasi)
    {
        $akreditasiList = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
            'tidak_terakreditasi' => 'Tidak Terakreditasi'
        ];
        return $akreditasiList[$akreditasi] ?? $akreditasi;
    }

}