<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'external_id'  => $this->faker->uuid,
            'title'        => $this->faker->sentence,
            'content'      => $this->faker->paragraph(4),
            'url'          => $this->faker->url,
            'author'       => $this->faker->name,
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),

            // Relationships
            'source_id'    => Source::factory(),
            'category_id'  => Category::factory(),
        ];
    }
}
