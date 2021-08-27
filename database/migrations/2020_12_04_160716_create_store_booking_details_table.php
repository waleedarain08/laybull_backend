<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_booking_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_booking_id');
            $table->foreign('store_booking_id')->references('id')->on('store_booking')->onDelete('cascade');
            $table->string('quantity');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store_product')->onDelete('cascade');
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
        Schema::dropIfExists('store_booking_details');
    }
}
