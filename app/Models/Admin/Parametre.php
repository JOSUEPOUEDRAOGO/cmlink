<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $fillable = [
        'cle',
        'valeur',
        'groupe',
        'type',
        'label',
        'description',
        'options',
        'is_public',
        'is_locked',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_locked' => 'boolean',
    ];

    // Retourne la valeur castée selon le type
    public function getValeurCasteeAttribute(): mixed
    {
        return match($this->type) {
            'boolean' => $this->valeur === '1',
            'number'  => is_numeric($this->valeur) ? (int) $this->valeur : 0,
            'json'    => json_decode($this->valeur, true),
            default   => $this->valeur,
        };
    }

    // Options pour les selects
    public function getOptionsArrayAttribute(): array
    {
        if (!$this->options) return [];
        return json_decode($this->options, true) ?? [];
    }

    // Scope par groupe
    public function scopeGroupe($query, string $groupe)
    {
        return $query->where('groupe', $groupe);
    }

    // Scope non verrouillés
    public function scopeModifiable($query)
    {
        return $query->where('is_locked', false);
    }
}
