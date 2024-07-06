<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class horario_mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'horario_mantenimientos';

    protected $fillable = [
        'dia',
        'id_vehiculo',
        'tipo',
        'horario_inicio',
        'horario_fin',
        'id_mantenimiento',


    ];


    public function mantenimiento()
    {
        return $this->belongsTo(mantenimiento::class);
    }

}
