<?php

namespace App\Services\News;

use App\Models\Article;
use App\Models\Source;
use App\Models\Category;

class AggregatorService
{
    protected GuardianApiService $guardianApiService;
    protected NewsApiService $newsApiService;
    protected ArticleNormalizer $normalizer;

    public function __construct(
        GuardianApiService $guardianApiService,
        NewsApiService $newsApiService,
        ArticleNormalizer $normalizer
    ) {
        $this->guardianApiService = $guardianApiService;
        $this->newsApiService     = $newsApiService;
        $this->normalizer         = $normalizer;
    }

    /*Fetch, normalize, and store Guardian articles */
    public function fetchAndStoreGuardian(): void
    {
        $this->fetchNormalizeStore(
            $this->guardianApiService->fetch(),
            'guardian',
            fn($article) => $this->normalizer->fromGuardian($article)
        );
    }

    /* Fetch, normalize, and store NewsAPI articles
     * @param string|null $query Optional search query
     */
    public function fetchAndStoreNewsApi(?string $query = null): void
    {
        $this->fetchNormalizeStore(
            $this->newsApiService->fetch($query),
            'newsapi',
            fn($article) => $this->normalizer->fromNewsApi($article)
        );
    }

    /* Generic helper to normalize and store articles */
    protected function fetchNormalizeStore(array $rawArticles, string $sourceSlug, callable $normalizerFn): void
    {
        if (empty($rawArticles)) {
            return;
        }

        $source = Source::where('slug', $sourceSlug)->firstOrFail();
        $sourceId = $source->id;

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

        foreach ($rawArticles as $rawArticle) {
            $normalized = $normalizerFn($rawArticle);

            $externalCategory = $normalized['category'] ?? null;
            $internalSlug = $categoryMap[strtolower($externalCategory)] ?? null;

            $categoryId = null;
            if ($internalSlug) {
                $category = Category::where('slug', $internalSlug)->first();
                $categoryId = $category ? $category->id : null;
            }

            $articleData = array_merge($normalized, [
                'source_id'   => $sourceId,
                'category_id' => $categoryId,
            ]);

            Article::updateOrCreate(
                ['url' => $articleData['url']],
                $articleData
            );
        }
    }
}
