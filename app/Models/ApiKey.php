<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'key',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Les événements du modèle.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = $model->uuid ?? (string) Str::uuid();
            $model->key = $model->key ?? Str::random(64);
        });
    }

    /**
     * Obtenir l'utilisateur propriétaire de la clé API.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
