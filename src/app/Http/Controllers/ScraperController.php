<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessScraper;
use http\Env\Response;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function startScraper(Request $request){
        ProcessScraper::dispatch('bookclub.ua -a category_id=1 -a start_url=https://www.bookclub.ua/catalog/books/detective')->onConnection('database');
        return response('Start process', 200);
    }
}
