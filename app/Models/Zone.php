<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function zonecoords()
    {
        return $this->hasMany(Zonecoords::class);
    }

    public function routes()
    {
        return $this->belongsToMany(Route::class, 'routezones', 'zone_id', 'route_id');
    }
}
