<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'publisher_id' => 1,
            'category_id' => 1,
            'name' => 'book name',
            'original_name' => 'original book name',
            'isbn' => '10-99-12-55',
            'publishing_year' => 2015,
            'weight' => 200,
            'language' => 'ukr',
            'original_language' => 'en',
            'paperback' => 76,
            'product_dimensions' => '100 * 70',
            'author' => 'John Doe',
        ]);
    }
}
