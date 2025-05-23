<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Study>
 */
class StudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => $this->faker->date(),
            'asesor' => $this->faker->name(),
            'cliente' => $this->faker->name(),
            'tipo_documento' => $this->faker->randomElement(['DNI', 'Pasaporte']),
            'cedula' => $this->faker->unique()->numerify('#########'),
            'servicio' => $this->faker->randomElement(['Internet', 'Televisión', 'Telefonía']),
            'respuesta' => $this->faker->sentence(),
        ];
    }
}
