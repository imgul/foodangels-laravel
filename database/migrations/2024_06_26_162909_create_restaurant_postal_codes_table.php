<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantPostalCodesTable extends Migration
{

    public function up()
    {
        Schema::create('restaurant_postal_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id');
            $table->unsignedDouble('delivery_charge', 13, 2)->nullable();
            $table->string('postal_code')->nullable();
            $table->string('delivery_time')->nullable();
            $table->unsignedInteger('min_order')->nullable();
            $table->unsignedInteger('max_order')->nullable();
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
        Schema::dropIfExists('restaurant_postal_codes');
    }
}
