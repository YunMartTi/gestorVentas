<?php

namespace Database\Seeders;

use App\Models\Study;
use App\Models\User;
use Database\Factories\AsesorFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the apication's database.
     */
    // Los seeder son que ciertos datos siempren esten el la base de datos aunque se haga un migrate:refresh
    public function run(): void
    {
        $this->call(RolSeeder::class);
        // Llamar a todos los seeders que tengamos
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            //AsesorSeeder::class, // ✅ Esto está bien
            StudySeeder::class,
        ]);

        /* Se llama al método factory para crear 10 usuarios
        User::factory(10)->create();
        */
    }
}
http://localhost:8080/laravel/blog/public/posts/create