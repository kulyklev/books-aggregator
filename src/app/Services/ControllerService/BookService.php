<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 15.03.19
 * Time: 0:02
 */

namespace App\Services\ControllerService;


use App\Http\Resources\BookCollection;
use App\Models\Book;

class BookService
{
    /**
     * @return mixed
     */
    public function getAll()
    {
//        $books = Book::paginate(20);
        $books = new BookCollection(Book::paginate(24));
        return $books;
    }

    public function getBookInfo(Book $book)
    {
        $offers = $book->offers();
        $prices = $offers->prices();
        return $book;
    }

    public function deleteBook(Book $book): bool
    {
        return $book->delete();
    }
}