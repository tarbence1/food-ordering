<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menu');
            $table->foreignId('order_id')->constrained('order');
            $table->integer('quantity');
            $table->text('instructions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_order');
    }
};
