<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => now(),
            'asesor' => $this->faker->name(),
            'cliente' => $this->faker->name(),
            'identificacion' => $this->faker->unique()->numerify('#########'),
            'telefono' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
        
            'provincia' => $this->faker->state(),
            'canton' => $this->faker->city(),
            'distrito' => $this->faker->citySuffix(),
            'barrio' => $this->faker->streetName(),
            'direccion' => $this->faker->address(),
        
            'ref_familia_1' => $this->faker->name(),
            'num_familia_1' => $this->faker->phoneNumber(),
            'ref_familia_2' => $this->faker->name(),
            'num_familia_2' => $this->faker->phoneNumber(),
            'ref_amistad' => $this->faker->name(),
            'num_amistad' => $this->faker->phoneNumber(),
        
            'servicio' => $this->faker->randomElement(['Internet', 'Telefonía', 'Cable']),
            'deposito_garantia' => $this->faker->randomElement(['si', 'no']),
            'monto_deposito' => $this->faker->randomFloat(2, 0, 500),
        
            'tipo_telefono' => $this->faker->randomElement(['Android', 'iPhone']),
            'tipo' => $this->faker->randomElement(['Pospago', 'Multimedia', 'Gpon']),
            'numero_activar' => $this->faker->phoneNumber(),
            'canal_venta' => $this->faker->randomElement(['Tienda', 'Online', 'Televentas']),
        ];        
    }
}
