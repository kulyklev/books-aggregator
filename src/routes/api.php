<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/parser/start', 'ScraperController@startScraper');

Route::get('/update-prices', 'ScraperController@updatePrices');

Route::get('/search', 'BookController@search');

Route::get('/category/{category}', 'CategoryController@getCategory');

Route::get('/dealers', 'DealerController@index');

Route::apiResources([
    'books' => 'BookController',
    'categories' => 'CategoryController',
]);

Route::apiResource('categories.category-links', 'CategoryLinkController')->except([
    'index'
]);