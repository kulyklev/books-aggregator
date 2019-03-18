<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 15.03.19
 * Time: 0:02
 */

namespace App\Services\ControllerService;


use App\Http\Resources\BookCollection;
use App\Http\Resources\Book as BookResource;
use App\Models\Book;
use App\Models\Category;

class BookService
{
    /**
     * @return mixed
     */
    public function getAll()
    {
        return new BookCollection(Book::paginate(24));
    }

    /**
     * @param Book $book
     * @return BookResource
     */
    public function getBookInfo(Book $book)
    {
        return new BookResource($book);
    }

    public function search(string $searchText)
    {
        $books = Book::search($searchText)->get();
        return new BookCollection($books);
    }

    public function getCategory(string $categoryName)
    {
        $books = Category::where('name', $categoryName)->first()->books;
        return new BookCollection($books);
    }
}