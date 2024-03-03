<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Actividad>
 */
class ActividadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' =>  $this->faker->name, 
            'descripcion' => $this->faker->sentence,
            'lugar' => $this->faker->city,
            'fecha' => $this->faker->date,
            'duracion' => $this->faker->time,
        ];
    }
}
