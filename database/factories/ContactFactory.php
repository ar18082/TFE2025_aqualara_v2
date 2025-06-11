<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->name,
            'prenom' => $this->faker->firstName,
            'tel' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'fonction' => $this->faker->jobTitle,
            'commentaire' => $this->faker->optional()->sentence,
            'gerant' => $this->faker->name,
        ];
    }
} 