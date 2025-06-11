<?php

namespace Database\Factories;

use App\Models\RelGaz;
use App\Models\Client;
use App\Models\Appartement;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelGazFactory extends Factory
{
    protected $model = RelGaz::class;

    public function definition()
    {
        return [
            'Codecli' => Client::factory(),
            'refApp' => Appartement::factory(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'valeur' => $this->faker->numberBetween(0, 500),
            'commentaire' => $this->faker->optional()->sentence,
        ];
    }
} 