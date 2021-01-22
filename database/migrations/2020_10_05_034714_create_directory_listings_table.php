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
        Schema::create('directory_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->string('url')->nullable();
            $table->text('links')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->boolean('featured')->default(0);
            $table->boolean('new')->default(0);
            $table->text('property')->nullable();
            $table->string('expired_at')->nullable();
            $table->string('status')->default('pending');
            $table->integer('order')->nullable();
            $table->bigInteger('view_count')->default(0);
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
        Schema::dropIfExists('directory_listings');
    }
};
