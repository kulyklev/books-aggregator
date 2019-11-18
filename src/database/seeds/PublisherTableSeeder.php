<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publishers')->insert([
            'name' => 'Book publisher',
        ]);
    }
}
