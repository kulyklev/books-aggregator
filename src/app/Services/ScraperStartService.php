<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 09.03.19
 * Time: 15:34
 */

namespace App\Services;


use App\Jobs\ProcessScraper;
use App\Models\CategoryLink;

class ScraperStartService
{
    public function parseCategories()
    {
        $links = CategoryLink::all();

        foreach ($links as $link) {
            $command = $link->dealer->site_name;
            $command .= " -a category_id=" . $link->category->id;
            $command .= " -a start_url=" . $link->url;
            ProcessScraper::dispatch($command)->onConnection('database');
        }
    }
}