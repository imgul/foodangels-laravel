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
        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->id();
            // street_name, house_number, floor (optional), city, postal_code, company_name (optional), note (optional), user_id (foreign key)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('street_name');
            $table->string('house_number');
            $table->string('floor')->nullable();
            $table->string('city');
            $table->string('postal_code');
            $table->string('company_name')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_addresses');
    }
};
