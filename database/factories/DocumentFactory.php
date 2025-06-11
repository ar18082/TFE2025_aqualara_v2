<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition()
    {
        return [
            'client_id' => Client::factory(),
            'titre' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['contrat', 'facture', 'rapport', 'autre']),
            'chemin' => $this->faker->filePath,
            'date_creation' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'date_modification' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'taille' => $this->faker->numberBetween(1000, 10000000),
            'commentaire' => $this->faker->optional()->sentence,
        ];
    }
} 