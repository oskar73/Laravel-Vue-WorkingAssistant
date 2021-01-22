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
        Schema::table('ecommerce_order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('web_id')->index();

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
        Schema::table('ecommerce_order_items', function (Blueprint $table) {
            $table->dropForeign(['web_id']);
            $table->dropColumn(['web_id']);
        });
    }
};
