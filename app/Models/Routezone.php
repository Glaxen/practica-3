<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routezone extends Model
{
    use HasFactory;

    // Especificar la tabla si no sigue la convención de nombres de Laravel
    protected $table = 'routezones';

    // Propiedad fillable para permitir la asignación masiva
    protected $fillable = [
        'route_id',
        'zone_id'
    ];

    /**
     * Relación con la tabla de rutas.
     */
    public function route()
    {
        return $this->belongsTo(\App\Models\Route::class, 'route_id');
    }

    /**
     * Relación con la tabla de zonas.
     */
    public function zone()
    {
        return $this->belongsTo(\App\Models\Zone::class, 'zone_id');
    }
}
