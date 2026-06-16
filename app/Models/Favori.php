<?php

namespace App\Models;

use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Offre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favori extends Model
{
    protected $fillable = [
        'etudiant_id',
        'offre_id',
    ];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function offre(): BelongsTo
    {
        return $this->belongsTo(Offre::class);
    }
}
