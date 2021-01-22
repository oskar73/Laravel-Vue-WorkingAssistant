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
        Schema::create('directory_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->text('links')->nullable();
            $table->integer('listing_limit');
            $table->text('property')->nullable();
            $table->boolean('featured')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('new')->default(0);
            $table->boolean('meeting')->default(0);
            $table->boolean('form')->default(0);
            $table->unsignedBigInteger('form_id')->nullable();
            $table->unsignedBigInteger('email_id')->nullable();
            $table->integer('order')->nullable();
            $table->integer('step')->default(1);
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
        Schema::dropIfExists('directory_packages');
    }
};
