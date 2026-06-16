<?php

namespace App\Models\Entreprise; // ← corriger ici

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Entreprise\Entreprise;
use App\Models\Referentiel\Categorie;
use App\Models\Recrutement\Candidature;
use App\Models\Competence;
use App\Models\Favori;

class Offre extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'type',
        'entreprise_id',
        'categorie_id',
        'localisation',
        'date_expiration',
        'salaire_min',
        'salaire_max',
        'niveau_experience',
        'teletravail',
        'nb_postes',
    ];

    protected $casts = [
        'date_expiration' => 'date',
        'teletravail'     => 'boolean',
    ];

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class);
    }

    public function competences(): BelongsToMany
    {
        return $this->belongsToMany(Competence::class, 'offre_competence')
                    ->withPivot('niveau_requis', 'obligatoire')
                    ->withTimestamps();
    }

    public function favoris(): HasMany
    {
        return $this->hasMany(Favori::class);
    }

    // Scope offres non expirées
    public function scopeActives($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('date_expiration')
              ->orWhere('date_expiration', '>=', now());
        });
    }
}
