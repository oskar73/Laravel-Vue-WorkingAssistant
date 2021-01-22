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
        Schema::create('directory_ads_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('spot_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_item_id')->default(0);
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('url')->nullable();
            $table->string('cta_type')->nullable();
            $table->string('cta_url')->nullable();
            $table->integer('impression_number')->nullable();
            $table->integer('current_number')->default(0);
            $table->boolean('cta_action')->default(0);
            $table->string('status')->default('pending');
            $table->text('reason')->nullable();
            $table->json('price');
            $table->json('type');
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
        Schema::dropIfExists('directory_ads_listings');
    }
};
