<?php

namespace App\Services\News;

class ArticleNormalizer
{
    /**
     * Normalize a NewsAPI article into internal format
     */
    public function fromNewsApi(array $article): array
    {
        return [
            'title'        => null,
            'content'      => null,
            'url'          => null,
            'published_at' => null,
            'source_id'    => null,
            'category_id'  => null,
            'author'       => null,
        ];
    }

    /**
     * Normalize a Guardian article into internal format
     */
       public function fromGuardian(array $article): array
{
    // Convert ISO 8601 to MySQL datetime
    $publishedAt = $article['webPublicationDate'] ?? null;
    if ($publishedAt) {
        $publishedAt = date('Y-m-d H:i:s', strtotime($publishedAt));
    }

    return [
        'title'        => $article['webTitle'] ?? null,
        'content'      => $article['fields']['body'] ?? null,
        'url'          => $article['webUrl'] ?? null,
        'published_at' => $publishedAt,
        'author'       => $article['fields']['byline'] ?? null,
        'source_id'    => 'guardian',
        'category_id'  => null,
    ];
}
}
