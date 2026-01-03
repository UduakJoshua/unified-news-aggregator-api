<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Source>
 */
class SourceFactory extends Factory
{
   
    protected $model = Source::class;

    public function definition(): array
    {
        return [
            'name'     => $this->faker->company,
            'slug'     => $this->faker->unique()->slug,
            'api_url'  => $this->faker->url,
        ];
    }
}

