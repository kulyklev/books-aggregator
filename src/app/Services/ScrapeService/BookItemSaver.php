<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 21.02.19
 * Time: 18:04
 */

namespace App\Services\ScrapeService;


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
                $this->saveReparsedPrice($decodedJsonData);
                break;

            default:
            // TODO Maybe add logging or messaging
                break;
        }
    }

    /**
     * @param $decodedJsonData
     */
    protected function processBookItem($decodedJsonData): void
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
    protected function saveNewBook($decodedJsonData): void
    {
        if ($decodedJsonData->publisher == null) {
            $this->saveNewBookWithoutPublisher($decodedJsonData);
        } else {
            $this->saveNewBookWithPublisher($decodedJsonData);
        }
    }

    /**
     * @param $decodedJsonData
     */
    protected function saveNewBookWithoutPublisher($decodedJsonData): void
    {
        $book = $this->saveBook($decodedJsonData);
        $newOffer = $this->saveOffer($decodedJsonData, $book->id);
        $this->savePrice($decodedJsonData, $newOffer->id);
    }

    /**
     * @param $decodedJsonData
     */
    protected function saveNewBookWithPublisher($decodedJsonData): void
    {
        $publisher = $this->savePublisher($decodedJsonData->publisher);
        $book = $this->saveBook($decodedJsonData, $publisher->id);
        $newOffer = $this->saveOffer($decodedJsonData, $book->id);
        $this->savePrice($decodedJsonData, $newOffer->id);
    }

    /**
     * Save publisher and return saved Instance
     *
     * @param string $name
     * @return Publisher
     */
    protected function savePublisher(string $name = null): ?Publisher
    {
        if ($name == null) {
            return null;
        } else {
            $newPublisher = new Publisher();
            $newPublisher->name = $name;
            $newPublisher->firstOrCreate(['name' => $name]);
            $publisher = Publisher::where('name', $name)->first();
            return $publisher;
        }
    }

    /**
     * @param $decodedJsonData
     * @param null $publisherId
     * @return Book
     */
    protected function saveBook($decodedJsonData, $publisherId = null): Book
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
     * @param Book $bookId
     * @return Offer
     */
    protected function saveOffer($decodedJsonData, int $bookId): Offer
    {
        $dealer = Dealer::where('site_name', $decodedJsonData->dealer_name)->first();
        $offer = Offer::where('book_id', $bookId)->where('dealer_id', $dealer->id)->first();

        if ($offer === null) {
            $newOffer = new Offer();
            $newOffer->book_id = $bookId;
            $newOffer->dealer_id = $dealer->id;
            $newOffer->link = $decodedJsonData->link;
            if (empty($decodedJsonData->image[0])) {
                $newOffer->image = null;
            } else {
                $newOffer->image = $decodedJsonData->image[0]->path;
            }
            $newOffer->save();
            return $newOffer;
        } else {
            return $offer;
        }
    }

    /**
     * @param $decodedJsonData
     * @param int $offerId
     */
    protected function savePrice($decodedJsonData, int $offerId): void
    {
        $newPrice = new Price();
        $newPrice->offer_id = $offerId;
        $newPrice->price = $decodedJsonData->price;
        $newPrice->currency = $decodedJsonData->currency;
        $newPrice->save();
    }

    /**
     * @param $decodedJsonData
     * TODO May be replace this method to dedicated class
     */
    protected function insertMissingValuesIntoBook($decodedJsonData): void
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

        $offer = $this->saveOffer($decodedJsonData, $book->id);
        $this->saveReparsedPrice($decodedJsonData);
    }

    // TODO May be should be deleted
    protected function saveReparsedPrice($decodedJsonData)
    {
        $book = Book::where('isbn', $decodedJsonData->isbn)->first();
        $dealer = Dealer::where('site_name', $decodedJsonData->dealer_name)->first();
        $offer = $book->offers()->where('dealer_id', $dealer->id)->first();

        $this->savePrice($decodedJsonData, $offer->id);
    }

}
