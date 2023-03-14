<?php

namespace Nodus\Packages\LivewireForms\Tests\Data\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nodus\Packages\LivewireForms\Tests\Data\Models\Post;
use Nodus\Packages\LivewireForms\Tests\Data\Models\User;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'id'      => $this->faker->numberBetween(1, 99999),
            'title'   => $this->faker->sentence,
            'text'    => $this->faker->text,
            'user_id' => User::factory(),
        ];
    }
}
