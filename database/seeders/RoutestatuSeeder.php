<?php

namespace Database\Seeders;

use App\Models\Routestatu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoutestatuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $b1 = new Routestatu();
        $b1->name = 'PROGRAMADO';
        $b1->save();

        $b2 = new Routestatu();
        $b2->name = 'INICIADO';
        $b2->save();

        $b3 = new Routestatu();
        $b3->name = 'FINALIZADO';
        $b3->save();

        $b4 = new Routestatu();
        $b4->name = 'CANCELADO';
        $b4->save();

        $b5 = new Routestatu();
        $b5->name = 'REPROGRAMADO';
        $b5->save();
    }
}
