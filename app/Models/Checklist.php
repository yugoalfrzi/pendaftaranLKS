<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'lks_id', 'document_id', 'kelengkapan', 'keterangan',
        'file_paths', 'original_filenames', 'file_count'
    ];

    protected $casts = [
        'file_paths' => 'array',
        'original_filenames' => 'array',
    ];

    public function lks()
    {
        return $this->belongsTo(LKS::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    // Accessor untuk mendapatkan semua file URLs
    public function getFileUrlsAttribute()
    {
        if (empty($this->file_paths)) {
            return [];
        }

        $urls = [];
        foreach ($this->file_paths as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                $urls[] = Storage::disk('public')->url($path);
            }
        }
        return $urls;
    }

    // Method untuk mendapatkan informasi lengkap semua files
    public function getFilesInfo()
    {
        $files = [];
        
        if (!empty($this->file_paths) && !empty($this->original_filenames)) {
            foreach ($this->file_paths as $index => $path) {
                if (isset($this->original_filenames[$index])) {
                    $files[] = [
                        'path' => $path,
                        'name' => $this->original_filenames[$index],
                        'url' => Storage::disk('public')->exists($path) ? Storage::disk('public')->url($path) : null,
                        'index' => $index
                    ];
                }
            }
        }
        
        return $files;
    }

    public function getHasFilesAttribute()
    {
        return !empty($this->file_paths) && $this->file_count > 0;
    }

    // Method untuk mendapatkan file pertama (backward compatibility)
    public function getFirstFile()
    {
        $files = $this->getFilesInfo();
        return !empty($files) ? $files[0] : null;
    }
}