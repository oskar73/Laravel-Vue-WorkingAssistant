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
        Schema::create('ecommerce_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->boolean('recurrent')->default(1);
            $table->boolean('stripe')->default(1);
            $table->string('plan_id')->nullable();
            $table->string('period')->nullable();
            $table->string('period_unit')->nullable();
            $table->string('price')->nullable();
            $table->string('slashed_price')->nullable();
            $table->boolean('standard')->default(0);
            $table->timestamps();
            $table->foreign('product_id')
                ->references('id')->on('ecommerce_products')
                ->onDelete('cascade');
            $table->foreign('color_id')
                ->references('id')->on('ecommerce_colors')
                ->onDelete('cascade');
            $table->foreign('size_id')
                ->references('id')->on('ecommerce_sizes')
                ->onDelete('cascade');
            $table->foreign('variant_id')
                ->references('id')->on('ecommerce_variants')
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
        Schema::dropIfExists('ecommerce_prices');
    }
};
