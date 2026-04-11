<?php

namespace App\Models\Entreprise;

use App\Models\Referentiel\Categorie;
use App\Models\Recrutement\Candidature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'type',
        'entreprise_id',
        'categorie_id',
        'localisation',
        'date_expiration',
    ];

    protected $casts = [
        'date_expiration' => 'date',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }
}
