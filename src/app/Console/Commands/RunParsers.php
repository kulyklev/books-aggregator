<?php

namespace App\Console\Commands;

use App\Services\ScrapeService\ScraperStartService;
use Illuminate\Console\Command;

class RunParsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrapers:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start scraping all categories';

    protected $scraperStartService;

    /**
     * Create a new command instance.
     *
     * @param ScraperStartService $scraperStartService
     */
    public function __construct(ScraperStartService $scraperStartService)
    {
        parent::__construct();
        $this->scraperStartService = $scraperStartService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->scraperStartService->parseCategories();
    }
}
