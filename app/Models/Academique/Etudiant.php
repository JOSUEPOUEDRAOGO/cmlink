<?php

namespace App\Models\Academique;

use App\Models\Competence;
use App\Models\Favori;
use App\Models\Entreprise\Offre;
use App\Models\Recrutement\Candidature;
use App\Models\Recrutement\EtudiantCv;
use App\Models\Recrutement\LettreMotivation;
use App\Models\User;
use App\Models\Academique\Filiere;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'email',
        'telephone',
        'filiere_id',
        'cv_public',
        'lettre_public',
        'date_naissance',
        'ville',
        'disponible_le',
        'niveau_etudes',
        'cv_path',
        'lettre_motivation',
         'photo_publique',
    ];

    protected $casts = [
        'cv_public'      => 'boolean',
        'lettre_public'  => 'boolean',
        'date_naissance' => 'date',
        'disponible_le'  => 'date',
         'photo_publique' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class);
    }

    public function competences(): BelongsToMany
    {
        return $this->belongsToMany(Competence::class, 'etudiant_competence')
                    ->withPivot('niveau')
                    ->withTimestamps();
    }

    public function favoris(): HasMany
    {
        return $this->hasMany(Favori::class);
    }

    public function offresFavorites(): BelongsToMany
    {
        return $this->belongsToMany(Offre::class, 'favoris')
                    ->withTimestamps();
    }

    public function getNomCompletAttribute(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    // Relation avec la table etudiant_cvs
    public function cvs(): HasMany
    {
        return $this->hasMany(EtudiantCv::class);
    }

    public function cvPrincipal(): HasOne
    {
        return $this->hasOne(EtudiantCv::class)->where('principal', true);
    }

    // Relation avec la table lettre_motivations (nom correct pour l'appel)
    public function lettres(): HasMany
    {
        return $this->hasMany(LettreMotivation::class);
    }

    public function derniereLettre(): HasOne
    {
        return $this->hasOne(LettreMotivation::class)->latestOfMany();
    }

    // Récupérer le CV principal
    public function getCvPrincipalAttribute()
    {
        return $this->cvPrincipal()->first()
               ?? $this->cvs()->latest()->first();
    }

    // Récupérer la dernière lettre
    public function getDerniereLettreAttribute()
    {
        return $this->derniereLettre()->first();
    }
}
