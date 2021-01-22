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
        Schema::create('ecommerce_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->boolean('featured')->default(0);
            $table->boolean('new')->default(0);
            $table->boolean('status')->default(1);
            $table->integer('order')->nullable();
            $table->string('visible_date')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->text('links')->nullable();
            $table->boolean('track_quantity')->default(0);
            $table->boolean('continue_selling')->default(1);
            $table->bigInteger('quantity')->nullable();
            $table->string('type');
            $table->string('weight')->nullable();
            $table->string('weight_unit')->nullable();
            $table->boolean('size')->default(0);
            $table->boolean('color')->default(0);
            $table->boolean('variant')->default(0);
            $table->string('variant_name')->nullable();
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
        Schema::dropIfExists('ecommerce_products');
    }
};
