<?php

use App\Models\MenuItem;
use App\Models\Reward;
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
        Schema::create('reward_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Reward::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(MenuItem::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_menus');
    }
};
