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
        Schema::create('blog_ads_spots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('page');
            $table->unsignedBigInteger('page_id')->nullable();
            $table->unsignedBigInteger('position_id');
            $table->json('type');
            $table->boolean('sponsored_visible')->default(1);
            $table->boolean('featured')->default(0);
            $table->boolean('new')->default(0);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('blog_ads_spots');
    }
};
