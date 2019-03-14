<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 09.03.19
 * Time: 15:34
 */

namespace App\Services\ScrapeService;


use App\Jobs\ProcessScraper;
use App\Models\CategoryLink;
use App\Models\Offer;

class ScraperStartService
{
    public function parseCategories()
    {
        $links = CategoryLink::all();

        foreach ($links as $link) {
            $scrapyStartParams = $link->dealer->site_name;
            $scrapyStartParams .= " -a category_id=" . $link->category->id;
            $scrapyStartParams .= " -a start_url=" . $link->url;
            ProcessScraper::dispatch($scrapyStartParams)->onConnection('database');
        }
    }

    public function updatePrices()
    {
        $links = Offer::all();

        foreach ($links as $link) {
            $scrapyStartParams = $link->dealer->site_name;
            $scrapyStartParams .= " -a book_url=" . $link->link;
//            dd($scrapyStartParams);
            ProcessScraper::dispatch($scrapyStartParams)->onConnection('database');
        }
    }
}