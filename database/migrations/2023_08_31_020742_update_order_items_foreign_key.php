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
        Schema::table('ecommerce_order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']); // Drop the existing foreign key

            $table->foreign('order_id')
                ->references('id')
                ->on('ecommerce_orders') // Corrected reference to ecommerce_orders table
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecommerce_order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);

            // You can revert the foreign key to the previous state if needed
            $table->foreign('order_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }
};
