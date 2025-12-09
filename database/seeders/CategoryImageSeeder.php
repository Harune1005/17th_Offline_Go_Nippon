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
            1 => 'images/categories/mountain.jpeg',
            2 => 'images/categories/sea.jpeg',
            3 => 'images/categories/traditional.jpeg',
            4 => 'images/categories/city.jpeg',
            5 => 'images/categories/cafe.jpeg',
            6 => 'images/categories/food.jpeg',
            7 => 'images/categories/culture.jpeg',
            8 => 'images/categories/onsen.jpeg',
            9 => 'images/categories/nature.jpeg',
            10 => 'images/categories/shopping.jpeg',
            11 => 'images/categories/art.jpeg',
            12 => 'images/categories/adventure.jpeg',
            13 => 'images/categories/solo.jpeg',
            14 => 'images/categories/couple.jpeg',
            15 => 'images/categories/family.jpeg',
            16 => 'images/categories/nightlife.jpeg',
            17 => 'images/categories/festival.jpeg',
            18 => 'images/categories/photo_spot.jpeg',
            19 => 'images/categories/historic_town.jpeg',
            20 => 'images/categories/hidden_gem.jpeg',
        ];

        foreach ($images as $id => $path) {
            DB::table('categories')
                ->where('id', $id)
                ->update(['image' => $path]);
        }
    }
}
