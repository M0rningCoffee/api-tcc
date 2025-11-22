<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Solo;
use App\Models\Log;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Planta extends Model
{
    protected $fillable = [
        'sensor_key','nome_planta', 'umidade', 'solo_id',
    ];

    public function solo(): BelongsTo
    {
        return $this->belongsTo(Solo::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
