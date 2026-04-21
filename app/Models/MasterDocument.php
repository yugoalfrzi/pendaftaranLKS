<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDocument extends Model
{
    use HasFactory;

    protected $table = 'master_documents';

    protected $fillable = [
        'nama_dokumen',
        'deskripsi',
        'wajib',
        'kategori',
        'urutan',
    ];

    protected $casts = [
        'wajib' => 'boolean',
    ];

    // Relationship ke tabel pivot status
    public function documentStatuses()
    {
        return $this->hasMany(RptkaDocumentStatus::class, 'master_document_id');
    }

    // Scope untuk dokumen utama
    public function scopeUtama($query)
    {
        return $query->where('kategori', 'utama')->orderBy('urutan');
    }

    // Scope untuk dokumen perpanjangan
    public function scopePerpanjangan($query)
    {
        return $query->where('kategori', 'perpanjangan')->orderBy('urutan');
    }

    // Scope untuk dokumen wajib
    public function scopeWajib($query)
    {
        return $query->where('wajib', true);
    }

    // Scope untuk dokumen berdasarkan urutan
    public function scopeUrut($query)
    {
        return $query->orderBy('urutan');
    }
}
