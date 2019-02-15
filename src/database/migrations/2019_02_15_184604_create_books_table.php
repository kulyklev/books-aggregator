<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('publisher_id');
            $table->unsignedInteger('category_id');
            $table->string('name', 64);
            $table->string('original_name', 64);
            $table->string('isbn', 24);
            $table->year('publishing_year');
            $table->smallInteger('weight');
            $table->string('language', 16);
            $table->string('original_language', 16);
            $table->smallInteger('paperback');
            $table->string('product_dimensions', 16);
            $table->string('author');
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
