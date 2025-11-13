<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Mountain', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sea', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Traditional', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'City', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cafe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Food', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Culture', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Onsen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nature', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Shopping', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Art', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Adventure', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Solo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Couple', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Family', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nightlife', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Festival', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Photo Spot', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Historic Town', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hidden Gem', 'created_at' => now(), 'updated_at' => now()],
        ];

        $this->category->insert($categories);
    }
}
