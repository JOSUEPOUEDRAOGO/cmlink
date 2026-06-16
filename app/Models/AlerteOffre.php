<?php

namespace App\Models;

use App\Models\Referentiel\Categorie;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlerteOffre extends Model
{
    protected $fillable = [
        'user_id',
        'toutes_categories',
        'categories_ids',
        'type_offre',
        'active',
    ];

    protected $casts = [
        'toutes_categories' => 'boolean',
        'categories_ids'    => 'array',
        'active'            => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}