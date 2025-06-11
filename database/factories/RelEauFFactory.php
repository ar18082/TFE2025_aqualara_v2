<?php

namespace Database\Factories;

use App\Models\RelEauF;
use App\Models\Client;
use App\Models\Appartement;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelEauFFactory extends Factory
{
    protected $model = RelEauF::class;

    public function definition()
    {
        return [
            'Codecli' => Client::factory(),
            'refApp' => Appartement::factory(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'valeur' => $this->faker->numberBetween(0, 100),
            'commentaire' => $this->faker->optional()->sentence,
        ];
    }
} 