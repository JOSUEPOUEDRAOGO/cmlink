<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    /**
     * Table associée (optionnel si nom standard)
     */
    protected $table = 'page_sections';

    /**
     * Champs autorisés en mass assignment
     */
    protected $fillable = [
        'page',
        'section',
        'key',
        'value',
        'is_active',
    ];

    /**
     * Casts (types automatiques)
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scopes utiles
     */

    // Récupérer une page
    public function scopePage($query, $page)
    {
        return $query->where('page', $page);
    }

    // Récupérer une section
    public function scopeSection($query, $section)
    {
        return $query->where('section', $section);
    }

    // Actifs seulement
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Helper : récupérer tout le contenu d'une page formaté
     */
    public static function getPageContent($page)
    {
        return self::where('page', $page)
            ->where('is_active', true)
            ->get()
            ->groupBy('section')
            ->map(function ($items) {
                return $items->pluck('value', 'key');
            });
    }

    /**
     * Helper : récupérer une valeur précise
     */
    public static function get($page, $section, $key, $default = null)
    {
        return self::where([
                'page' => $page,
                'section' => $section,
                'key' => $key,
            ])
            ->where('is_active', true)
            ->value('value') ?? $default;
    }
}
