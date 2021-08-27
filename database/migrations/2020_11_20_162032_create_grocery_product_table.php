<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroceryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grocery_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grocery_category_id');
            $table->foreign('grocery_category_id')->references('id')->on('grocery_category')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('quantity');
            $table->float('price',10,2)->default(0);
            $table->string('Image')->nullable();
            $table->tinyInteger('status')->default(1);   
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
        Schema::dropIfExists('grocery_product');
    }
}
