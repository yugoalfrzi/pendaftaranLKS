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
        $query = KewenanganKabkota::query();
        
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('Nama_Lembaga_Yayasan', 'like', "%{$search}%")
                  ->orWhere('nama_lks', 'like', "%{$search}%")
                  ->orWhere('kabupaten_kota', 'like', "%{$search}%");
            });
        }
        
        $kewenangan = $query->paginate(20);

        $statistics = $this->getStatistics();
        
        return view('kewenangan.kabkota.index', compact('kewenangan', 'statistics'));
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

        return redirect()->route('kewenangan-kabkota.index')
                         ->with('success', 'Data Kewenangan Kabupaten/Kota berhasil dihapus.');
    }

    /**
     * Get statistics for dashboard
     */
    private function getStatistics()
    {
        // Total statistics across all records
        $totalStats = KewenanganKabkota::select(
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

        // statistics by jenis pelayanan
        $statsByJenisPelayanan = $this->getStatsByJenisPelayanan();

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

    private function getStatsByJenisPelayanan()
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

        // Ambil semua data
        $allData = KewenanganKabkota::whereNotNull('jenis_pelayanan_PPKS')
                                   ->where('jenis_pelayanan_PPKS', '!=', '')
                                   ->get();

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
     * Export Excel
     */
    public function exportExcel(Request $request)
    {
        $search = $request->get('search');
        $query = KewenanganKabkota::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('Nama_Lembaga_Yayasan', 'like', "%{$search}%")
                  ->orWhere('nama_lks', 'like', "%{$search}%")
                  ->orWhere('kabupaten_kota', 'like', "%{$search}%");
            });
        }
        
        $kewenangan = $query->get();

        $html = $this->generateExcelTable($kewenangan);
        
        $filename = 'kewenangan_kabkota_' . date('Y_m_d_His') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        return response($html, 200, $headers);
    }

    /**
     * Generate HTML table untuk Excel yang lebih rapi
     */
    private function generateExcelTable($kewenangan)
    {
        $totalBinaan = $kewenangan->sum('jumlah_seluruh_binaan');
        $totalDalamPanti = $kewenangan->sum('jumlah_dalam_panti');
        $totalLuarPanti = $kewenangan->sum('jumlah_luar_panti');

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>Data Kewenangan Kabupaten/Kota</title>
            <style>
                body { font-family: "Times New Roman"; font-size: 20px; }
                .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 15px; }
                .header h2 { color: #2E86C1; margin-bottom: 5px; }
                .header h3 { color: #555; margin-bottom: 10px; }
                .summary { background-color: #E8F8F5; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2E86C1; }
                table { border-collapse: collapse; width: 100%; font-family: "Times New Roman"; font-size: 10px; margin-top: 10px; }
                th { background-color: #2E86C1; color: #FFFFFF; font-weight: bold; padding: 10px 8px; text-align: center; border: 1px solid #1B4F72; }
                td { padding: 8px; border: 1px solid #DDD; text-align: left; vertical-align: top; }
                tr:nth-child(even) { background-color: #f8f9fa; }
                tr:hover { background-color: #e9ecef; }
                .number { text-align: right; }
                .center { text-align: center; }
                .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #666; border-top: 1px solid #DDD; padding-top: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>DATA KEWENANGAN KABUPATEN/KOTA</h2>
                <h3>DINAS SOSIAL PROVINSI JAWA BARAT</h3>
                <p>Tanggal Export: ' . date('d-m-Y H:i') . ' | Total Data: ' . number_format($kewenangan->count()) . ' records</p>
            </div>

            <div class="summary">
                <strong>RINGKASAN DATA:</strong><br>
                Total Seluruh Binaan: ' . number_format($totalBinaan) . ' | 
                Total Dalam Panti: ' . number_format($totalDalamPanti) . ' | 
                Total Luar Panti: ' . number_format($totalLuarPanti) . ' |
                Jumlah LKS: ' . number_format($kewenangan->count()) . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="12%">Nama Lembaga</th>
                        <th width="8%">Status</th>
                        <th width="10%">Kabupaten/Kota</th>
                        <th width="12%">Nama LKS</th>
                        <th width="15%">Alamat LKS</th>
                        <th width="10%">Ketua LKS</th>
                        <th width="5%">Total Binaan</th>
                        <th width="5%">Dalam Panti</th>
                        <th width="5%">Luar Panti</th>
                        <th width="8%">Anak balita terkantar</th>
                        <th width="8%">Anak terlantar</th>
                        <th width="8%">Anak berhadapan hukum</th>
                        <th width="8%">Anak jalanan</th>
                        <th width="8%">Anak disabilitas</th>
                        <th width="8%">Anak korban kekerasan</th>
                        <th width="8%">Anak perlindungan khusus</th>
                        <th width="8%">Lansia</th>
                        <th width="8%">Penyandang disabilitas fisik</th>
                        <th width="8%">Penyandang disabilitas intelektual</th>
                        <th width="8%">Penyandang disabilitas mental</th>
                        <th width="8%">Penyandang disabilitas sensorik</th>
                        <th width="8%">Tuna susila</th>
                        <th width="8%">Gelandangan</th>
                        <th width="8%">Pengemis</th>
                        <th width="8%">Pemulung</th>
                        <th width="8%">Kelompok minoritas</th>
                        <th width="8%">BWBLP</th>
                        <th width="8%">ODHA</th>
                        <th width="8%">Penyalahgunaan Napza</th>
                        <th width="8%">Korban trafficking</th>
                        <th width="8%">Korban tindak kekerasan</th>
                        <th width="8%">PMBS</th>
                        <th width="8%">Korban bencana alam</th>
                        <th width="8%">Korban bencana sosial</th>
                        <th width="8%">Perempuan rawan sosial ekonomi</th>
                        <th width="8%">Fakir miskin</th>
                        <th width="8%">Keluarga bermasalah sosial psikologis</th>
                        <th width="8%">Komunitas adat terpencil</th>
                        <th width="8%">Telepon</th>
                        <th width="10%">Email</th>
                        <th width="7%">Tanggal Input</th>
                    </tr>
                </thead>
                <tbody>';

        $i = 1;
        foreach ($kewenangan as $item) {
            $html .= '<tr>
                <td class="center">' . $i++ . '</td>
                <td>' . $this->escapeExcel($item->Nama_Lembaga_Yayasan) . '</td>
                <td class="center">' . $this->getStatusLabel($item->status) . '</td>
                <td>' . $this->escapeExcel($item->kabupaten_kota) . '</td>
                <td>' . $this->escapeExcel($item->nama_lks) . '</td>
                <td>' . $this->escapeExcel($item->alamat_lks) . '</td>
                <td>' . $this->escapeExcel($item->nama_ketua_lks) . '</td>
                <td class="number">' . number_format($item->jumlah_seluruh_binaan) . '</td>
                <td class="number">' . number_format($item->jumlah_dalam_panti) . '</td>
                <td class="number">' . number_format($item->jumlah_luar_panti) . '</td>
                <td class="number">' . number_format($item->anak_balita_terlantar_DP + $item->anak_balita_terlantar_LP) . '</td>
                <td class="number">' . number_format($item->anak_terlantar_DP + $item->anak_terlantar_LP) . '</td>
                <td class="number">' . number_format($item->anak_yangberhadapan_dengan_hukum_DP + $item->anak_yangberhadapan_dengan_hukum_LP) . '</td>
                <td class="number">' . number_format($item->anak_jalanan_DP + $item->anak_jalanan_LP) . '</td>
                <td class="number">' . number_format($item->anak_dengan_kedisabilitas_DP + $item->anak_dengan_kedisabilitas_LP) . '</td>
                <td class="number">' . number_format($item->anak_yangmenjadi_tidak_kekerasan_DP + $item->anak_yangmenjadi_tidak_kekerasan_LP) . '</td>
                <td class="number">' . number_format($item->anak_yang_memerlukan_perlindungan_khusus_DP + $item->anak_yang_memerlukan_perlindungan_khusus_LP) . '</td>
                <td class="number">' . number_format($item->lanjut_usia_terlantar_DP + $item->lanjut_usia_terlantar_LP) . '</td>
                <td class="number">' . number_format($item->disabilitas_fisik_DP + $item->disabilitas_fisik_LP) . '</td>
                <td class="number">' . number_format($item->disabilitas_intelektual_DP + $item->disabilitas_intelektual_LP) . '</td>
                <td class="number">' . number_format($item->disabilitas_mental_DP + $item->disabilitas_mental_LP) . '</td>
                <td class="number">' . number_format($item->disabilitas_sensorik_DP + $item->disabilitas_sensorik_LP) . '</td>
                <td class="number">' . number_format($item->tuna_susila_DP + $item->tuna_susila_LP) . '</td>
                <td class="number">' . number_format($item->gelandangan_DP + $item->gelandangan_LP) . '</td>
                <td class="number">' . number_format($item->pengemis_DP + $item->pengemis_LP) . '</td>
                <td class="number">' . number_format($item->pemulung_DP + $item->pemulung_LP) . '</td>
                <td class="number">' . number_format($item->kelompok_minoritas_DP + $item->kelompok_minoritas_LP) . '</td>
                <td class="number">' . number_format($item->BWBLP_DP + $item->BWBLP_LP) . '</td>
                <td class="number">' . number_format($item->orang_dengan_hiv_aids_DP + $item->orang_dengan_hiv_aids_LP) . '</td>
                <td class="number">' . number_format($item->penyalahgunaan_Napza_DP + $item->penyalahgunaan_Napza_LP) . '</td>
                <td class="number">' . number_format($item->korban_Trafficking_DP + $item->korban_Trafficking_LP) . '</td>
                <td class="number">' . number_format($item->korban_tindak_kekerasan_DP + $item->korban_tindak_kekerasan_LP) . '</td>
                <td class="number">' . number_format($item->PMBS_DP + $item->PMBS_LP) . '</td>
                <td class="number">' . number_format($item->korban_bencana_alam_DP + $item->korban_bencana_alam_LP) . '</td>
                <td class="number">' . number_format($item->korban_bencana_sosial_DP + $item->korban_bencana_sosial_LP) . '</td>
                <td class="number">' . number_format($item->perempuan_rawan_sosial_ekonomi_DP + $item->perempuan_rawan_sosial_ekonomi_LP) . '</td>
                <td class="number">' . number_format($item->fakir_miskin_DP + $item->fakir_miskin_LP) . '</td>
                <td class="number">' . number_format($item->keluarga_bermasalah_sosial_psikologis_DP + $item->keluarga_bermasalah_sosial_psikologis_LP) . '</td>
                <td class="number">' . number_format($item->komunitas_adat_terpencil_DP + $item->komunitas_adat_terpencil_LP) . '</td>
                <td>' . $this->escapeExcel($item->nomor_tlp) . '</td>
                <td>' . $this->escapeExcel($item->email) . '</td>
                <td class="center">' . ($item->created_at ? $item->created_at->format('d-m-Y H:i') : '') . '</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>
            
            <div class="footer">
                <p>Generated by: Sistem Pendaftaran LKS - Dinas Sosial Provinsi Jawa Barat</p>
                <p>Export Date: ' . date('d-m-Y H:i:s') . '</p>
            </div>
        </body>
        </html>';

        return $html;
    }

    /**
     * Escape karakter untuk Excel
     */
    private function escapeExcel($value)
    {
        if (is_null($value)) return '';
        
        $value = str_replace(['"', "'", "\\"], '', $value);
        $value = trim($value);
        
        return $value;
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