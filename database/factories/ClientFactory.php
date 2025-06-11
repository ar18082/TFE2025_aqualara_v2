<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'Codecli' => $this->faker->unique()->bothify('CLI-####'),
            'nom' => $this->faker->company,
            'rue' => $this->faker->streetAddress,
            'codePost' => $this->faker->postcode,
            'codepays' => 'FR',
            'tel' => $this->faker->phoneNumber,
            'fax' => $this->faker->optional()->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'rueger' => $this->faker->streetAddress,
            'dernierreleve' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
} 