<?php

namespace Database\Seeders;

use App\Models\rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //FACTORY DE LOS ROLES
        rol::factory()->create([
            'rol'=> 'ADMINISTRADOR',
        ]);

        //FACTORY DE LOS USUARIOS
        User::factory()->create([
            'nombres'=> 'ADMINISTRADOR',
            'usuario'=> 'admin',
            'password'=> Hash::make('fa9100bc7e4ea13059ba392ebd754f7b'),
            'rol_id'=> '1',
        ]);
    }
}
