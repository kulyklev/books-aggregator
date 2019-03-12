<?php

namespace App\Console\Commands;

use App\Services\ScraperStartService;
use Illuminate\Console\Command;

class UpdatePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrapers:update_price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates prices of parsed book offers';

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
        $this->scraperStartService->updatePrices();
    }
}
