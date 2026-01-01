<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Services\News\UnifiedNewsFetcher;
use App\Services\News\AggregatorService;

class RunNewsAggregationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    
    public function handle(
        UnifiedNewsFetcher $fetcher,
        AggregatorService $aggregator
    ): void 
        {
            try {
                
                $articles = $fetcher->fetchAll();                
                $aggregator->store($articles);

                Log::info('News aggregation completed successfully.', [
                    'count' => count($articles),
                ]);
            } catch (\Throwable $e) {
                Log::error('News aggregation failed.', [
                    'error' => $e->getMessage(),
                ]);

                throw $e; 
            }
    }
}
