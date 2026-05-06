<?php

namespace App\Models\Academique;

use App\Models\Recrutement\Candidature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',   // 🔥 important
        'nom',
        'prenom',
        'email',
        'telephone',
        'filiere_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function getNomCompletAttribute(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }
}
