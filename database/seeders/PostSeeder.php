<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Hokkaido',
                'prefecture_id' => 1,
                'visited_at' => Carbon::now()->subDays(10),
                'cost' => '10000',
                'image_files' => ['sample1.jpg', 'sample1-2.jpg'],
                'content' => 'Tokyo trip memories!',
            ],
            [
                'title' => 'Osaka万博',
                'prefecture_id' => 27,
                'visited_at' => Carbon::now()->subDays(5),
                'cost' => '8000',
                'image_files' => ['sample2.jpg', 'sample2-2.jpg'],
                'content' => 'Exciting Osaka Expo!',
            ],
            [
                'title' => '福岡旅行',
                'prefecture_id' => 40,
                'visited_at' => Carbon::now()->subDays(2),
                'cost' => '12000',
                'image_files' => ['sample3.jpg', 'sample3-2.jpg', 'sample3-3.jpg'],
                'content' => 'Fukuoka food trip!',
            ],
            // [
            //     'title' => '福岡旅行',
            //     'prefecture_id' => 40,
            //     'visited_at' => Carbon::now()->subDays(2),
            //     'cost' => '12000',
            //     'image_files' => ['sample3.jpeg'],
            //     'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            // ],
            // [
            //     'title' => 'Kyoto',
            //     'prefecture_id' => 26,
            //     'visited_at' => Carbon::now()->subDays(2),
            //     'cost' => '2000',
            //     'image_files' => ['sample4.jpeg'],
            //     'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            // ],
            // [
            //     'title' => 'Kanagawa',
            //     'prefecture_id' => 14,
            //     'visited_at' => Carbon::now()->subDays(2),
            //     'cost' => '112000',
            //     'image_files' => ['sample5.jpeg'],
            //     'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            // ],
        ];

        foreach ($posts as $data) {
            $post = Post::create([
                'user_id' => 2,
                'title' => $data['title'],
                'prefecture_id' => $data['prefecture_id'],
                'visited_at' => $data['visited_at'],
                'cost' => $data['cost'],
                'content' => $data['content'],
            ]);

            foreach ($data['image_files'] as $fileName) {
                $path = storage_path('app/public/images/'.$fileName);

                if (file_exists($path)) {
                    $base64 = base64_encode(file_get_contents($path));

                    Image::create([
                        'post_id' => $post->id,
                        'image' => $base64,
                    ]);
                } else {
                    echo "⚠️ Image file not found: {$fileName}\n";
                }

            }
        }
    }
}
