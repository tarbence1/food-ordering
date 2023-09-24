<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customerId')->constrained('users');
            $table->foreignId('restaurantId')->constrained('restaurants');
            $table->enum('status', [
                Order::STATUS_RECEIVED,
                Order::STATUS_PREPARING,
                Order::STATUS_READY,
                Order::STATUS_DELIVERED
            ])->default('received');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
