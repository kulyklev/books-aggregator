<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dealers')->insert([
            'site_name' => 'bookclub.ua',
        ]);

        DB::table('dealers')->insert([
            'site_name' => 'balka-book.com',
        ]);
    }
}
