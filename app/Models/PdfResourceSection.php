<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PdfResourceSection extends Model
{
    protected $fillable = [
        'pdf_resource_id',
        'heading',
        'text',
        'image_url',
        'image_caption',
        'teacher_note',
        'order',
    ];

    /**
     * Ana kaynak ilişkisi
     */
    public function pdfResource(): BelongsTo
    {
        return $this->belongsTo(PdfResource::class);
    }
}
