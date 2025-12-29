<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Source;

class SourceSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            [
                'name' => 'The Guardian',
                'slug' => 'guardian',
                'api_url' => 'https://content.guardianapis.com',
            ],
            [
                'name' => 'NewsAPI',
                'slug' => 'newsapi',
                'api_url' => 'https://newsapi.org/v2',
            ],
        ];

        foreach ($sources as $source) {
            Source::updateOrCreate(
                ['slug' => $source['slug']],
                [
                    'name' => $source['name'],
                    'api_url' => $source['api_url'],
                ]
            );
        }
    }
}
