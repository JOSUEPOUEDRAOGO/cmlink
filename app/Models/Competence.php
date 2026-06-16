<?php

namespace App\Models;

use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Offre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Competence extends Model
{
    protected $fillable = ['nom', 'categorie'];

    public function etudiants(): BelongsToMany
    {
        return $this->belongsToMany(Etudiant::class, 'etudiant_competence')
                    ->withPivot('niveau')
                    ->withTimestamps();
    }

    public function offres(): BelongsToMany
    {
        return $this->belongsToMany(Offre::class, 'offre_competence')
                    ->withPivot('niveau_requis', 'obligatoire')
                    ->withTimestamps();
    }
}
