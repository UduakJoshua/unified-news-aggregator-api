<?php

namespace App\Services\News;

use App\DTO\News\ArticleDTO;
use DateTimeImmutable;

class ArticleNormalizer
{
    /**
     * Normalize any external article into ArticleDTO using a field map
     *
     * @param array  $article  Raw article array from the source API
     * @param string $source   Source name (guardian, newsapi, nyt, etc.)
     * @param array  $fieldMap Map of DTO fields => API array keys
     */
    public function normalize(array $article, string $source, array $fieldMap): ArticleDTO
    {
        
        $get = function (string $dtoKey, $default = null) use ($article, $fieldMap) {
            $keys = explode('.', $fieldMap[$dtoKey] ?? '');
            $value = $article;

            foreach ($keys as $key) {
                if (!is_array($value) || !array_key_exists($key, $value)) {
                    return $default;
                }
                $value = $value[$key];
            }

            return $value ?? $default;
        };

        $publishedAtRaw = $get('publishedAt');
        $publishedAt = $publishedAtRaw ? new DateTimeImmutable($publishedAtRaw) : null;

        return new ArticleDTO(
            externalId: $get('externalId', $get('url')), 
            title: $get('title'),
            content: $get('content'),
            url: $get('url'),
            author: $get('author'),
            category: $get('category'),
            publishedAt: $publishedAt,
            source: $source
        );
    }
}
