<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HibahLks extends Model
{
    use HasFactory;

    protected $table = 'hibah_lks';

    protected $fillable = [
        'nama_lks',
        'tahun',
        'proposal_path',
        'hasil_verifikasi_path',
        'pergub_penjabaran_apbd_path',
        'dpa_path',
        'hasil_identifikasi_path',
        'data_penerima_hibah_path',
        'spm_path',
        'sp2d_path',
        'lpj_path',
        'petunjuk_teknis_path'
    ];

    protected $casts = [
        'tahun' => 'integer'
    ];

    /**
     * Scope untuk data berdasarkan tahun
     */
    public function scopeTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    /**
     * Get data untuk tahun sebelumnya
     */
    public function getDataTahunSebelumnyaAttribute()
    {
        return self::where('nama_lks', $this->nama_lks)
            ->where('tahun', $this->tahun - 1)
            ->first();
    }

    /**
     * Check if document exists for current year
     */
    public function hasDocument($documentType)
    {
        $field = $documentType . '_path';
        return !empty($this->$field);
    }

    /**
     * Get document progress percentage for current year
     */
    public function getDocumentProgressAttribute()
    {
        $docFields = [
            'proposal_path',
            'hasil_verifikasi_path',
            'pergub_penjabaran_apbd_path',
            'dpa_path',
            'hasil_identifikasi_path',
            'data_penerima_hibah_path',
            'spm_path',
            'sp2d_path',
            'lpj_path',
            'petunjuk_teknis_path'
        ];

        $uploaded = 0;
        foreach ($docFields as $field) {
            if (!empty($this->$field)) {
                $uploaded++;
            }
        }

        return ($uploaded / count($docFields)) * 100;
    }

    /**
     * Get progress status
     */
    public function getProgressStatusAttribute()
    {
        $progress = $this->document_progress;

        if ($progress == 100) {
            return ['class' => 'success', 'text' => 'Lengkap'];
        } elseif ($progress >= 50) {
            return ['class' => 'warning', 'text' => 'Sebagian'];
        } else {
            return ['class' => 'danger', 'text' => 'Minimal'];
        }
    }
}