<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Planta;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solo extends Model
{
    protected $fillable = 
    [
        'tipo'
    ];

    public function plantas() : HasMany
    {
        return $this->hasMany(Planta::class);
    }
}
