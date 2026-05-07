<?php

namespace App\Http\Controllers;

use App\Models\LKS;
use App\Models\rptka;
use App\Models\KewenanganKabkota;
use App\Models\KewenanganProvinsi;
use App\Models\KewenanganKemensos;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard($user);
        }

        if ($user->hasRole('user')) {
            return $this->userDashboard($user);
        }

        return $this->superAdminDashboard();
    }

    // ===================== ADMIN DASHBOARD =====================
    private function adminDashboard($user)
    {
        $kabkota = $user->kabupaten_kota;

        $base = LKS::query();
        if ($kabkota) $base->where('kabupaten_kota', $kabkota);

        $totalLKS       = (clone $base)->count();
        $menunggu       = (clone $base)->where('status_permohonan', 'Menunggu')->count();
        $diterimaProses = (clone $base)->where('status_permohonan', 'Diterima untuk proses')->count();
        $diterima       = (clone $base)->where('status_permohonan', 'Diterima')->count();
        $terverifikasi  = (clone $base)->where('status_permohonan', 'Terverifikasi')->count();
        $ditolak        = (clone $base)->where('status_permohonan', 'Ditolak')->count();
        $dikembalikan   = (clone $base)->where('status_permohonan', 'Dikembalikan')->count();
        $lengkap        = (clone $base)->where('pendaftaran_lengkap', true)->count();

        $rptkaBase     = rptka::query();
        if ($kabkota) $rptkaBase->where('kabupaten_kota', $kabkota);
        $totalRptka    = (clone $rptkaBase)->count();
        $rptkaMenunggu = (clone $rptkaBase)->where('status_permohonan', 'Menunggu')->count();
        $rptkaDiterima = (clone $rptkaBase)->where('status_permohonan', 'Diterima')->count();

        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $q = LKS::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month);
            if ($kabkota) $q->where('kabupaten_kota', $kabkota);
            $monthlyTrend[$month->translatedFormat('M Y')] = $q->count();
        }

        $statusData = (clone $base)->select('status_permohonan', DB::raw('COUNT(*) as total'))
            ->groupBy('status_permohonan')->get()
            ->pluck('total', 'status_permohonan')->toArray();

        $recentLKS   = (clone $base)->with('user')->latest()->take(10)->get();
        $recentRptka = (clone $rptkaBase)->with('user')->latest()->take(5)->get();

        return view('dashboard.admin', compact(
            'kabkota', 'totalLKS', 'menunggu', 'diterimaProses', 'diterima',
            'terverifikasi', 'ditolak', 'dikembalikan', 'lengkap',
            'totalRptka', 'rptkaMenunggu', 'rptkaDiterima',
            'monthlyTrend', 'statusData', 'recentLKS', 'recentRptka'
        ));
    }

    // ===================== USER DASHBOARD =====================
    private function userDashboard($user)
    {
        $userId = $user->id;

        $myLks        = LKS::where('user_id', $userId)->latest()->get();
        $totalLks     = $myLks->count();
        $menunggu     = $myLks->where('status_permohonan', 'Menunggu')->count();
        $diterima     = $myLks->whereIn('status_permohonan', ['Diterima', 'Terverifikasi'])->count();
        $ditolak      = $myLks->where('status_permohonan', 'Ditolak')->count();
        $dikembalikan = $myLks->where('status_permohonan', 'Dikembalikan')->count();

        // LKS yang perlu perhatian (Ditolak atau Dikembalikan) — untuk badge sidebar
        $perluPerhatian = $myLks->whereIn('status_permohonan', ['Ditolak', 'Dikembalikan'])->count();

        // LKS dengan status terbaru yang berubah — untuk section "Status Terkini"
        $statusTerkini = LKS::where('user_id', $userId)
            ->whereIn('status_permohonan', ['Diterima untuk proses', 'Diterima', 'Terverifikasi', 'Ditolak', 'Dikembalikan'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $myRptka       = rptka::where('user_id', $userId)->latest()->get();
        $totalRptka    = $myRptka->count();
        $rptkaMenunggu = $myRptka->where('status_permohonan', 'Menunggu')->count();
        $rptkaDiterima = $myRptka->whereIn('status_permohonan', ['Diterima', 'Terverifikasi'])->count();

        // RPTKA yang ditolak/dikembalikan
        $rptkaPerluPerhatian = $myRptka->whereIn('status_permohonan', ['Ditolak', 'Dikembalikan'])->count();
        $rptkaStatusTerkini  = rptka::where('user_id', $userId)
            ->whereIn('status_permohonan', ['Diterima', 'Terverifikasi', 'Ditolak', 'Dikembalikan'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $recentRptka = rptka::where('user_id', $userId)->latest()->take(5)->get();

        return view('dashboard.user', compact(
            'totalLks', 'menunggu', 'diterima', 'ditolak', 'dikembalikan',
            'totalRptka', 'rptkaMenunggu', 'rptkaDiterima',
            'recentRptka', 'perluPerhatian', 'statusTerkini',
            'rptkaPerluPerhatian', 'rptkaStatusTerkini',
            'myLks'
        ));
    }

    // ===================== SUPER ADMIN DASHBOARD =====================
    private function superAdminDashboard()
    {
        $totalLKS   = LKS::count();
        $lengkapLKS = LKS::where('pendaftaran_lengkap', true)->count();
        $menungguLKS = LKS::where('status_permohonan', 'Menunggu')->count();
        $diterimaLKS = LKS::where('status_permohonan', 'Diterima')->count();

        $kewenanganKabkota = KewenanganKabkota::count();
        $kewenanganProvinsi = KewenanganProvinsi::count();
        $kewenanganKemensos = KewenanganKemensos::count();
        $totalLKSJabar = $kewenanganKabkota + $kewenanganProvinsi + $kewenanganKemensos;

        $kewenanganChartData = [
            'labels'      => ['Kabupaten/Kota', 'Provinsi', 'Kemensos'],
            'data'        => [$kewenanganKabkota, $kewenanganProvinsi, $kewenanganKemensos],
            'colors'      => ['#4e73df', '#1cc88a', '#36b9cc'],
            'total'       => $totalLKSJabar,
            'percentages' => $totalLKSJabar > 0 ? [
                round(($kewenanganKabkota / $totalLKSJabar) * 100, 1),
                round(($kewenanganProvinsi / $totalLKSJabar) * 100, 1),
                round(($kewenanganKemensos / $totalLKSJabar) * 100, 1),
            ] : [0, 0, 0],
        ];

        $semuaKabupaten = [
            'Kabupaten Bogor', 'Kabupaten Sukabumi', 'Kabupaten Cianjur', 'Kabupaten Bandung',
            'Kabupaten Garut', 'Kabupaten Tasikmalaya', 'Kabupaten Ciamis', 'Kabupaten Kuningan',
            'Kabupaten Cirebon', 'Kabupaten Majalengka', 'Kabupaten Sumedang', 'Kabupaten Indramayu',
            'Kabupaten Subang', 'Kabupaten Purwakarta', 'Kabupaten Karawang', 'Kabupaten Bekasi',
            'Kabupaten Bandung Barat', 'Kabupaten Pangandaran', 'Kota Bogor', 'Kota Sukabumi',
            'Kota Bandung', 'Kota Cirebon', 'Kota Bekasi', 'Kota Depok', 'Kota Cimahi',
            'Kota Tasikmalaya', 'Kota Banjar',
        ];

        $kabkotaData  = $this->getKabupatenDataFromKewenangan(KewenanganKabkota::class, 'Kabupaten_kota');
        $provinsiData = $this->getKabupatenDataFromKewenangan(KewenanganProvinsi::class, 'kabupaten_kota');
        $kemensosData = $this->getKabupatenDataFromKewenangan(KewenanganKemensos::class, 'kabupaten_kota');

        $kabupatenData = [];
        foreach ($semuaKabupaten as $kab) {
            $kabupatenData[$kab] = ($kabkotaData[$kab] ?? 0) + ($provinsiData[$kab] ?? 0) + ($kemensosData[$kab] ?? 0);
        }
        arsort($kabupatenData);

        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyTrend[$month->translatedFormat('M Y')] = LKS::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)->count();
        }

        $statusData = LKS::select('status_permohonan', DB::raw('COUNT(*) as total'))
            ->groupBy('status_permohonan')->get()->pluck('total', 'status_permohonan')->toArray();

        $recentLKS = LKS::with(['checklists.document'])->latest()->take(5)->get();
        $recentLKS->each(fn($lks) => $lks->status_badge = $this->getStatusBadge($lks->status_permohonan));

        $latestLks = LKS::latest()->first();

        return view('dashboard.dashboard', compact(
            'totalLKS', 'lengkapLKS', 'menungguLKS', 'diterimaLKS',
            'kabupatenData', 'monthlyTrend', 'statusData', 'recentLKS',
            'kewenanganChartData', 'kewenanganKabkota', 'kewenanganProvinsi',
            'kewenanganKemensos', 'totalLKSJabar', 'latestLks'
        ));
    }

    private function getKabupatenDataFromKewenangan($model, $columnName)
    {
        return $model::select($columnName, DB::raw('COUNT(*) as total'))
            ->whereNotNull($columnName)->where($columnName, '!=', '')
            ->groupBy($columnName)->get()
            ->mapWithKeys(fn($item) => [$this->normalizeKabupatenName($item->$columnName) => $item->total])
            ->toArray();
    }

    private function normalizeKabupatenName($name)
    {
        $name = str_replace(['KAB.', 'KOTA.', 'KAB ', 'KOTA '], ['Kabupaten', 'Kota', 'Kabupaten ', 'Kota '], $name);
        if (str_starts_with($name, 'Kabupaten')) return 'Kabupaten ' . trim(str_replace('Kabupaten', '', $name));
        if (str_starts_with($name, 'Kota')) return 'Kota ' . trim(str_replace('Kota', '', $name));
        return trim($name);
    }

    private function getStatusBadge($status)
    {
        return match($status) {
            'Diterima'          => 'bg-success',
            'Ditolak'           => 'bg-danger',
            'Proses Verifikasi' => 'bg-warning',
            default             => 'bg-secondary',
        };
    }
}
