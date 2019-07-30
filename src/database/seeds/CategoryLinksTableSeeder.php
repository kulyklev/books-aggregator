<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryLinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_links')->insert([
            'category_id' => 1,
            'url' => 'https://www.bookclub.ua/catalog/books/cooking/',
            'dealer_id' => 1,
        ]);

        DB::table('category_links')->insert([
            'category_id' => 1,
            'url' => 'https://balka-book.com/kompyuternaya-literatura-596',
            'dealer_id' => 2,
        ]);
    }
}
