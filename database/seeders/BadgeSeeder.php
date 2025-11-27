<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'key' => 'first_post',
                'name' => 'First Post',
                'description' => 'Awarded for creating your very first post.',
                'image_path' => 'images/badges/sakura04.png',
            ],
            [
                'key' => '3_prefectures',
                'name' => '3 Prefectures',
                'description' => 'Awarded for publishing 3 prefectures.',
                'image_path' => 'images/badges/karesansui.png',
            ],
            [
                'key' => '5_prefectures',
                'name' => '5 Prefectures',
                'description' => 'Awarded for publishing 5 prefectures.',
            ],

            [
                'key' => '10_prefectures',
                'name' => '10 Prefectures',
                'description' => 'Awarded for publishing 10 prefectures.',
                'image_path' => 'images/badges/onsen02.png',
            ],
            [
                'key' => '15_prefectures',
                'name' => '15 Prefectures',
                'description' => 'Awarded for publishing 15 prefectures.',
                'image_path' => 'images/badges/japanese_castle.png',
            ],
            [
                'key' => '20_prefectures',
                'name' => '20 Prefectures',
                'description' => 'Awarded for publishing 20 prefectures.',
                'image_path' => 'images/badges/nameki_neko.png',
            ],
            [
                'key' => '30_prefectures',
                'name' => '30 Prefectures',
                'description' => 'Awarded for publishing 30 prefectures.',
                'image_path' => 'images/badges/ninja05.png',
            ],
            [
                'key' => '40_prefectures',
                'name' => '40 Prefectures',
                'description' => 'Awarded for publishing 40 prefectures.',
                'image_path' => 'images/badges/maiko.png',
            ],
            [
                'key' => '47_prefectures',
                'name' => '47 Prefectures',
                'description' => 'Awarded for publishing 47 prefectures.',
                'image_path' => 'images/badges/fujisan02.png',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::firstOrCreate(
                ['key' => $badge['key']], 
                $badge
            );
        }
    }
}

