<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'announcement_type',
        'category',
        'format',
        'icon',
        'download_count',
        'year',
        'last_updated',
        'type',
        'date',
        'is_active'
    ];

    protected $casts = [
        'last_updated' => 'date',
        'date' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Get the icon class based on file type
     */
    public function getIconAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return $this->getFileIcon($this->file_type);
    }

    /**
     * Determine file icon based on file type
     */
    private function getFileIcon($fileType)
    {
        $icons = [
            'pdf' => 'bi-file-earmark-pdf',
            'doc' => 'bi-file-earmark-word',
            'docx' => 'bi-file-earmark-word',
            'ppt' => 'bi-file-earmark-ppt',
            'pptx' => 'bi-file-earmark-ppt',
        ];

        return $icons[$fileType] ?? 'bi-file-earmark';
    }

    /**
     * Get icon color based on announcement type
     */
    public function getIconColor()
    {
        $colors = [
            'panduan' => 'text-success',
            'regulasi' => 'text-primary', 
            'surat' => 'text-warning'
        ];

        return $colors[$this->announcement_type] ?? 'text-secondary';
    }

    /**
     * Get badge color based on announcement type
     */
    public function getBadgeColor()
    {
        $colors = [
            'panduan' => 'success',
            'regulasi' => 'primary', 
            'surat' => 'warning'
        ];

        return $colors[$this->announcement_type] ?? 'secondary';
    }

    /**
     * Get background color based on announcement type
     */
    public function getBackgroundColor()
    {
        $colors = [
            'panduan' => 'success',
            'regulasi' => 'primary', 
            'surat' => 'warning'
        ];

        return $colors[$this->announcement_type] ?? 'secondary';
    }

    /**
     * Get route for download
     */
    public function getDownloadRoute()
    {
        return route('announcements.download', [
            'type' => $this->announcement_type,
            'filename' => $this->file_name
        ]);
    }

    /**
     * Get route for preview
     */
    public function getPreviewRoute()
    {
        return route('announcements.preview', [
            'type' => $this->announcement_type,
            'filename' => $this->file_name
        ]);
    }

    /**
     * Check if file is previewable (PDF only)
     */
    public function isPreviewable()
    {
        return $this->file_type === 'pdf';
    }

    /**
     * Scope active announcements
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by announcement type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('announcement_type', $type);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope popular (high download count)
     */
    public function scopePopular($query, $limit = 5)
    {
        return $query->orderBy('download_count', 'desc')->limit($limit);
    }

    /**
     * Scope recent
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount()
    {
        $this->download_count++;
        $this->save();
    }

    /**
     * Get human readable file size
     */
    public function getFormattedFileSize()
    {
        return $this->file_size;
    }

    /**
     * Get display date based on type
     */
    public function getDisplayDate()
    {
        return match($this->announcement_type) {
            'regulasi' => $this->year ?: $this->created_at->format('Y'),
            'surat' => $this->date?->format('d F Y') ?? $this->created_at->format('d F Y'),
            default => $this->last_updated?->format('d F Y') ?? $this->created_at->format('d F Y')
        };
    }
}