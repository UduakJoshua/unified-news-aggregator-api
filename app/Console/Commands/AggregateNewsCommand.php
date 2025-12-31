<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\RunNewsAggregationJob;


class AggregateNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:aggregate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the job to aggregate news from all external sources available';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Dispatch the Aggregator Job
        RunNewsAggregationJob::dispatch();

        // Optional feedback in console
        $this->info('News aggregation job dispatched successfully.');
    }
}
