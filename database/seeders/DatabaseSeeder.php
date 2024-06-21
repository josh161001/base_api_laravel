<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RolesSeeder::class);

        User::factory(2)->create();

        User::factory()->create([
            'nombre_completo' => 'Test User',
            'correo' => 'test@example.com',
        ]);
    }
}
