<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profesor>
 */
class ProfesorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $profesoresIds = Usuario::where('rol', 'profesor')->pluck('id')->toArray(); //obteemos los id de los usuarios con rol de profesorl

        if (empty($profesoresIds)) {
            throw new \Exception('No hay profesores disponibles con rol "profesor" en la base de datos.');
        }

        return [
            'usuario_id' => $this->faker->unique()->randomElement($profesoresIds),
        ];
    }
}
