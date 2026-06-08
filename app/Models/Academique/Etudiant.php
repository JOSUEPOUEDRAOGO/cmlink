<?php

namespace App\Models\Academique;

use App\Models\Recrutement\Candidature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'cv_path',
        'lettre_motivation',
        'cv_public',
        'lettre_public',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function getNomCompletAttribute(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    // Relation avec la table etudiant_cvs
    public function cvs()
    {
        return $this->hasMany(\App\Models\Recrutement\EtudiantCv::class);
    }

    // Relation avec la table lettre_motivations (nom correct pour l'appel)
    public function lettres()
    {
        return $this->hasMany(\App\Models\Recrutement\LettreMotivation::class);
    }

    // Récupérer le CV principal
    public function getCvPrincipalAttribute()
    {
        return $this->cvs()->where('principal', true)->first()
               ?? $this->cvs()->latest()->first();
    }

    // Récupérer la dernière lettre
    public function getDerniereLettreAttribute()
    {
        return $this->lettres()->latest()->first();
    }
}
