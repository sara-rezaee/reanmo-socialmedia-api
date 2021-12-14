<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $likeable = [
        Tweet::class,
        Comment::class,
    ];
    $likeable_type = $this->faker->randomElement($likeable);
    $likeable_id = $likeable_type::factory()->create()->id;
        return [
            'user_id' => User::factory(),
            'likeable_type' => $likeable_type,
            'likeable_id' => $likeable_id
        ];
    }
}
