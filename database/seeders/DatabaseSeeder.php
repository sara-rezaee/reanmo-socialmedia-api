<?php

namespace Database\Seeders;

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
        User::create([
            'last_name' => 'R',
            'first_name' => 'Sara',
            'avatar_url' => 'sara_r.jpg',
            //'remember_token' => '5|wJ0EZpCgom8nxqVc8vBbVkuDR5HjjkvFOFfldsw4',
            'email' => 's.tamasok@reanmo.com',
            'password' => 'password',
        ]);

        //$this->call(UserSeeder::class);
    }
}
