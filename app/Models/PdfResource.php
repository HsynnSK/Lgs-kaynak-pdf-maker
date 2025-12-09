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
        'theme',
    ];

    // Mevcut tema renklerini config'den al ve döndür
    public function getThemeColors(): array
    {
        $themes = config('pdf-themes.themes');
        $themeKey = $this->theme ?? config('pdf-themes.default', 'blue');
        
        return $themes[$themeKey] ?? $themes['blue'];
    }

    // Tüm mevcut temaları döndür (dropdown için kullanışlı)
    public static function getAvailableThemes(): array
    {
        return config('pdf-themes.themes', []);
    }

    // Kaynak bölümleri ilişkisi (sıralı)
    public function sections(): HasMany
    {
        return $this->hasMany(PdfResourceSection::class)->orderBy('order');
    }
}
