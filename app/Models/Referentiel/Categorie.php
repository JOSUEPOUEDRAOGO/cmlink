<?php

namespace App\Models\Referentiel;

use App\Models\Entreprise\Offre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
    ];

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}
