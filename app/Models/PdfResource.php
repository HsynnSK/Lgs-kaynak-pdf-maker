<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PdfResource extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'subject',
        'level',
    ];

    /**
     * Kaynak bölümleri ilişkisi
     */
    public function sections(): HasMany
    {
        return $this->hasMany(PdfResourceSection::class)->orderBy('order');
    }
}
