<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'key' => 'Cherry Blossom',
                'name' => 'First Post',
                'description' => 'Awarded for creating your very first post.',
                'image_path' => 'images/badges/sakura04.png',
            ],
            [
                'key' => 'Karesansui',
                'name' => '3 Prefectures',
                'description' => 'Awarded for publishing 3 prefectures.',
                'image_path' => 'images/badges/karesansui.png',
            ],
            [
                'key' => 'Sumo',
                'name' => '5 Prefectures',
                'description' => 'Awarded for publishing 5 prefectures.',
                'image_path' => 'images/badges/sumo04.png',
            ],

            [
                'key' => 'Onsen hot spring',
                'name' => '10 Prefectures',
                'description' => 'Awarded for publishing 10 prefectures.',
                'image_path' => 'images/badges/onsen02.png',
            ],
            [
                'key' => 'Japanese Castle',
                'name' => '15 Prefectures',
                'description' => 'Awarded for publishing 15 prefectures.',
                'image_path' => 'images/badges/japanese_castle.png',
            ],
            [
                'key' => 'Lucky Cat',
                'name' => '20 Prefectures',
                'description' => 'Awarded for publishing 20 prefectures.',
                'image_path' => 'images/badges/maneki_neko.png',
            ],
            [
                'key' => 'Ninja',
                'name' => '30 Prefectures',
                'description' => 'Awarded for publishing 30 prefectures.',
                'image_path' => 'images/badges/ninja05.png',
            ],
            [
                'key' => 'Maiko-san',
                'name' => '40 Prefectures',
                'description' => 'Awarded for publishing 40 prefectures.',
                'image_path' => 'images/badges/maiko.png',
            ],
            [
                'key' => 'Mt.Fuji',
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
