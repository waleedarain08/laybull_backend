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

            $table->unsignedInteger('category_id');
            $table->unsignedInteger('brand_id');
            $table->unsignedInteger('vendor_id');

            $table->string('type')->default(0);
            $table->string('status')->default(0);
            $table->string('popular')->default(0);
            $table->string('name');
            $table->string('price');
            $table->string('feature_image');
            $table->string('color');
            $table->string('size')->nullable();
            $table->string('condition')->nullable();
            $table->string('ship_dur')->nullable();
            $table->string('ec_commission')->default(0);
            $table->string('detail')->nullable();
            $table->string('discount')->nullable();
            $table->string('original_price')->nullable();
            $table->string('date');
            $table->string('available')->nullable();
            $table->string('tags')->nullable();
            $table->string('publish')->nullable();
            $table->string('seller')->nullable();
            $table->string('review')->nullable();
            $table->string('rating')->nullable();
            $table->string('short_desc')->nullable();
            $table->string('status_reason')->nullable();
            $table->string('payment')->nullable();
            $table->string('warrenty')->default(0);

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
