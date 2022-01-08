<?php

namespace Nodus\Packages\LivewireForms\Tests\data\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nodus\Packages\LivewireForms\Tests\data\models\Post;
use Nodus\Packages\LivewireForms\Tests\data\models\User;

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
