<?php

namespace App\Models;

use App\Models\Recrutement\Candidature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entretien extends Model
{
    protected $fillable = [
        'candidature_id',
        'date_rdv',
        'type',
        'statut',
        'lien_visio',
        'adresse',
        'notes',
        'resultat',
    ];

    protected $casts = [
        'date_rdv' => 'datetime',
    ];

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }
}
