<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            52 => 'images/categories/mountain.jpeg',
            53 => 'images/categories/sea.jpeg',
            54 => 'images/categories/traditional.jpeg',
            55 => 'images/categories/city.jpeg',
            56 => 'images/categories/cafe.jpeg',
            57 => 'images/categories/food.jpeg',
            58 => 'images/categories/culture.jpeg',
            59 => 'images/categories/onsen.jpeg',
            60 => 'images/categories/nature.jpeg',
            61 => 'images/categories/shopping.jpeg',
            62 => 'images/categories/art.jpeg',
            63 => 'images/categories/adventure.jpeg',
            64 => 'images/categories/solo.jpeg',
            65 => 'images/categories/couple.jpeg',
            66 => 'images/categories/family.jpeg',
            67 => 'images/categories/nightlife.jpeg',
            68 => 'images/categories/festival.jpeg',
            69 => 'images/categories/photo_spot.jpeg',
            70 => 'images/categories/historic_town.jpeg',
            71 => 'images/categories/hidden_gem.jpeg',
        ];

        foreach ($images as $id => $path) {
            DB::table('categories')
                ->where('id', $id)
                ->update(['image' => $path]);
        }
    }
}
