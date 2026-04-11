<?php

namespace App\Models\Recrutement;

use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Offre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'offre_id',
        'statut',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }
}
