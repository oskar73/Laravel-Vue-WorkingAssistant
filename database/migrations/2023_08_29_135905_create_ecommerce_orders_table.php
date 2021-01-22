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
        Schema::create('ecommerce_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->json('shipping_address');
            $table->string('status')->default('pending');
            $table->float('shipping_amount');
            $table->float('subtotal');
            $table->float('total');
            $table->string('tracking_code');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('customer_id')
                ->references('id')
                ->on('ecommerce_customers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('web_id')
                ->references('id')
                ->on('websites')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecommerce_orders');
    }
};
