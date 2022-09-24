<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     * @param User $user
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create();
        return [
            'user_id' => $user->id,
            'author' => $user->name,
            'title' => $this->faker->sentence,
            'post' => $this->faker->sentence,
            'category_id' => rand(1, Category::count())
        ];
    }
}
