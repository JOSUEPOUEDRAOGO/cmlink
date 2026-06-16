<?php

namespace App\Models\Recrutement;

use App\Models\Academique\Etudiant;
use App\Models\Entretien;
use App\Models\Entreprise\Offre;
use App\Models\Recrutement\LettreMotivation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'offre_id',
        'statut',
        'lettre_motivation_id',

        // 🔥 nouveaux champs
        'nom',
        'email',
        'telephone',
        'message',
        'cv_path',
    ];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function offre(): BelongsTo
    {
        return $this->belongsTo(Offre::class);
    }

    public function lettre(): BelongsTo
    {
        return $this->belongsTo(LettreMotivation::class, 'lettre_motivation_id');
    }

    public function entretien(): HasOne
    {
        return $this->hasOne(Entretien::class);
    }
}
