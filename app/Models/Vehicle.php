<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function horario_mantenimiento()
    {
        return $this->hasMany(horario_mantenimiento::class);
    }
}
