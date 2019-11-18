<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             CategoriesTableSeeder::class,
             DealersTableSeeder::class,
             CategoryLinksTableSeeder::class,
             PublisherTableSeeder::class,
             BooksTableSeeder::class,
             OffersTableSeeder::class,
             PricesTableSeeder::class,
             UsersTableSeeder::class,
         ]);
    }
}
