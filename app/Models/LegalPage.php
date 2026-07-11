<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegalPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'created_by',
        'updated_by',
    ];


    /**
     * Administrateur ayant créé la page
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * Administrateur ayant effectué la dernière modification
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    /**
     * Scope : récupérer uniquement les pages actives
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
