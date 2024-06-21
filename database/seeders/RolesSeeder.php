<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::create([
            'nombre' => 'admin',
        ]);

        Roles::create([
            'nombre' => 'Taller',
        ]);

        Roles::create([
            'nombre' => 'Cliente'
        ]);
    }
}
