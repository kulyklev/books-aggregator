<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessScraper;
use http\Env\Response;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function startScraper(Request $request){
        ProcessScraper::dispatch()->onConnection('database');
        return response('Start process', 200);
    }
}
