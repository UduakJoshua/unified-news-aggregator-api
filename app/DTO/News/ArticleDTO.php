<?php

namespace App\DTO\News;

use DateTimeImmutable;

class ArticleDTO
{
    public function __construct(
        public readonly ?string $externalId,
        public readonly ?string $title,
        public readonly ?string $content,
        public readonly ?string $url,
        public readonly ?string $author,
        public readonly ?string $category,
        public readonly ?DateTimeImmutable $publishedAt,
        public readonly string $source
    ) {}
}
