<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offers')->insert([
            'book_id' => 1,
            'dealer_id' => 1,
            'link' => 'some link 1'
        ]);

        DB::table('offers')->insert([
            'book_id' => 1,
            'dealer_id' => 2,
            'link' => 'some link 2'
        ]);
    }
}
