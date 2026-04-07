<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\LKS;
use App\Services\GoogleSheetService;
use Illuminate\Support\Facades\Log;

class SyncLKSToGoogleSheets implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    protected $lks;

    /**
     * Create a new job instance.
     */
    public function __construct(LKS $lks)
    {
        $this->lks = $lks;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $googleSheetService = new GoogleSheetService();
            
            // Prepare data for Google Sheets
            $data = [
                $this->lks->id,
                $this->lks->nama_lks,
                $this->lks->alamat_lks,
                $this->lks->nama_ketua_lks,
                $this->lks->jenis_pelayanan,
                $this->lks->jumlah_binaan_dalam_panti,
                $this->lks->jumlah_binaan_luar_panti,
                $this->lks->kabupaten_kota ?? $this->lks->lokasi_lks,
                $this->lks->pusat_lks,
                $this->lks->cabang_lks,
                $this->lks->nomor_kontak,
                $this->lks->tanda_pendaftaran,
                $this->lks->tanggal_masuk_dokumen?->format('Y-m-d'),
                $this->lks->tanggal_persyaratan?->format('Y-m-d'),
                $this->lks->pendaftaran_lengkap ? 'Ya' : 'Tidak',
                $this->lks->status_permohonan,
                $this->lks->nama_verifikator,
                $this->lks->verifikator_id,
                $this->lks->created_at?->format('Y-m-d H:i:s'),
                $this->lks->updated_at?->format('Y-m-d H:i:s'),
            ];

            // Append data to Google Sheets
            $googleSheetService->appendData($data, 'Sheet1!A:Z');
            
            Log::info("LKS data synced to Google Sheets via job", [
                'lks_id' => $this->lks->id,
                'nama_lks' => $this->lks->nama_lks,
                'status' => $this->lks->status_permohonan
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to sync LKS data to Google Sheets via job", [
                'lks_id' => $this->lks->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw the exception to mark the job as failed
            throw $e;
        }
    }
}
