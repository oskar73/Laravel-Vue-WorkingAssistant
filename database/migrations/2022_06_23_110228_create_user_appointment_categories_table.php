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
        Schema::create('user_appointment_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_appointment_categories');
    }
};
