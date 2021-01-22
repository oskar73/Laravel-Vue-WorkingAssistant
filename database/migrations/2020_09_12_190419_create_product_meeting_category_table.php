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
        Schema::create('product_meeting_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('meeting_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->foreign('meeting_id')
                ->references('id')->on('product_meetings')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')->on('appointment_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_meeting_category');
    }
};
