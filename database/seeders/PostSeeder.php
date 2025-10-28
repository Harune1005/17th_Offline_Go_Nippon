<?php

namespace Database\Seeders;

use App\Models\Image;
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
        $posts = [
            [
                'title' => 'Tokyo',
                'prefecture_id' => 13,
                'visited_at' => Carbon::now()->subDays(10),
                'cost' => '10000',
                'image_files' => ['sample1.jpg'],
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'title' => 'Oosaka万博',
                'prefecture_id' => 27,
                'visited_at' => Carbon::now()->subDays(5),
                'cost' => '8000',
                'image_files' => ['sample2.jpg'],
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'title' => '福岡旅行',
                'prefecture_id' => 40,
                'visited_at' => Carbon::now()->subDays(2),
                'cost' => '12000',
                'image_files' => ['sample3.jpg'],
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'title' => 'Kyoto',
                'prefecture_id' => 26,
                'visited_at' => Carbon::now()->subDays(2),
                'cost' => '2000',
                'image_files' => ['sample4.jpg'],
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
            [
                'title' => 'Kanagawa',
                'prefecture_id' => 14,
                'visited_at' => Carbon::now()->subDays(2),
                'cost' => '112000',
                'image_files' => ['sample5.jpg'],
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::create([
                'user_id' => 1,
                'title' => $postData['title'],
                'prefecture_id' => $postData['prefecture_id'],
                'visited_at' => $postData['visited_at'],
                'cost' => $postData['cost'],
                'image' => null,
                'content' => $postData['content'],
            ]);

            $imagesArray = [];

            foreach ($postData['image_files'] as $fileName) {
                $path = storage_path('app/public/'.$fileName);
                if (file_exists($path)) {
                    $base64 = base64_encode(file_get_contents($path));

                    Image::create([
                        'post_id' => $post->id,
                        'image' => $base64,
                    ]);

                    $imagesArray[] = $base64;
                }
            }
        }
    }
}
