<?php

namespace Tests\Unit;

use App\Services\ScrapeService\BookItemSaver;
use DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use ReflectionMethod;
use Tests\TestCase;

class SaveBookTest extends TestCase
{
    use DatabaseTransactions;

    private $jsonBookItem = '{"data_type": "bookItem",
          "name": "book name",
          "original_name": "original book name",
          "author": ["book author"],
          "price": 100.5,
          "currency": "UAH",
          "language": "language",
          "original_language": "original_language",
          "paperback": 90,
          "product_dimensions": "100*100",
          "publisher": "publisher",
          "publishing_year": "2010",
          "isbn": "isbn",
          "link": "link",
          "image": null,
          "weight": 150,
          "dealer_name": "yakaboo.ua",
          "category_id": 1
        }';

    private $jsonExistingBookItem = '{"data_type": "bookItem",
            "isbn": "10-99-12-55",
            "name": "book name",
            "original_name": "original book name",
            "author": "John Doe",
            "price": 200,
            "currency": "UAH",
            "language": "ukr",
            "original_language": "en",
            "paperback": 76,
            "publisher": "Book publisher",
            "publishing_year": 2015,
            "weight": 200,
            "product_dimensions": "100 * 70",
            "dealer_name": "bookclub.ua",
            "link": "link",
            "category_id": 1
          }';

    private $jsonBookItemWithoutPublisher = '{"data_type": "bookItem",
          "name": "book name",
          "original_name": "original book name",
          "author": ["book author"],
          "price": 100.5,
          "currency": "UAH",
          "language": "language",
          "original_language": "original_language",
          "paperback": 90,
          "product_dimensions": "100*100",
          "publisher": null,
          "publishing_year": "2010",
          "isbn": "isbn",
          "link": "link",
          "image": null,
          "weight": 150,
          "dealer_name": "yakaboo.ua",
          "category_id": 1
        }';

    public function setUp(): void
    {
        parent::setUp();
//        app(DatabaseSeeder::class)->call(DatabaseSeeder::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testProcessData()
    {
        $bookSaver = new BookItemSaver();
        $bookSaver->processData($this->jsonBookItem);

        $this->assertDatabaseHas('books', [
            'name' => 'book name',
            'original_name' => 'original book name',
            'isbn' => 'isbn',
            'publishing_year' => '2010',
            'weight' => '150',
            'language' => 'language',
            'original_language' => 'original_language',
            'paperback' => '90',
            'product_dimensions' => '100*100',
            'author' => 'book author',
        ]);
        // TODO Maybe add more asssertions about other tables
    }

    public function testProcessExistingData()
    {
        $bookSaver = new BookItemSaver();
        $bookSaver->processData($this->jsonExistingBookItem);

        $this->assertDatabaseHas('prices', [
            'offer_id' => 1,
            'price' => 200,
            'currency' => 'UAH'
        ]);
    }

    public function testProcessDataWithoutPublisher()
    {
        $bookSaver = new BookItemSaver();
        $bookSaver->processData($this->jsonBookItemWithoutPublisher);

        $this->assertDatabaseHas('books', [
            'publisher_id' => null,
            'name' => 'book name',
            'isbn' => 'isbn',
        ]);
    }

    public function testSavePublisher()
    {
        $newName = 'new publisher name';

        $method = new ReflectionMethod('App\Services\ScrapeService\BookItemSaver', 'savePublisher');
        $method->setAccessible(true);

        $bookSaver = new BookItemSaver();
        $newPublisher = $method->invokeArgs($bookSaver, [$newName]);


        $this->assertTrue($newPublisher->name == $newName);
        $this->assertDatabaseHas('publishers', [
            'name' => $newName
        ]);
    }

    public function testSaveNullNamePublisher()
    {
        $newName = null;

        $method = new ReflectionMethod('App\Services\ScrapeService\BookItemSaver', 'savePublisher');
        $method->setAccessible(true);

        $bookSaver = new BookItemSaver();
        $savedPublisher = $method->invokeArgs($bookSaver, [$newName]);

        $this->assertTrue($savedPublisher == null);
    }

    public function testSaveBook()
    {
        $publisherId = 1;
        $decodedJsonData = json_decode($this->jsonBookItem);

        $method = new ReflectionMethod('App\Services\ScrapeService\BookItemSaver', 'saveBook');
        $method->setAccessible(true);

        $bookSaver = new BookItemSaver();
        $savedBook = $method->invokeArgs($bookSaver, [$decodedJsonData, $publisherId]);

        $this->assertDatabaseHas('books', [
            'name' => 'book name',
            'original_name' => 'original book name',
            'isbn' => 'isbn',
            'publishing_year' => '2010',
            'weight' => '150',
            'language' => 'language',
            'original_language' => 'original_language',
            'paperback' => '90',
            'product_dimensions' => '100*100',
            'author' => 'book author',
            'publisher_id' => '1'
        ]);
        $this->assertEquals($savedBook->name, 'book name');
        $this->assertEquals($savedBook->original_name, 'original book name');
        $this->assertEquals($savedBook->isbn, 'isbn');
        $this->assertEquals($savedBook->publishing_year, 2010);
        $this->assertEquals($savedBook->weight, 150);
        $this->assertEquals($savedBook->language, 'language');
        $this->assertEquals($savedBook->original_language, 'original_language');
        $this->assertEquals($savedBook->paperback, 90);
        $this->assertEquals($savedBook->product_dimensions, '100*100');
        $this->assertEquals($savedBook->author, 'book author');
        $this->assertEquals($savedBook->publisher_id, $publisherId);
    }

    public function testSaveBookWithoutPublisher()
    {
        $publisherId = null;
        $decodedJsonData = json_decode($this->jsonBookItem);

        $method = new ReflectionMethod('App\Services\ScrapeService\BookItemSaver', 'saveBook');
        $method->setAccessible(true);

        $bookSaver = new BookItemSaver();
        $savedBook = $method->invokeArgs($bookSaver, [$decodedJsonData, $publisherId]);

        $this->assertDatabaseHas('books', [
            'name' => 'book name',
            'original_name' => 'original book name',
            'isbn' => 'isbn',
            'publishing_year' => '2010',
            'weight' => '150',
            'language' => 'language',
            'original_language' => 'original_language',
            'paperback' => '90',
            'product_dimensions' => '100*100',
            'author' => 'book author',
            'publisher_id' => null
        ]);
        $this->assertEquals($savedBook->name, 'book name');
        $this->assertEquals($savedBook->original_name, 'original book name');
        $this->assertEquals($savedBook->isbn, 'isbn');
        $this->assertEquals($savedBook->publishing_year, 2010);
        $this->assertEquals($savedBook->weight, 150);
        $this->assertEquals($savedBook->language, 'language');
        $this->assertEquals($savedBook->original_language, 'original_language');
        $this->assertEquals($savedBook->paperback, 90);
        $this->assertEquals($savedBook->product_dimensions, '100*100');
        $this->assertEquals($savedBook->author, 'book author');
        $this->assertEquals($savedBook->publisher_id, $publisherId);
    }

    // Bad test
    public function testSaveOffer()
    {
        $bookId = 1;
        $dealerId = 3; //The id of yakaboo.ua
        $decodedJsonData = json_decode($this->jsonBookItem);

        $method = new ReflectionMethod('App\Services\ScrapeService\BookItemSaver', 'saveOffer');
        $method->setAccessible(true);
        $bookSaver = new BookItemSaver();
        $savedOffer = $method->invokeArgs($bookSaver, [$decodedJsonData, $bookId]);

        $this->assertEquals($savedOffer->book_id, $bookId);
        $this->assertEquals($savedOffer->dealer_id, $dealerId);
    }

    public function testSaveExistingOffer()
    {
        $bookId = 1;
        $dealerId = 1; // The id of bookclub.ua
        $decodedJsonData = json_decode($this->jsonExistingBookItem);

        $method = new ReflectionMethod('App\Services\ScrapeService\BookItemSaver', 'saveOffer');
        $method->setAccessible(true);
        $bookSaver = new BookItemSaver();
        $savedOffer = $method->invokeArgs($bookSaver, [$decodedJsonData, $bookId]);

        $this->assertEquals($savedOffer->book_id, $bookId);
        $this->assertEquals($savedOffer->dealer_id, $dealerId);
    }

    public function testSavePrice()
    {
        $offerId = 1;
        $decodedJsonData = json_decode($this->jsonBookItem);

        $method = new ReflectionMethod('App\Services\ScrapeService\BookItemSaver', 'savePrice');
        $method->setAccessible(true);
        $bookSaver = new BookItemSaver();
        $method->invokeArgs($bookSaver, [$decodedJsonData, $offerId]);

        $this->assertDatabaseHas('prices', [
            'offer_id' => 1,
            'price' => 100.5,
            'currency' => 'UAH'
        ]);
    }
}
