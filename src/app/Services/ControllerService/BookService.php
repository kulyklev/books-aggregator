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
use Illuminate\Pagination\Paginator;

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
        $books = Book::search($searchText)->paginate(24);
        return new BookCollection($books);
    }

    public function getCategory(string $categoryName)
    {
        $category = Category::where('name', $categoryName)->first();
        $books = Book::where('category_id', $category->id)->paginate(24);
        return new BookCollection($books);
    }
}