<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RptkaDocumentStatus extends Model
{
    protected $table = 'rptka_document_status';

    protected $fillable = [
        'rptka_id',
        'master_document_id',
        'is_ada',
        'keterangan',
        'file_path',
    ];

    protected $casts = [
        'is_ada' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(Rptka::class, 'rptka_id');
    }

    public function masterDocument()
    {
        return $this->belongsTo(MasterDocument::class, 'master_document_id');
    }

    public function getStatusTextAttribute()
    {
        return $this->is_ada ? 'Lengkap' : 'Belum Lengkap';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_ada
            ? '<span class="badge bg-success">Lengkap</span>'
            : '<span class="badge bg-danger">Belum Lengkap</span>';
    }
}
