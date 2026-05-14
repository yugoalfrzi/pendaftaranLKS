<?php
// app/Models/RptkaApplication.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rptka extends Model
{
    use HasFactory;

    protected $table = 'rptka';

    protected $fillable = [
        'user_id',
        'nama_lks',
        'nama_tka_pemohon',
        'alamat_lks',
        'kabupaten_kota',
        'permohonan_rptka',
        'tanggal_masuk_dokumen',
        'tanggal_persyaratan_lengkap',
        'status_permohonan',
        'surat_rekomendasi_rptka_path',
        'alasan_penolakan',
        'alasan_dikembalikan',
        'nama_verifikator',
        'surat_rekomendasi_rptka_final_path',
        'nama_verifikator_superadmin',
    ];

    protected $casts = [
        'tanggal_masuk_dokumen' => 'date',
        'tanggal_persyaratan_lengkap' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status_permohonan) {
            'Menunggu'      => 'bg-warning text-dark',
            'Terekomendasi' => 'bg-primary',
            'Disetujui'     => 'bg-success',
            'Ditolak'       => 'bg-danger',
            'Dikembalikan'  => 'bg-info text-dark',
            default         => 'bg-secondary',
        };
    }

    // Relationship ke status dokumen (pivot)
    public function documentStatuses()
    {
        return $this->hasMany(RptkaDocumentStatus::class, 'rptka_id');
    }

    // Relationship ke master documents melalui pivot
    public function documents()
    {
        return $this->belongsToMany(MasterDocument::class, 'rptka_document_status')
                    ->using(RptkaDocumentStatus::class)
                    ->withPivot('is_ada', 'keterangan', 'file_path')
                    ->withTimestamps()
                    ->orderBy('urutan');
    }

    // Mendapatkan dokumen yang wajib berdasarkan jenis permohonan
    public function getRequiredDocuments()
    {
        $query = MasterDocument::where('wajib', true);

        if ($this->permohonan_rptka === 'Baru') {
            $query->where('kategori', 'utama');
        } else {
            // Untuk perpanjangan: semua dokumen utama + perpanjangan
            $query->whereIn('kategori', ['utama', 'perpanjangan']);
        }

        return $query->orderBy('urutan')->get();
    }

    // Mendapatkan ID dokumen yang wajib
    public function getRequiredDocumentIds()
    {
        return $this->getRequiredDocuments()->pluck('id')->toArray();
    }

    // Cek kelengkapan semua dokumen wajib
    public function isComplete()
    {
        $requiredDocIds = $this->getRequiredDocumentIds();

        if (empty($requiredDocIds)) {
            return false;
        }

        $completedDocs = $this->documentStatuses()
            ->whereIn('master_document_id', $requiredDocIds)
            ->where('is_ada', true)
            ->count();

        return $completedDocs === count($requiredDocIds);
    }

    // Hitung persentase kelengkapan
    public function completionPercentage()
    {
        $requiredDocs = $this->getRequiredDocuments();
        $totalDocs = $requiredDocs->count();

        if ($totalDocs === 0) return 0;

        $completedDocs = $this->documentStatuses()
            ->whereIn('master_document_id', $requiredDocs->pluck('id'))
            ->where('is_ada', true)
            ->count();

        return round(($completedDocs / $totalDocs) * 100, 2);
    }

    // Update tanggal lengkap otomatis
    public function updateCompletionDate()
    {
        if ($this->isComplete() && is_null($this->tanggal_persyaratan_lengkap)) {
            $this->update([
                'tanggal_persyaratan_lengkap' => now()
            ]);
        } elseif (!$this->isComplete() && !is_null($this->tanggal_persyaratan_lengkap)) {
            $this->update([
                'tanggal_persyaratan_lengkap' => null
            ]);
        }
    }

    // Inisialisasi status dokumen untuk aplikasi baru
    public function initializeDocumentStatuses()
    {
        $requiredDocs = $this->getRequiredDocuments();

        foreach ($requiredDocs as $doc) {
            RptkaDocumentStatus::firstOrCreate([
                'rptka_id' => $this->id,
                'master_document_id' => $doc->id,
            ], [
                'is_ada' => false,
            ]);
        }
    }

    // Scope untuk aplikasi yang lengkap
    public function scopeComplete($query)
    {
        return $query->whereNotNull('tanggal_persyaratan_lengkap');
    }

    // Scope untuk aplikasi yang belum lengkap
    public function scopeIncomplete($query)
    {
        return $query->whereNull('tanggal_persyaratan_lengkap');
    }

    // Scope berdasarkan jenis permohonan
    public function scopePermohonanBaru($query)
    {
        return $query->where('permohonan_rptka', 'Baru');
    }

    public function scopePermohonanUlang($query)
    {
        return $query->where('permohonan_rptka', 'Ulang');
    }
}
