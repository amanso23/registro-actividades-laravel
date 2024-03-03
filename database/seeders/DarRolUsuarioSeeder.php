<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class DarRolUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        $user1 = Usuario::find(1);
        $user2 = Usuario::find(4);
        $user1->assignRole('admin');
        $user2->assignRole('profesor');
        */

        $user1 = Usuario::find(1);
        $user1->assignRole('admin');
    }
}
