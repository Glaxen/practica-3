<?php

namespace Database\Seeders;

use App\Models\Vehiclecolor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiclecolorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $c1 = new Vehiclecolor();
        $c1->name ='BLANCO';
        $c1->save();

        $c2 = new Vehiclecolor();
        $c2->name ='NEGRO';
        $c2->save();

        $c3 = new Vehiclecolor();
        $c3->name ='ROJO';
        $c3->save();

        $c4 = new Vehiclecolor();
        $c4->name ='AMARILLO';
        $c4->save();
    }
}
