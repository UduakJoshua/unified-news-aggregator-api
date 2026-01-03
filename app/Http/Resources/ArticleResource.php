<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'content'       => $this->content,
            'url'           => $this->url,
            'author'        => $this->author,     
            'category'      => $this->category?->slug,
            'category_name' => $this->category?->name,
            'source'        => $this->source?->slug,
            'source_name'   => $this->source?->name,
            'published_at'  => $this->published_at?->format('Y-m-d H:i:s'),
        ];
    }
}
