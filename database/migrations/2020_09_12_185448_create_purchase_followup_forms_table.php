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
        Schema::create('purchase_followup_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('purchase_followup_forms');
    }
};
