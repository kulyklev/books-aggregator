<?php

namespace Tests\Unit;

use App\Models\Book;
use ReflectionClass;
use ReflectionMethod;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function testFullTextWildcards()
    {
        $method = new ReflectionMethod('App\Models\Book', 'fullTextWildcards');
        $method->setAccessible(true);

        $book = new Book();


        $tmp = $method->invokeArgs($book, ['@()book~<>']);

        if ($tmp == '+book*') {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }
}
