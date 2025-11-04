<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blog;
use App\Models\User;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        $randomUserId = $this->faker->randomElement($userIds);
        $isPublished = $this->faker->boolean(80);

        return [
            'title' => $this->faker->sentence(mt_rand(5, 10)),
            'content' => $this->faker->paragraphs(mt_rand(5, 15), true),
            'is_published' => $isPublished,
            'user_id' => $randomUserId,
        ];
    }
}
