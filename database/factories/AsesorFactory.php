<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asesor>
 */
class AsesorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            $nombre = $this->faker->name();
            $email = $this->faker->unique()->safeEmail();
            
            $user = User::create([
            'name' => $nombre,
            'cedula' => $this->faker->unique()->numerify('#########'),
            'telefono' => $this->faker->numerify('########'),
            'prospeccion' => Str::random(4),
            'supervisor' => $this->faker->name(),
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => 'asesor',
            'supervisor' => $this->faker->name(),            
            'created_at' => now(),
        ]);

        return [
            'user_id' => $user->id,
            'cedula' => $this->faker->unique()->numerify('#########'),
            'nombre' => $nombre,
            'telefono' => $this->faker->numerify('########'),
            'prospeccion' => Str::random(4),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
