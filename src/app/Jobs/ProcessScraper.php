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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         //exec("cd /var/www/code/parser_src && scrapy crawl bookclub.ua -a category_id=1 -a start_url=https://www.bookclub.ua/catalog/books/advices/?gc=100");
         exec("cd /var/www/code/parser_src && scrapy crawl bookclub.ua -a category_id=1 -a start_url=https://www.bookclub.ua/catalog/books/advices/?gc=100 -a book_url=https://www.bookclub.ua/catalog/books/pop/product.html?id=49622");
        // exec("cd /var/www/code/parser_src && scrapy crawl balka-book.com");
        // exec("cd /var/www/code/parser_src && scrapy crawl yakaboo.ua");
    }
}
