<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexResponse()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testShowResponse()
    {
        $response = $this->get('api/books/1');

        $response->assertStatus(200);
    }

    public function testShowUndefinedBook()
    {
        $response = $this->get('api/books/0');

        $response->assertStatus(404);
    }

    public function testSearchRequest()
    {
        $response = $this->json('GET', 'api/search', ['text' => 'name']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                    'data' => [
                            '*' => [
                                    'id',
                                    'isbn',
                                    'name',
                                    'author',
                                    'publishing_year',
                                    'publisher',
                                    'category',
                                    'offers' =>
                                        [
                                            '*' =>
                                                [
                                                    'id',
                                                    'dealer',
                                                    'logo',
                                                    'link',
                                                    'image',
                                                    'price',
                                                    'currency',
                                                ],
                                        ],
                                ],
                        ],
                    'links' => [
                            'first',
                            'last',
                            'prev',
                            'next',
                        ],
                    'meta' => [
                            'current_page',
                            'from',
                            'last_page',
                            'path',
                            'per_page',
                            'to',
                            'total',
                        ],
                ]
            );
    }
}
