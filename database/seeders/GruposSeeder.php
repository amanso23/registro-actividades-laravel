<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grupo;

class GruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupo1 = new Grupo();
        $grupo1->name = '4º ESO';
        $grupo1->save();

        $grupo2 = new Grupo();
        $grupo2->name = '3º ESO';
        $grupo2->save();

        $grupo3 = new Grupo();
        $grupo3->name = '2º ESO';
        $grupo3->save();
        
        $grupo4 = new Grupo();
        $grupo4->name = '1º ESO';
        $grupo4->save();
    }
}
