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
            $table->string('name', 256);
            $table->string('original_name', 64)->nullable();
            $table->string('isbn', 24)->unique();
            $table->year('publishing_year')->nullable();
            $table->smallInteger('weight')->nullable();
            $table->string('language', 16)->nullable();
            $table->string('original_language', 256)->nullable();
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
