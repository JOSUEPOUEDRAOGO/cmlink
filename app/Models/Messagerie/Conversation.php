<?php

namespace App\Models\Messagerie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Entreprise;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'entreprise_id',
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

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
