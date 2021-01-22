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
        Schema::table('ecommerce_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('transfer_id')->nullable();

            $table->foreign('transfer_id')
            ->references('id')
            ->on('ecommerce_withdraws')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecommerce_payments', function (Blueprint $table) {
            $table->dropColumn('transfer_id');
        });
    }
};
