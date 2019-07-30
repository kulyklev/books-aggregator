<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prices')->insert([
            'offer_id' => 1,
            'price' => 50,
            'currency' => 'UAH'
        ]);

        DB::table('prices')->insert([
            'offer_id' => 2,
            'price' => 55,
            'currency' => 'UAH'
        ]);
    }
}
