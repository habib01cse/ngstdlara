<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default("null")->nullable();
            $table->string('category')->default("null")->nullable();
            $table->string('brand')->default("null")->nullable();
            $table->string('desc')->default("null")->nullable();
            $table->string('price')->default("null")->nullable();
            $table->string('image')->default('0');
            $table->string('imgpath')->default('0');            
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
        Schema::dropIfExists('products');
    }
}
