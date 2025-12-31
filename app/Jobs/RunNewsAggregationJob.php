<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\News\AggregatorService;
use Illuminate\Support\Facades\Log;

class RunNewsAggregationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Optional: number of times to retry if job fails
    public $tries = 3;

    // Optional: timeout in seconds
    public $timeout = 120;

    /**
     * Execute the job.
     */
    public function handle(AggregatorService $aggregator)
    {
        try {
            $aggregator->run(); 
            Log::info('News aggregation completed successfully.');
        } catch (\Exception $e) {
            Log::error('News aggregation failed: '.$e->getMessage());
           
            throw $e;
        }
    }
}
