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
        if (Schema::hasTable('ecommerce_payments')) {
            Schema::table('ecommerce_payments', function (Blueprint $table) {
                $table->dropForeign(['transfer_id']);
            });
        }
        if (Schema::hasTable('ecommerce_withdraws')) {
            Schema::dropIfExists('ecommerce_withdraws');
        }

        Schema::create('account_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->float('amount');
            $table->string('method');
            $table->string('payment_id')->nullable();
            $table->string('status')->default('pending');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_transfers');
    }
};
