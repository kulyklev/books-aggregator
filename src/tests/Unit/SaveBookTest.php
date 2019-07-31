<?php

namespace Tests\Unit;

use App\Services\ScrapeService\BookItemSaver;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaveBookTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $jsonBookItem = '{"data_type": "bookItem",
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
          "dealer_name": "bookclub.ua",
          "category_id": 1
        }';

        $bookSaver = new BookItemSaver();
        $bookSaver->processData($jsonBookItem);

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

//        TODO Book_id is incrementing maybe better not use DatabaseTransactions
        $this->assertDatabaseHas('offers', [
//            'book_id' => 4,
            'dealer_id' => 1,
            'link' => 'link',
            'image' => null,
        ]);

        $this->assertDatabaseHas('prices', [

        ]);

        $this->assertDatabaseHas('publishers', [

        ]);
    }
}
