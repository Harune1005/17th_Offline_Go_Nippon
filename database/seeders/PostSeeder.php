<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'user_id' => 1,
            'title' => 'Tokyo',
            'prefecture_id' => 13,
            'visited_at' => Carbon::now()->subDays(10),
            'cost' => '10000',
            'image' => 'sample1.jpg',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi rerum, eos sint quibusdam rem accusantium fugit reprehenderit necessitatibus omnis odit!',
        ]);

        Post::create([
            'user_id' => 1,
            'title' => 'Oosaka万博',
            'prefecture_id' => 27,
            'visited_at' => Carbon::now()->subDays(5),
            'cost' => '8000',
            'image' => 'sample2.jpg',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi rerum, eos sint quibusdam rem accusantium fugit reprehenderit necessitatibus omnis odit!',
        ]);

        Post::create([
            'user_id' => 1,
            'title' => '福岡旅行',
            'prefecture_id' => 40,
            'visited_at' => Carbon::now()->subDays(2),
            'cost' => '12000',
            'image' => 'sample3.jpg',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi rerum, eos sint quibusdam rem accusantium fugit reprehenderit necessitatibus omnis odit!',
        ]);

        Post::create([
            'user_id' => 1,
            'title' => 'Kyoto',
            'prefecture_id' => 26,
            'visited_at' => Carbon::now()->subDays(2),
            'cost' => '2000',
            'image' => 'sample4.jpg',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi rerum, eos sint quibusdam rem accusantium fugit reprehenderit necessitatibus omnis odit!',
        ]);

        Post::create([
            'user_id' => 1,
            'title' => 'Kanagawa',
            'prefecture_id' => 14,
            'visited_at' => Carbon::now()->subDays(2),
            'cost' => '112000',
            'image' => 'sample5.jpg',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi rerum, eos sint quibusdam rem accusantium fugit reprehenderit necessitatibus omnis odit!',
        ]);
    }
}
