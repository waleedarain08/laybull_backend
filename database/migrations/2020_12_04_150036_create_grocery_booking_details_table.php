<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroceryBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grocery_booking_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grocery_booking_id');
            $table->foreign('grocery_booking_id')->references('id')->on('grocery_booking')->onDelete('cascade');
            $table->string('quantity');
            $table->unsignedBigInteger('grocery_id');
            $table->foreign('grocery_id')->references('id')->on('grocery_product')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->float('price')->default(0);
            $table->float('total_price')->default(0);
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
        Schema::dropIfExists('grocery_booking_details');
    }
}
