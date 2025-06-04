<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Guillermo Díaz Taleno',
            'cedula' => '123', // Genera un número de cédula aleatorio
            'telefono' => '61315145', // Genera un número de teléfono aleatorio
            'prospeccion' => 'NA',
            'supervisor' => 'NA',
            'email' => 'imraz@example.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ]);
        User::factory()->create([
            'name' => 'Isabel Mansilla',
            'cedula' => '321', // Genera un número de cédula aleatorio
            'telefono' => '622105145', // Genera un número de teléfono aleatorio
            'prospeccion' => 'NA',
            'supervisor' => 'NA',
            'email' => 'activador@g.com',
            'role' => 'activador',
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ]);
        User::factory()->create([
            'name' => 'Selena Gomez',
            'cedula' => '6542', // Genera un número de cédula aleatorio
            'telefono' => '610115145', // Genera un número de teléfono aleatorio
            'prospeccion' => 'NA',
            'supervisor' => 'NA',
            'email' => 'calibrador@g.com',
            'role' => 'calibrador',
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ]);
        // Se llama al método factory para crear 10 usuarios
        User::factory(10)->create();
        
    }
}
