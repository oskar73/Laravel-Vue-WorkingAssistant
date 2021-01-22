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
        Schema::create('user_appointment_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id');
            $table->string('category_id');
            $table->unsignedBigInteger('meeting_pid')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('created_by');
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('status');
            $table->text('reason')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('user_appointment_lists');
    }
};
