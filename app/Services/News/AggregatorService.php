<?php

namespace App\Services\News;


use App\Models\Article;


class AggregatorService
{
    protected GuardianApiService $guardianApiService;
    protected ArticleNormalizer $normalizer;

    public function __construct(        
        GuardianApiService $guardianApiService,
        ArticleNormalizer $normalizer
    ) {       
        $this->guardianApiService = $guardianApiService;
        $this->normalizer       = $normalizer;
    }

    
     /* Fetch, normalize, and store articles*/    
       
        public function fetchAndStoreGuardian(): void
    {
       
        $rawArticles = $this->guardianApiService->fetch();
       
        $normalizedArticles = [];
        foreach ($rawArticles as $article) {
            $normalizedArticles[] = $this->normalizer->fromGuardian($article);
        }

        
        foreach ($normalizedArticles as $articleData) {
            Article::updateOrCreate(
                ['url' => $articleData['url']], 
                $articleData
            );
        }
    }
}
