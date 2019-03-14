<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 15.03.19
 * Time: 0:02
 */

namespace App\Services\ControllerService;


use App\Models\Book;

class BookService
{
    public function getAll()
    {
        $books = Book::paginate(20);
        return $books;
    }
}