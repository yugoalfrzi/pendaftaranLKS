<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LKS;
use App\Services\GoogleSheetService;
use Illuminate\Support\Facades\Log;

class SyncAcceptedLKSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lks:sync-accepted {--force : Force sync all accepted LKS even if already synced}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all LKS with status "Diterima untuk proses" to Google Sheets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting sync of accepted LKS to Google Sheets...');
        
        $query = LKS::where('status_permohonan', 'Diterima untuk proses');
        
        if (!$this->option('force')) {
            // Only sync LKS that haven't been synced yet (you might add a synced_at column later)
            $query->whereNull('synced_to_google_sheets_at');
        }
        
        $lksList = $query->get();
        
        if ($lksList->isEmpty()) {
            $this->info('No LKS found with status "Diterima untuk proses" to sync.');
            return;
        }
        
        $this->info("Found {$lksList->count()} LKS to sync.");
        
        $bar = $this->output->createProgressBar($lksList->count());
        $bar->start();
        
        $synced = 0;
        $failed = 0;
        
        foreach ($lksList as $lks) {
            try {
                $this->syncLKS($lks);
                $synced++;
                
                // Mark as synced (you might add this column to the database)
                // $lks->update(['synced_to_google_sheets_at' => now()]);
                
            } catch (\Exception $e) {
                $failed++;
                $this->error("Failed to sync LKS ID {$lks->id}: " . $e->getMessage());
                Log::error("Failed to sync LKS via command", [
                    'lks_id' => $lks->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $this->info("Sync completed!");
        $this->info("Successfully synced: {$synced}");
        $this->info("Failed: {$failed}");
        
        if ($failed > 0) {
            $this->warn("Some LKS failed to sync. Check the logs for details.");
        }
    }
    
    /**
     * Sync single LKS to Google Sheets
     */
    private function syncLKS(LKS $lks)
    {
        $googleSheetService = new GoogleSheetService();
        
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
        $googleSheetService->appendData($data, 'Sheet1!A:Z');
        
        Log::info("LKS data synced to Google Sheets via command", [
            'lks_id' => $lks->id,
            'nama_lks' => $lks->nama_lks,
            'status' => $lks->status_permohonan
        ]);
    }
}
