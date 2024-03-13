<?php

namespace Nodus\Packages\LivewireForms\Tests\Data\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nodus\Packages\LivewireForms\Tests\Data\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'id'         => $this->faker->numberBetween(1, 99999),
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'email'      => $this->faker->email,
            'admin'      => $this->faker->boolean,
        ];
    }
}
