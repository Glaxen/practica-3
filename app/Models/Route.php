<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $table = 'routes';  // Especifica el nombre de la tabla si no sigue la convención de Laravel

    protected $fillable = [
        'name',
        'latitude_start',
        'longitude_start',
        'latitude_end',
        'longitude_end',
        'status'
    ];

    /**
     * Relación con Routezone.
     */
    public function routezones()
    {
        return $this->hasMany(Routezone::class);
    }

    /**
     * Relación con Vehicleroutes.
     */
    /* public function vehicleroutes()
    {
        return $this->hasMany(Vehicleroute::class);
    } */

    // Si necesitas deshabilitar las marcas de tiempo, descomenta la siguiente línea
    // public $timestamps = false;
}
