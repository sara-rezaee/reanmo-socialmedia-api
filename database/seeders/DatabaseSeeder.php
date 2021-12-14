<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Tweet;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'last_name' => 'R',
            'first_name' => 'Sara',
            'avatar_url' => 'sara_r.jpg',
            'remember_token' => '5|wJ0EZpCgom8nxqVc8vBbVkuDR5HjjkvFOFfldsw4',
            'email' => 's.tamasok@reanmo.com',
            'password' => bcrypt('password'),
        ]);

        $tweet = Tweet::factory()
            ->has(Like::factory()->count(5), 'likes')
            ->has(Comment::factory()->count(1), 'comments')
            ->for($user)
            ->create();
        Comment::factory()
            ->has(Like::factory()->count(5), 'likes')
            ->for($tweet)
            ->create();
        
        $user->followings()->attach(User::factory()->count(3)->create());
        $user->followers()->attach(User::factory()->count(4)->create());
        //$this->call(UserSeeder::class);
    }
}
