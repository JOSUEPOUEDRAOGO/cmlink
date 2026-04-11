<?php

namespace App\Models\Admin;

use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Entreprise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'etudiant_id',
        'entreprise_id',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}
