<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessScraper;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function startScraper(Request $request){
        ProcessScraper::dispatch();
    }
}
