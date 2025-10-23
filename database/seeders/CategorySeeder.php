<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            [
                'name' => 'Mountain',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Cafe',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Temple',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Tour',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Sea',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Culture',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],

             [
                'name' => 'Food',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
            
        ];

        $this->category->insert($categories);
    }
}