<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_sections', function (Blueprint $table) {
            if (! Schema::hasColumn('page_sections', 'category_id')) {
                $table->unsignedBigInteger('category_id');
            }
            // $table->foreign('category_id')
            //     ->on(config('database.connections.mysql2.database').'.section_categories')
            //     ->references('id')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
