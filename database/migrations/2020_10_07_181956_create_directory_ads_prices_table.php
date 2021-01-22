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
        Schema::create('directory_ads_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('spot_id');
            $table->string('type')->default('period');
            $table->integer('period')->nullable();
            $table->integer('impression')->nullable();
            $table->string('price')->nullable();
            $table->string('slashed_price')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('standard')->default(0);
            $table->timestamps();
            $table->foreign('spot_id')
                ->references('id')->on('directory_ads_spots')
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
        Schema::dropIfExists('directory_ads_prices');
    }
};
