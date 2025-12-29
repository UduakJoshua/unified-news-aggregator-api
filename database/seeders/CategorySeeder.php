<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
            ],
            [
                'name' => 'Politics',
                'slug' => 'politics',
            ],
            [
                'name' => 'Health',
                'slug' => 'health',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']], // unique identifier
                ['name' => $category['name']]
            );
        }
    }
}
