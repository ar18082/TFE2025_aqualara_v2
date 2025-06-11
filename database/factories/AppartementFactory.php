<?php

namespace Database\Factories;

use App\Models\Appartement;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppartementFactory extends Factory
{
    protected $model = Appartement::class;

    public function definition()
    {
        return [
            'Codecli' => Client::factory(),
            'numapp' => $this->faker->numberBetween(1, 999),
            'etage' => $this->faker->optional()->numberBetween(0, 20),
            'porte' => $this->faker->optional()->bothify('??'),
            'surface' => $this->faker->numberBetween(20, 200),
            'type' => $this->faker->randomElement(['T1', 'T2', 'T3', 'T4', 'T5']),
            'statut' => $this->faker->randomElement(['occupé', 'libre', 'en travaux']),
            'commentaire' => $this->faker->optional()->sentence,
        ];
    }
} 