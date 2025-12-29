<?php

namespace App\Services\News;

class ArticleNormalizer
{
    /* Normalize a Guardian article to fit into the internal format*/

    public function fromGuardian(array $article): array
    {
        $publishedAt = $article['webPublicationDate'] ?? null;
        if ($publishedAt) {
            $publishedAt = date('Y-m-d H:i:s', strtotime($publishedAt));
        }

        return [
            'title'        => $article['webTitle'] ?? null,
            'content'      => $article['fields']['bodyText'] ?? null,
            'url'          => $article['webUrl'] ?? null,
            'published_at' => $publishedAt,
            'author'       => $article['fields']['byline'] ?? null,
            'category'     => $article['sectionId'] ?? null, // external category for mapping
        ];
    }

    public function fromNewsApi(array $article): array
    {
        $publishedAt = $article['publishedAt'] ?? null;
        if ($publishedAt) {
            $publishedAt = date('Y-m-d H:i:s', strtotime($publishedAt));
        }

        return [
            'title'        => $article['title'] ?? null,
            'content'      => $article['content'] ?? null,
            'url'          => $article['url'] ?? null,
            'published_at' => $publishedAt,
            'author'       => $article['author'] ?? null,
            'category'     => $article['category'] ?? null, // external category for mapping
        ];
    }
}
