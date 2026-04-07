<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_dokumen',
        'deskripsi',
        'wajib',
        'urutan'
    ];

    protected $casts = [
        'wajib' => 'boolean',
    ];

    /**
     * Get the checklists for this document
     */
    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    /**
     * Get the LKS through checklists
     */
    public function lks()
    {
        return $this->belongsToMany(LKS::class, 'checklists')
                    ->withPivot('kelengkapan', 'keterangan')
                    ->withTimestamps();
    }

    /**
     * Scope to get only required documents
     */
    public function scopeWajib($query)
    {
        return $query->where('wajib', true);
    }

    /**
     * Scope to order by urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}
