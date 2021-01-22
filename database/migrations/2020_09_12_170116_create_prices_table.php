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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');
            $table->boolean('recurrent')->default(1);
            $table->boolean('stripe')->default(1);
            $table->string('plan_id')->nullable();
            $table->string('period')->nullable();
            $table->string('period_unit')->nullable();
            $table->string('price')->nullable();
            $table->string('slashed_price')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('standard')->default(0);
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
        Schema::dropIfExists('prices');
    }
};
