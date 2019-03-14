<?php

namespace App\Http\Controllers;

use App\Services\ScrapeService\ScraperStartService;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function startScraper(Request $request){
        $tmp = new ScraperStartService;
        $tmp->parseCategories();
        return response('Start process', 200);
    }

    public function updatePrices(Request $request)
    {
        $tmp = new ScraperStartService();
        $tmp->updatePrices();
        return response('Update prices', 200);
    }
}
