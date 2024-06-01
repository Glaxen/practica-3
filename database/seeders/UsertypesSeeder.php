<?php

namespace Database\Seeders;

use App\Models\Usertype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsertypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ut1 = new Usertype();
        $ut1->name = 'Administrador';
        $ut1->save();
        $ut2 = new Usertype();
        $ut2->name = 'Ciudadano';
        $ut2->save();
        $ut3 = new Usertype();
        $ut3->name = 'Conductor';
        $ut3->save();
        $ut4 = new Usertype();
        $ut4->name = 'recolector';
        $ut4->save();
        $ut5 = new Usertype();
        $ut5->name = 'reciclador';
        $ut5->save();

    }
}
