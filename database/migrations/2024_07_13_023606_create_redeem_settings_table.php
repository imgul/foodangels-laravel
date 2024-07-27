<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('redeem_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('score_value')->default(1);
            $table->integer('reward_value')->default(1);
            $table->integer('reward_menu_item_id')->default(NULL);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redeem_settings');
    }
};
