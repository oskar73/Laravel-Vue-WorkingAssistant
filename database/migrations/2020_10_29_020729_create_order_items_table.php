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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->string('order_item_id');
            $table->boolean('recurrent');
            $table->string('product_type');
            $table->string('product_id');
            $table->integer('quantity');
            $table->string('sub_total');
            $table->text('product_detail');
            $table->text('price')->nullable();
            $table->boolean('paid')->nullable();
            $table->string('agreement_id')->nullable();
            $table->string('status')->nullable();
            $table->string('due_date')->nullable();
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
        Schema::dropIfExists('order_items');
    }
};
