<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Planta;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $fillable = 
    [
        'nome','email','senha'
    ];

    protected $hidden = [
        'senha', 
        'remember_token',
    ];
    

    public function getAuthPassword()
    {
        return $this->senha; 
    }

    public function plantas(): HasMany
    {
        return $this->hasMany(Planta::class); 
    }
}
