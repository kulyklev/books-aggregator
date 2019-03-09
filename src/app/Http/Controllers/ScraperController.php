<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessScraper;
use App\Services\ScraperStartService;
use http\Env\Response;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function startScraper(Request $request){
        $tmp = new ScraperStartService;
        $tmp->parseCategories();
        return response('Start process', 200);
    }
}
