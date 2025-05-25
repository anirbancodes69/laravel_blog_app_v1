<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Blog::factory(33)->create()->each(function ($book) {
            $randomComments = random_int(5, 20);
            Comment::factory($randomComments)->good()->for($book)->create();
        });

        Blog::factory(33)->create()->each(function ($book) {
            $randomComments = random_int(5, 20);
            Comment::factory($randomComments)->avg()->for($book)->create();
        });

        Blog::factory(34)->create()->each(function ($book) {
            $randomComments = random_int(5, 20);
            Comment::factory($randomComments)->bad()->for($book)->create();
        });
    }
}
