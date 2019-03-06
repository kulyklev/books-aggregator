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
use App\Models\Dealer;
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

        switch ($decodedJsonData->data_type) {
            case "bookItem":
                $this->processBookItem($decodedJsonData);
                break;

            case "reparsedPrice":
                $this->saveNewPrice($decodedJsonData);
                break;

            default:
            // TODO Maybe add logging or messaging
                break;
        }
    }

    public function processBookItem($decodedJsonData)
    {
        if (Book::where('isbn', $decodedJsonData->isbn)->exists()) {
            $this->insertMissingValuesIntoBook($decodedJsonData);
        } else {
            $this->saveNewBook($decodedJsonData);
        }
    }

    /**
     * @param $decodedJsonData
     */
    public function saveNewBook($decodedJsonData): void
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
        $dealer = Dealer::where('site_name', $decodedJsonData->dealer_name)->first();

        $newOffer = new Offer();
        $newOffer->book_id = $book->id;
        $newOffer->dealer_id = $dealer->id;
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

    public function insertMissingValuesIntoBook($decodedJsonData): void
    {
        $book = Book::where('isbn', $decodedJsonData->isbn)->first();

        if ($book->original_name == null && $decodedJsonData->original_name != null) {
            $book->original_name = $decodedJsonData->original_name;
        }

        if ($book->publishing_year == null && $decodedJsonData->publishing_year != null) {
            $book->publishing_year = $decodedJsonData->publishing_year;
        }

        if ($book->weight == null && $decodedJsonData->weight != null) {
            $book->weight = $decodedJsonData->weight;
        }

        if ($book->language == null && $decodedJsonData->language != null) {
            $book->language = $decodedJsonData->language;
        }

        if ($book->original_language == null && $decodedJsonData->original_language != null) {
            $book->original_language = $decodedJsonData->original_language;
        }

        if ($book->paperback == null && $decodedJsonData->paperback != null) {
            $book->paperback = $decodedJsonData->paperback;
        }

        if ($book->product_dimensions == null && $decodedJsonData->product_dimensions != null) {
            $book->product_dimensions = $decodedJsonData->product_dimensions;
        }

        $book->save();
    }

    protected function saveNewPrice($decodedJsonData)
    {
        $book = Book::where('isbn', $decodedJsonData->isbn)->first();
        $dealer = Dealer::where('site_name', $decodedJsonData->dealer_name)->first();
        $offer = $book->offers()->where('dealer_id', $dealer->id)->first();

        $this->savePrice($decodedJsonData, $offer);
    }

}