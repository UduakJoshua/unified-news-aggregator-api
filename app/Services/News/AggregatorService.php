<?php

namespace App\Services\News;

use App\Models\Article;
use App\Models\Source;
use App\Models\Category;

class AggregatorService
{
    protected GuardianApiService $guardianApiService;
    protected ArticleNormalizer $normalizer;

    public function __construct(
        GuardianApiService $guardianApiService,
        ArticleNormalizer $normalizer
    ) {
        $this->guardianApiService = $guardianApiService;
        $this->normalizer         = $normalizer;
    }

    /**
     * Fetch, normalize, and store Guardian articles
     */
    public function fetchAndStoreGuardian(): void
    {
        // 1. Fetch raw articles
        $rawArticles = $this->guardianApiService->fetch();

        if (empty($rawArticles)) {
            return;
        }

        // 2. Get source_id from sources table
        $source = Source::where('slug', 'guardian')->firstOrFail();
        $sourceId = $source->id;

        // 3. Define category mapping (external -> internal)
        $categoryMap = [
            'technology' => 'technology',
            'tech'       => 'technology',
            'business'   => 'business',
            'world'      => 'politics',
            'football'   => 'sports',
            'sport'      => 'sports',
            'politics'   => 'politics',
            'health'     => 'health',
        ];

        // 4. Normalize and insert each article
        foreach ($rawArticles as $rawArticle) {
            $normalized = $this->normalizer->fromGuardian($rawArticle);

            // Map external category to internal category_id
            $externalCategory = $normalized['category'] ?? null;
            $internalSlug     = $categoryMap[$externalCategory] ?? null;

            $categoryId = null;
            if ($internalSlug) {
                $category = Category::where('slug', $internalSlug)->first();
                $categoryId = $category ? $category->id : null;
            }

            // Merge foreign keys into normalized data
            $articleData = array_merge($normalized, [
                'source_id'   => $sourceId,
                'category_id' => $categoryId,
            ]);

            // Insert or update article
            Article::updateOrCreate(
                ['url' => $articleData['url']],
                $articleData
            );
        }
    }
}
