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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('header')->default(1);
            $table->boolean('footer')->default(0);
            $table->integer('footer_order')->nullable();
            $table->longText('content')->nullable();
            $table->longText('mainCss')->nullable();
            $table->longText('sectionCss')->nullable();
            $table->longText('css')->nullable();
            $table->longText('script')->nullable();
            $table->boolean('status')->default(1);
            $table->json('data')->nullable();
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
        Schema::dropIfExists('pages');
    }
};
