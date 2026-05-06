<?php

namespace App\Models\Entreprise;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',   // 🔥 important
        'nom',
        'email',
        'telephone',
        'adresse',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}
