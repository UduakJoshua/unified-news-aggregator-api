<?php

namespace App\Services\News;

use App\DTO\News\ArticleDTO;
use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AggregatorService
{
    /**
     * Persist normalized articles into the database
     *
     * @param ArticleDTO[] $articles
     */
    public function store(array $articles): void
    {
        DB::transaction(function () use ($articles) {
            foreach ($articles as $articleDTO) {
                $this->storeSingleArticle($articleDTO);
            }
        });
    }

    private function storeSingleArticle(ArticleDTO $dto): void
    {
        // Resolve or create source
        $source = Source::firstOrCreate(
            ['slug' => $dto->source],
            ['name' => ucfirst($dto->source)]
        );

        // Resolve or create category (optional)
        $categoryId = null;

        if ($dto->category) {
            $category = Category::firstOrCreate(
                ['slug' => $dto->category],
                ['name' => ucfirst($dto->category)]
            );

            $categoryId = $category->id;
        }

        // Deduplication: external_id + source
        Article::updateOrCreate(
            [
                'external_id' => $dto->externalId,
                'source_id'   => $source->id,
            ],
            [
                'title'        => $dto->title,
                'content'      => $dto->content,
                'url'          => $dto->url,
                'author'       => $dto->author,
                'category_id'  => $categoryId,
                'published_at' => $dto->publishedAt,
            ]
        );
    }
}
