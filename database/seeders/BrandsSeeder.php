<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $b1 = new Brand();
        $b1->name = 'TOYOTA';
        $b1->save();

        $b2 = new Brand();
        $b2->name = 'VOLVO';
        $b2->save();

        $b3 = new Brand();
        $b3->name = 'MITSUBISHI';
        $b3->save();

        $b4 = new Brand();
        $b4->name = 'SCANNIA';
        $b4->save();

        $b5 = new Brand();
        $b5->name = 'MERCEDES BENZ';
        $b5->save();
    }
}
