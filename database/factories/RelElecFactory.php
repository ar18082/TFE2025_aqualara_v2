<?php

namespace Database\Factories;

use App\Models\RelElec;
use App\Models\Client;
use App\Models\Appartement;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelElecFactory extends Factory
{
    protected $model = RelElec::class;

    public function definition()
    {
        return [
            'Codecli' => Client::factory(),
            'refApp' => Appartement::factory(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'valeur' => $this->faker->numberBetween(0, 1000),
            'commentaire' => $this->faker->optional()->sentence,
        ];
    }
} 