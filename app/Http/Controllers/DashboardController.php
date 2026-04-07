<?php

namespace App\Http\Controllers;

use App\Models\LKS;
use App\Models\KewenanganKabkota;
use App\Models\KewenanganProvinsi;
use App\Models\KewenanganKemensos;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data dari model LKS (existing) - untuk pendaftaran baru
        $totalLKS = LKS::count();
        $lengkapLKS = LKS::where('pendaftaran_lengkap', true)->count();
        $menungguLKS = LKS::where('status_permohonan', 'Menunggu')->count();
        $diterimaLKS = LKS::where('status_permohonan', 'Diterima')->count();

        // ===== DATA UNTUK DIAGRAM LINGKARAN KEWENANGAN =====
        $kewenanganKabkota = KewenanganKabkota::count();
        $kewenanganProvinsi = KewenanganProvinsi::count();
        $kewenanganKemensos = KewenanganKemensos::count();

        // **TOTAL LKS SE-JABAR** - dihitung dari jumlah 3 kewenangan
        $totalLKSJabar = $kewenanganKabkota + $kewenanganProvinsi + $kewenanganKemensos;

        // Data untuk chart kewenangan
        $kewenanganChartData = [
            'labels' => ['Kabupaten/Kota', 'Provinsi', 'Kemensos'],
            'data' => [$kewenanganKabkota, $kewenanganProvinsi, $kewenanganKemensos],
            'colors' => ['#4e73df', '#1cc88a', '#36b9cc'],
            'total' => $totalLKSJabar
        ];

        // Hitung persentase
        if ($kewenanganChartData['total'] > 0) {
            $kewenanganChartData['percentages'] = [
                round(($kewenanganKabkota / $kewenanganChartData['total']) * 100, 1),
                round(($kewenanganProvinsi / $kewenanganChartData['total']) * 100, 1),
                round(($kewenanganKemensos / $kewenanganChartData['total']) * 100, 1)
            ];
        } else {
            $kewenanganChartData['percentages'] = [0, 0, 0];
        }

        // ===== DATA DISTRIBUSI KABUPATEN/KOTA DARI 3 KEWENANGAN =====
        $semuaKabupaten = [
            'Kabupaten Bogor', 'Kabupaten Sukabumi', 'Kabupaten Cianjur', 'Kabupaten Bandung',
            'Kabupaten Garut', 'Kabupaten Tasikmalaya', 'Kabupaten Ciamis', 'Kabupaten Kuningan',
            'Kabupaten Cirebon', 'Kabupaten Majalengka', 'Kabupaten Sumedang', 'Kabupaten Indramayu',
            'Kabupaten Subang', 'Kabupaten Purwakarta', 'Kabupaten Karawang', 'Kabupaten Bekasi',
            'Kabupaten Bandung Barat', 'Kabupaten Pangandaran', 'Kota Bogor', 'Kota Sukabumi',
            'Kota Bandung', 'Kota Cirebon', 'Kota Bekasi', 'Kota Depok', 'Kota Cimahi',
            'Kota Tasikmalaya', 'Kota Banjar'
        ];

        // Ambil data dari ketiga kewenangan dengan normalisasi nama kabupaten/kota
        $kabkotaData = $this->getKabupatenDataFromKewenangan(KewenanganKabkota::class, 'Kabupaten_kota');
        $provinsiData = $this->getKabupatenDataFromKewenangan(KewenanganProvinsi::class, 'kabupaten_kota');
        $kemensosData = $this->getKabupatenDataFromKewenangan(KewenanganKemensos::class, 'kabupaten_kota');

        // Gabungkan data dari ketiga kewenangan
        $kabupatenData = [];
        foreach ($semuaKabupaten as $kabupaten) {
            $total = 0;
            $total += $kabkotaData[$kabupaten] ?? 0;
            $total += $provinsiData[$kabupaten] ?? 0;
            $total += $kemensosData[$kabupaten] ?? 0;
            $kabupatenData[$kabupaten] = $total;
        }
        arsort($kabupatenData);

        // ===== END DATA DISTRIBUSI KABUPATEN/KOTA =====

        // Data trend bulanan (6 bulan terakhir) - dari LKS baru
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->translatedFormat('M Y');
            $count = LKS::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
            $monthlyTrend[$monthName] = $count;
        }

        // Data status permohonan - dari LKS baru
        $statusData = LKS::select('status_permohonan', DB::raw('COUNT(*) as total'))
            ->groupBy('status_permohonan')
            ->get()
            ->pluck('total', 'status_permohonan')
            ->toArray();

        // Jika tidak ada data status, berikan default
        if (empty($statusData)) {
            $statusData = [
                'Menunggu' => 0,
                'Diterima' => 0,
                'Ditolak' => 0,
                'Proses Verifikasi' => 0
            ];
        }

        // Recent LKS (5 data terbaru) - dari LKS baru
        $recentLKS = LKS::with(['checklists.document'])
            ->latest()
            ->take(5)
            ->get();

        // Tambahkan status badge untuk recent LKS
        $recentLKS->each(function ($lks) {
            $lks->status_badge = $this->getStatusBadge($lks->status_permohonan);
        });

        // Ambil LKS terbaru milik user login (jika ada relasi user_id pada LKS)
        // Ambil LKS terbaru secara global (tanpa filter user_id karena kolom tersebut tidak ada)
        $latestLks = LKS::latest()->first();

        return view('dashboard.dashboard', compact(
            'totalLKS', 
            'lengkapLKS', 
            'menungguLKS', 
            'diterimaLKS',
            'kabupatenData',
            'monthlyTrend',
            'statusData',
            'recentLKS',
            'kewenanganChartData',
            'kewenanganKabkota',
            'kewenanganProvinsi',
            'kewenanganKemensos',
            'totalLKSJabar',
            'latestLks'
        ));
    }

    /**
     * Helper method untuk mengambil data kabupaten dari kewenangan dengan normalisasi
     */
    private function getKabupatenDataFromKewenangan($model, $columnName)
    {
        return $model::select($columnName, DB::raw('COUNT(*) as total'))
            ->whereNotNull($columnName)
            ->where($columnName, '!=', '')
            ->groupBy($columnName)
            ->get()
            ->mapWithKeys(function ($item) use ($columnName) {
                // Normalisasi nama kabupaten/kota
                $kabupaten = trim($item->$columnName);
                
                // Standardisasi nama jika diperlukan
                $kabupaten = $this->normalizeKabupatenName($kabupaten);
                
                return [$kabupaten => $item->total];
            })
            ->toArray();
    }

    /**
     * Normalisasi nama kabupaten/kota untuk konsistensi
     */
    private function normalizeKabupatenName($name)
    {
        $normalizations = [
            'KAB.' => 'Kabupaten',
            'KOTA.' => 'Kota',
            'KAB ' => 'Kabupaten ',
            'KOTA ' => 'Kota ',
        ];

        $normalizedName = str_replace(array_keys($normalizations), array_values($normalizations), $name);
        
        // Pastikan format konsisten
        if (strpos($normalizedName, 'Kabupaten') === 0) {
            $normalizedName = 'Kabupaten ' . trim(str_replace('Kabupaten', '', $normalizedName));
        } elseif (strpos($normalizedName, 'Kota') === 0) {
            $normalizedName = 'Kota ' . trim(str_replace('Kota', '', $normalizedName));
        }

        return trim($normalizedName);
    }

    /**
     * Helper method untuk menentukan badge class berdasarkan status
     */
    private function getStatusBadge($status)
    {
        switch ($status) {
            case 'Diterima':
                return 'bg-success';
            case 'Ditolak':
                return 'bg-danger';
            case 'Proses Verifikasi':
                return 'bg-warning';
            case 'Menunggu':
                return 'bg-secondary';
            default:
                return 'bg-secondary';
        }
    }

    /**
     * Method untuk mendapatkan data statistik tambahan (jika diperlukan)
     */
    public function getStatistics()
    {
        // Total LKS per jenis kewenangan
        $statistics = [
            'total_kewenangan_kabkota' => KewenanganKabkota::count(),
            'total_kewenangan_provinsi' => KewenanganProvinsi::count(),
            'total_kewenangan_kemensos' => KewenanganKemensos::count(),
            'total_lks_baru' => LKS::count(),
            'lks_lengkap' => LKS::where('pendaftaran_lengkap', true)->count(),
            'lks_menunggu' => LKS::where('status_permohonan', 'Menunggu')->count(),
            'lks_diterima' => LKS::where('status_permohonan', 'Diterima')->count(),
        ];

        // Total LKS Se-JABAR
        $statistics['total_lks_jabar'] = 
            $statistics['total_kewenangan_kabkota'] + 
            $statistics['total_kewenangan_provinsi'] + 
            $statistics['total_kewenangan_kemensos'];

        return response()->json($statistics);
    }

    /**
     * Method untuk mendapatkan data chart (API endpoint)
     */
    public function getChartData()
    {
        // Data untuk chart kewenangan
        $kewenanganKabkota = KewenanganKabkota::count();
        $kewenanganProvinsi = KewenanganProvinsi::count();
        $kewenanganKemensos = KewenanganKemensos::count();
        $totalLKSJabar = $kewenanganKabkota + $kewenanganProvinsi + $kewenanganKemensos;

        $kewenanganChartData = [
            'labels' => ['Kabupaten/Kota', 'Provinsi', 'Kemensos'],
            'data' => [$kewenanganKabkota, $kewenanganProvinsi, $kewenanganKemensos],
            'colors' => ['#4e73df', '#1cc88a', '#36b9cc'],
            'total' => $totalLKSJabar
        ];

        // Hitung persentase
        if ($totalLKSJabar > 0) {
            $kewenanganChartData['percentages'] = [
                round(($kewenanganKabkota / $totalLKSJabar) * 100, 1),
                round(($kewenanganProvinsi / $totalLKSJabar) * 100, 1),
                round(($kewenanganKemensos / $totalLKSJabar) * 100, 1)
            ];
        } else {
            $kewenanganChartData['percentages'] = [0, 0, 0];
        }

        // Data trend bulanan
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->translatedFormat('M Y');
            $count = LKS::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
            $monthlyTrend[$monthName] = $count;
        }

        // Data status permohonan
        $statusData = LKS::select('status_permohonan', DB::raw('COUNT(*) as total'))
            ->groupBy('status_permohonan')
            ->get()
            ->pluck('total', 'status_permohonan')
            ->toArray();

        return response()->json([
            'kewenangan_chart' => $kewenanganChartData,
            'monthly_trend' => $monthlyTrend,
            'status_data' => $statusData,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Method untuk mendapatkan data kabupaten/kota dari 3 kewenangan
     */
    public function getKabupatenData()
    {
        $semuaKabupaten = [
            'Kabupaten Bogor', 'Kabupaten Sukabumi', 'Kabupaten Cianjur', 'Kabupaten Bandung',
            'Kabupaten Garut', 'Kabupaten Tasikmalaya', 'Kabupaten Ciamis', 'Kabupaten Kuningan',
            'Kabupaten Cirebon', 'Kabupaten Majalengka', 'Kabupaten Sumedang', 'Kabupaten Indramayu',
            'Kabupaten Subang', 'Kabupaten Purwakarta', 'Kabupaten Karawang', 'Kabupaten Bekasi',
            'Kabupaten Bandung Barat', 'Kabupaten Pangandaran', 'Kota Bogor', 'Kota Sukabumi',
            'Kota Bandung', 'Kota Cirebon', 'Kota Bekasi', 'Kota Depok', 'Kota Cimahi',
            'Kota Tasikmalaya', 'Kota Banjar'
        ];

        // Ambil data dari ketiga kewenangan
        $kabkotaData = $this->getKabupatenDataFromKewenangan(KewenanganKabkota::class, 'Kabupaten_kota');
        $provinsiData = $this->getKabupatenDataFromKewenangan(KewenanganProvinsi::class, 'kabupaten_kota');
        $kemensosData = $this->getKabupatenDataFromKewenangan(KewenanganKemensos::class, 'kabupaten_kota');

        // Gabungkan data dari ketiga kewenangan
        $kabupatenData = [];
        $detailData = [];

        foreach ($semuaKabupaten as $kabupaten) {
            $totalKabkota = $kabkotaData[$kabupaten] ?? 0;
            $totalProvinsi = $provinsiData[$kabupaten] ?? 0;
            $totalKemensos = $kemensosData[$kabupaten] ?? 0;
            $total = $totalKabkota + $totalProvinsi + $totalKemensos;
            
            $kabupatenData[$kabupaten] = $total;
            
            // Data detail untuk breakdown
            $detailData[$kabupaten] = [
                'total' => $total,
                'kabkota' => $totalKabkota,
                'provinsi' => $totalProvinsi,
                'kemensos' => $totalKemensos
            ];
        }

        // Urutkan berdasarkan jumlah tertinggi
        arsort($kabupatenData);

        return response()->json([
            'kabupaten_data' => $kabupatenData,
            'detail_data' => $detailData,
            'total_kabupaten_terisi' => count(array_filter($kabupatenData)),
            'total_kabupaten' => count($semuaKabupaten),
            'sumber_data' => 'Kewenangan Kabkota, Provinsi, dan Kemensos',
            'statistik_kewenangan' => [
                'total_kabkota' => array_sum($kabkotaData),
                'total_provinsi' => array_sum($provinsiData),
                'total_kemensos' => array_sum($kemensosData)
            ]
        ]);
    }

    /**
     * Method untuk mendapatkan data recent LKS
     */
    public function getRecentLKS()
    {
        $recentLKS = LKS::with(['checklists.document'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($lks) {
                return [
                    'id' => $lks->id,
                    'nama_lks' => $lks->nama_lks,
                    'kabupaten_kota' => $lks->kabupaten_kota ?: $lks->lokasi_lks,
                    'tanggal_masuk' => $lks->created_at->format('d/m/Y'),
                    'status_permohonan' => $lks->status_permohonan ?? 'Menunggu',
                    'status_badge' => $this->getStatusBadge($lks->status_permohonan),
                    'pendaftaran_lengkap' => $lks->pendaftaran_lengkap,
                    'show_url' => route('lks.show', $lks->id)
                ];
            });

        return response()->json([
            'recent_lks' => $recentLKS,
            'total_recent' => $recentLKS->count()
        ]);
    }

    /**
     * Method untuk mendapatkan breakdown data per kewenangan per kabupaten
     */
    public function getKabupatenBreakdown()
    {
        $semuaKabupaten = [
            'Kabupaten Bogor', 'Kabupaten Sukabumi', 'Kabupaten Cianjur', 'Kabupaten Bandung',
            'Kabupaten Garut', 'Kabupaten Tasikmalaya', 'Kabupaten Ciamis', 'Kabupaten Kuningan',
            'Kabupaten Cirebon', 'Kabupaten Majalengka', 'Kabupaten Sumedang', 'Kabupaten Indramayu',
            'Kabupaten Subang', 'Kabupaten Purwakarta', 'Kabupaten Karawang', 'Kabupaten Bekasi',
            'Kabupaten Bandung Barat', 'Kabupaten Pangandaran', 'Kota Bogor', 'Kota Sukabumi',
            'Kota Bandung', 'Kota Cirebon', 'Kota Bekasi', 'Kota Depok', 'Kota Cimahi',
            'Kota Tasikmalaya', 'Kota Banjar'
        ];

        // Ambil data detail dari ketiga kewenangan
        $kabkotaData = $this->getDetailedKabupatenData(KewenanganKabkota::class, 'kabupaten_kota');
        $provinsiData = $this->getDetailedKabupatenData(KewenanganProvinsi::class, 'kabupaten_kota');
        $kemensosData = $this->getDetailedKabupatenData(KewenanganKemensos::class, 'kabupaten_kota');

        $breakdownData = [];

        foreach ($semuaKabupaten as $kabupaten) {
            $breakdownData[$kabupaten] = [
                'kabkota' => $kabkotaData[$kabupaten] ?? [],
                'provinsi' => $provinsiData[$kabupaten] ?? [],
                'kemensos' => $kemensosData[$kabupaten] ?? [],
                'total' => (
                    count($kabkotaData[$kabupaten] ?? []) + 
                    count($provinsiData[$kabupaten] ?? []) + 
                    count($kemensosData[$kabupaten] ?? [])
                )
            ];
        }

        return response()->json([
            'breakdown_data' => $breakdownData,
            'summary' => [
                'total_kabkota' => KewenanganKabkota::count(),
                'total_provinsi' => KewenanganProvinsi::count(),
                'total_kemensos' => KewenanganKemensos::count(),
                'total_all' => KewenanganKabkota::count() + KewenanganProvinsi::count() + KewenanganKemensos::count()
            ]
        ]);
    }

    /**
     * Helper method untuk mendapatkan data detail kabupaten
     */
    private function getDetailedKabupatenData($model, $columnName)
    {
        return $model::select($columnName, 'nama_lks', 'Nama Lembaga/Yayasan', 'jenis_pelayanan_PPKS')
            ->whereNotNull($columnName)
            ->where($columnName, '!=', '')
            ->get()
            ->groupBy(function ($item) use ($columnName) {
                return $this->normalizeKabupatenName($item->$columnName);
            })
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'nama_lks' => $item->nama_lks,
                        'nama_yayasan' => $item->{'Nama Lembaga/Yayasan'},
                        'jenis_pelayanan' => $item->jenis_pelayanan_PPKS
                    ];
                });
            })
            ->toArray();
    }
}