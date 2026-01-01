<?php

namespace App\Services\News;

use App\DTO\News\ArticleDTO;

class UnifiedNewsFetcher
{
    protected array $services;
    protected ArticleNormalizer $normalizer;

    /**
     * @param array|null $services Array of news service instances (optional)
     * @param ArticleNormalizer $normalizer
     */
    public function __construct(?array $services = null, ArticleNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;

        $this->services = $services ?? [
            app(GuardianApiService::class),
            app(NewsApiService::class),
        ];
    }

    
    public function fetchAll(): array
    {
        $articles = [];

        foreach ($this->services as $service) {
            $rawArticles = $service->fetch();
            $sourceName  = $service->getSourceName();
            $fieldMap    = $service->getFieldMap();

            foreach ($rawArticles as $raw) {
                $articles[] = $this->normalizer->normalize($raw, $sourceName, $fieldMap);
            }
        }

        return $articles;
    }
}
