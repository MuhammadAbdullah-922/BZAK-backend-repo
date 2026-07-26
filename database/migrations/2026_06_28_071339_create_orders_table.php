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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('order_number')->unique();
        $table->enum('status', ['pending','processing','shipped','delivered','cancelled'])->default('pending');
        $table->decimal('subtotal', 10, 2);
        $table->decimal('discount', 10, 2)->default(0);
        $table->decimal('shipping', 10, 2)->default(0);
        $table->decimal('total', 10, 2);
        $table->string('payment_method')->default('cod');
     $table->enum('payment_status', ['pending','paid','failed','refunded'])->default('pending');
        $table->string('coupon_code')->nullable();
        $table->text('shipping_address');
        $table->string('shipping_city');
        $table->string('shipping_phone');
        $table->text('notes')->nullable();
        $table->string('whatsapp_number')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
