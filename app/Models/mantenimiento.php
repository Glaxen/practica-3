<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimientos';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function horario_mantenimiento()
    {
        return $this->hasMany(horario_mantenimiento::class);
    }

}
