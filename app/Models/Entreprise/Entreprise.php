<?php

namespace App\Models\Entreprise;

use App\Models\Communication\Message;
use App\Models\Admin\Signalement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse',
    ];

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function signalements()
    {
        return $this->hasMany(Signalement::class);
    }
}
