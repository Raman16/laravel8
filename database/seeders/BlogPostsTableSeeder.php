<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        \App\Models\BlogPost::factory()->count(10)->create(
            ['user_id' => $users->random()->id]
        );
    }
}
