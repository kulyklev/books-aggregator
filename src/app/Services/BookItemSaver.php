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
    public function processData($jsonBookItem)
    {
        $decodedJsonData = json_decode($jsonBookItem);

        $this->saveNewBook($decodedJsonData);
        //TODO Implement making decision how to process data
    }

    public function saveNewBook($decodedJsonData)
    {
        $publisher = $this->savePublisher($decodedJsonData->publisher);
        $book = $this->saveBook($decodedJsonData, $publisher->id);
        $newOffer = $this->saveOffer($decodedJsonData, $book);

        $this->savePrice($decodedJsonData, $newOffer);
    }

    /**
     * Save publisher and return saved Instance
     *
     * @param string $name
     * @return Publisher
     */
    protected function savePublisher(string $name): Publisher
    {
        $newPublisher = new Publisher();
        $newPublisher->name = $name;
        $newPublisher->firstOrCreate(['name' => $name]);
        $publisher = Publisher::where('name', $name)->first();
        return $publisher;
    }

    protected function saveBook($decodedJsonData, $publisherId): Book
    {
        $book = new Book();
        $book->name = $decodedJsonData->name;
        $book->original_name = $decodedJsonData->original_name;
        $book->isbn = $decodedJsonData->isbn;
        $book->publishing_year = $decodedJsonData->publishing_year;
        $book->weight = $decodedJsonData->weight;
        $book->language = $decodedJsonData->language;
        $book->original_language = $decodedJsonData->original_language;
        $book->paperback = $decodedJsonData->paperback;
        $book->product_dimensions = $decodedJsonData->product_dimensions;
        $book->author = implode(", ", $decodedJsonData->author);
        $book->publisher_id = $publisherId;
        $book->category_id = $decodedJsonData->category_id;
        $book->save();
        return $book;
    }

    /**
     * @param $decodedJsonData
     * @param Book $book
     * @return Offer
     */
    public function saveOffer($decodedJsonData, Book $book): Offer
    {
        $newOffer = new Offer();
        $newOffer->book_id = $book->id;
        $newOffer->dealer_id = 1;
        $newOffer->link = $decodedJsonData->link;
        $newOffer->image = $decodedJsonData->image[0]->path;
        $newOffer->save();
        return $newOffer;
    }

    /**
     * @param $decodedJsonData
     * @param Offer $newOffer
     */
    public function savePrice($decodedJsonData, Offer $newOffer): void
    {
        $newPrice = new Price();
        $newPrice->offer_id = $newOffer->id;
        $newPrice->price = $decodedJsonData->price;
        $newPrice->currency = $decodedJsonData->currency;
        $newPrice->save();
    }

    public function insertMissingValuesToBook($decodedJsonData)
    {

    }

}