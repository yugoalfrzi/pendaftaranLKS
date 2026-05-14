<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;  

class LKS extends Model
{
    use HasFactory;

    protected $table = 'lks';
    
    protected $fillable = [
        'nama_lks',
        'alamat_lks',
        'nama_ketua_lks',
        'jenis_pelayanan',
        'jumlah_binaan_dalam_panti',
        'jumlah_binaan_luar_panti',
        'lokasi_lks',
        'pusat_lks',
        'cabang_lks',
        'nomor_kontak',
        'tanda_pendaftaran',
        'tanggal_masuk_dokumen',
        'tanggal_persyaratan',
        'pendaftaran_lengkap',
        'status_permohonan',
        'verifikator_id',
        'nama_verifikator',
        'alasan_penolakan',
        'alasan_dikembalikan',
        'kabupaten_kota',
        'sertifikat_path',
        'surat_rekomendasi_path',
        'sertifikat_kabkota_path',
        'user_id',
        'kewenangan_type',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_masuk_dokumen' => 'date',
        'tanggal_persyaratan' => 'date',
        'pendaftaran_lengkap' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the checklists for this LKS
     */
    public function checklists()
    {
        return $this->hasMany(Checklist::class, 'lks_id');
    }

    /**
     * Get the documents through checklists
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'checklists')
                    ->withPivot('kelengkapan', 'keterangan')
                    ->withTimestamps();
    }

    /**
     * Check if all required documents are complete (ada + file diupload)
     */
    public function isComplete()
    {
        $requiredDocuments = Document::where('wajib', true)->count();

        if ($requiredDocuments === 0) {
            return false;
        }

        // Cek semua field wajib LKS terisi
        $requiredFields = [
            'nama_lks', 'alamat_lks', 'nama_ketua_lks', 'jenis_pelayanan',
            'jumlah_binaan_dalam_panti', 'jumlah_binaan_luar_panti',
            'nomor_kontak', 'lokasi_lks', 'tanda_pendaftaran',
            'tanggal_masuk_dokumen', 'tanggal_persyaratan',
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field) && $this->$field !== 0) {
                return false;
            }
        }

        // Cek semua dokumen wajib: kelengkapan = 'Ada' DAN file sudah diupload
        $completedDocuments = $this->checklists()
            ->whereHas('document', function ($query) {
                $query->where('wajib', true);
            })
            ->where('kelengkapan', 'Ada')
            ->where('file_count', '>', 0)
            ->count();

        return $requiredDocuments === $completedDocuments;
    }

    /**
     * Update pendaftaran_lengkap status
     */
    public function updatePendaftaranLengkap()
    {
        $this->update([
            'pendaftaran_lengkap' => $this->isComplete()
        ]);
        
        return $this->pendaftaran_lengkap;
    }

    /**
     * Get kabupaten/kota for this LKS (prioritize kabupaten_kota field)
     */
    public function getKabupatenAttribute()
    {
        return $this->kabupaten_kota ?: $this->lokasi_lks;
    }

    /**
     * Scope untuk filter by kabupaten/kota
     */
    public function scopeByKabupaten($query, $kabupaten)
    {
        return $query->where('kabupaten_kota', $kabupaten)
                    ->orWhere('lokasi_lks', $kabupaten)
                    ->orWhere('pusat_lks', $kabupaten)
                    ->orWhere('cabang_lks', 'like', "%{$kabupaten}%");
    }

    /**
     * Get status with color for display
     */
    public function getStatusColorAttribute()
    {
        return match($this->status_permohonan) {
            'Menunggu' => 'warning',
            'Menunggu kelengkapan data' => 'warning',
            'Terekomendasi' => 'primary',
            'Disetujui' => 'success',
            'Dikembalikan' => 'info',
            'Ditolak' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status_permohonan) {
            'Menunggu' => 'bg-warning',
            'Menunggu kelengkapan data' => 'bg-warning',
            'Terekomendasi' => 'bg-primary',
            'Disetujui' => 'bg-success',
            'Dikembalikan' => 'bg-info',
            'Ditolak' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_permohonan', $status);
    }

    /**
     * Scope for pending applications
     */
    public function scopePending($query)
    {
        return $query->where('status_permohonan', 'Menunggu');
    }

    /**
     * Scope for verified applications
     */
    public function scopeVerified($query)
    {
        return $query->where('status_permohonan', 'Terekomendasi')
                    ->orWhere('status_permohonan', 'Disetujui');
    }

    /**
     * Get the count of LKS by kabupaten/kota
     */
    public static function getKabupatenStats()
    {
        return self::select('kabupaten_kota', DB::raw('COUNT(*) as total'))
            ->whereNotNull('kabupaten_kota')
            ->where('kabupaten_kota', '!=', '')
            ->groupBy('kabupaten_kota')
            ->orderBy('total', 'desc')
            ->get()
            ->pluck('total', 'kabupaten_kota')
            ->toArray();
    }

    /**
     * Check if LKS has a certificate
     */
    public function hasSertifikat()
    {
        return !empty($this->sertifikat_path);
    }

    /**
     * Get certificate URL
     */
    public function getSertifikatUrlAttribute()
    {
        if ($this->hasSertifikat()) {
            return asset('storage/' . $this->sertifikat_path);
        }
        return null;
    }

    /**
     * Get certificate file name
     */
    public function getSertifikatFileNameAttribute()
    {
        if ($this->hasSertifikat()) {
            return pathinfo($this->sertifikat_path, PATHINFO_BASENAME);
        }
        return null;
    }

    /**
     * Scope for LKS with certificates
     */
    public function scopeWithSertifikat($query)
    {
        return $query->whereNotNull('sertifikat_path')
                    ->where('sertifikat_path', '!=', '');
    }

    /**
     * Scope for LKS without certificates
     */
    public function scopeWithoutSertifikat($query)
    {
        return $query->whereNull('sertifikat_path')
                    ->orWhere('sertifikat_path', '');
    }
}