<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessScraper implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $scrapyParams;

    /**
     * Create a new job instance.
     *
     * @param string $scrapyParams
     */
    public function __construct(string $scrapyParams)
    {
        $this->scrapyParams = $scrapyParams;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        exec("cd /var/www/code/parser_src && scrapy crawl " . $this->scrapyParams);
    }
}
