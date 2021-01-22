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
        Schema::create('ecommerce_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->string('paypal_transaction_id')->nullable();
            $table->string('stripe_charge_id')->nullable(); // stripe payment intent id
            $table->string('payment_status');
            $table->float('amount');
            $table->float('fees');
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('ecommerce_orders')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
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
        Schema::dropIfExists('ecommerce_payments');
    }
};
