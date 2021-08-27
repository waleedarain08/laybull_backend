<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewRatingShowroom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('showroom', function (Blueprint $table) {
            $table->string('reviews');
            $table->tinyInteger('rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('showroom', function (Blueprint $table) {
            $table->dropColumn('reviews');
            $table->dropColumn('rating');
        });
    }
}
