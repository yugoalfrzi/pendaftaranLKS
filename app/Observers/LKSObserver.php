<?php

namespace App\Observers;

use App\Models\LKS;
use App\Services\GoogleSheetService;
use App\Jobs\SyncLKSToGoogleSheets;
use Illuminate\Support\Facades\Log;

class LKSObserver
{
    protected $googleSheetService;

    public function __construct(GoogleSheetService $googleSheetService)
    {
        $this->googleSheetService = $googleSheetService;
    }

    /**
     * Handle the LKS "updated" event.
     */
    public function updated(LKS $lks)
    {
        // Check if status_permohonan was changed to "Diterima untuk proses"
        if ($lks->wasChanged('status_permohonan') && 
            $lks->status_permohonan === 'Diterima untuk proses') {
            
            // Dispatch job for background processing
            SyncLKSToGoogleSheets::dispatch($lks);
        }
    }

    /**
     * Handle the LKS "created" event.
     */
    public function created(LKS $lks)
    {
        // Only sync if status is already "Diterima untuk proses" on creation
        if ($lks->status_permohonan === 'Diterima untuk proses') {
            // Dispatch job for background processing
            SyncLKSToGoogleSheets::dispatch($lks);
        }
    }

    /**
     * Sync LKS data to Google Sheets
     */
    private function syncToGoogleSheets(LKS $lks)
    {
        try {
            // Prepare data for Google Sheets
            $data = [
                $lks->id,
                $lks->nama_lks,
                $lks->alamat_lks,
                $lks->nama_ketua_lks,
                $lks->jenis_pelayanan,
                $lks->jumlah_binaan_dalam_panti,
                $lks->jumlah_binaan_luar_panti,
                $lks->kabupaten_kota ?? $lks->lokasi_lks,
                $lks->pusat_lks,
                $lks->cabang_lks,
                $lks->nomor_kontak,
                $lks->tanda_pendaftaran,
                $lks->tanggal_masuk_dokumen?->format('Y-m-d'),
                $lks->tanggal_persyaratan?->format('Y-m-d'),
                $lks->pendaftaran_lengkap ? 'Ya' : 'Tidak',
                $lks->status_permohonan,
                $lks->nama_verifikator,
                $lks->verifikator_id,
                $lks->created_at?->format('Y-m-d H:i:s'),
                $lks->updated_at?->format('Y-m-d H:i:s'),
            ];

            // Append data to Google Sheets
            $this->googleSheetService->appendData($data, 'Sheet1!A:Z');
            
            Log::info("LKS data synced to Google Sheets successfully", [
                'lks_id' => $lks->id,
                'nama_lks' => $lks->nama_lks,
                'status' => $lks->status_permohonan
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to sync LKS data to Google Sheets", [
                'lks_id' => $lks->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
