<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;



class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasPermissions;

    protected $fillable = [
          'name', 'email', 'password', 'account_type', 'status', 'bio', 'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🔥 RELATIONS
    public function etudiant()
    {
        return $this->hasOne(\App\Models\Academique\Etudiant::class);
    }

    public function entreprise()
    {
        return $this->hasOne(\App\Models\Entreprise\Entreprise::class);
    }

    // 🔥 HELPERS
    public function isAdmin(): bool
    {
        return $this->account_type === 'admin';
    }

    public function isEtudiant(): bool
    {
        return $this->account_type === 'etudiant';
    }

    public function isEntreprise(): bool
    {
        return $this->account_type === 'entreprise';
    }

    public function isActive(): bool
    {
        return $this->status === 'actif';
    }


}
