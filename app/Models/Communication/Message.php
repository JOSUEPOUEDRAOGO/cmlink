<?php

namespace App\Models\Communication;

use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Entreprise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
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
