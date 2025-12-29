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
            'category'     => $article['sectionId'] ?? null, // raw external category
        ];
    }
}
