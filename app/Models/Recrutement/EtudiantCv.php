<?php

namespace App\Models\Recrutement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academique\Etudiant;

class EtudiantCv extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'titre',
        'cv_path',
        'principal',
    ];

    protected $casts = [
        'principal' => 'boolean',
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
