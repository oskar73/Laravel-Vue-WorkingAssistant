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
        Schema::create('ecommerce_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->index();
            $table->string('email');
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('method'); // stripe or paypal
            $table->string('stripe_id');
            $table->string('default_source'); // payment method
            $table->timestamps();

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
        Schema::dropIfExists('ecommerce_customers');
    }
};
