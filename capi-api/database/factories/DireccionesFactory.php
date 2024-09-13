<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Direcciones>
 */
class DireccionesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'calle' => fake()->streetName(),
            'numero' => fake()->buildingNumber(),
            'colonia' => fake()->word(),
            'ciudad' => fake()->city(),
            'estado' => fake()->state(),
            'pais' => fake()->country(),
            'codigo_postal' => fake()->postcode(),
        ];
    }
}
