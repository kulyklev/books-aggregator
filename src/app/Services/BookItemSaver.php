<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 21.02.19
 * Time: 18:04
 */

namespace App\Services;


use App\Models\Book;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Price;
use App\Models\Publisher;

class BookItemSaver
{
    /**
     * Saves received bookItem to DB
     *
     * @param $jsonBookItem
     */
    public function saveBook($jsonBookItem)
    {
        $bookItem = json_decode($jsonBookItem);

        $newPublisher = new Publisher();
        $newPublisher->name = $bookItem->publisher;
        $newPublisher->firstOrCreate(['name' => $bookItem->publisher]);
        $publisher = Publisher::where('name', $bookItem->publisher)->first();

        // TODO Add category saving
        // TODO Add passing dealer id to parser and then retrieving it here
        // TODO Delete hardcoded values

        $book = new Book();
        $book->name = $bookItem->name;
        $book->original_name = $bookItem->original_name;
        $book->isbn = $bookItem->isbn;
        $book->publishing_year = $bookItem->publishing_year;
        $book->weight = $bookItem->weight;
        $book->language = $bookItem->language;
        $book->original_language = $bookItem->original_name;
        $book->paperback = $bookItem->paperback;
        $book->product_dimensions = $bookItem->product_dimensions;
        $book->author = implode(", ", $bookItem->author);
        $book->publisher_id = $publisher->id;
        $book->category_id = 1;
//        $book = $book->updateOrCreate(['isbn' => $bookItem->isbn]);
        $book->save();

        $newOffer = new Offer();
        $newOffer->book_id = $book->id;
        $newOffer->dealer_id = 1;
        $newOffer->link = $bookItem->link;
        $newOffer->image = $bookItem->image[0]->path;
        $newOffer->save();

        $newPrice = new Price();
        $newPrice->offer_id = $newOffer->id;
        $newPrice->price = $bookItem->price;
        $newPrice->currency = $bookItem->currency;
        $newPrice->save();
    }
}