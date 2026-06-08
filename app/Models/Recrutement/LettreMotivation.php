<?php

namespace App\Models\Recrutement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academique\Etudiant;

class LettreMotivation extends Model
{
    use HasFactory;

    protected $table = 'lettre_motivations';

    protected $fillable = [
        'etudiant_id',
        'titre',
        'contenu',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
