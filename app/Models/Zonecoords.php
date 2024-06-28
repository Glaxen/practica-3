<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zonecoords extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['latitude', 'longitude', 'zone_id'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
