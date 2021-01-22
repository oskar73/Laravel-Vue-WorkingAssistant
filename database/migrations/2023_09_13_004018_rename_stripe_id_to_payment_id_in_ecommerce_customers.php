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
        Schema::table('ecommerce_customers', function (Blueprint $table) {
            $table->renameColumn('stripe_id', 'payment_account_id');
        });
        Schema::table('ecommerce_customers', function (Blueprint $table) {
            $table->string('payment_account_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecommerce_customers', function (Blueprint $table) {
            $table->string('payment_account_id')->nullable(false)->change();
        });
        Schema::table('ecommerce_customers', function (Blueprint $table) {
            $table->renameColumn('payment_account_id', 'stripe_id');
        });
    }
};
