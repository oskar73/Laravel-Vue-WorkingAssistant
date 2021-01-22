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
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->longText('content')->nullable();
            $table->longText('css')->nullable();
            $table->longText('script')->nullable();
            $table->longText('mainCss')->nullable();
            $table->longText('sectionCss')->nullable();
            $table->timestamps();
            $table->foreign('web_id')
                ->references('id')->on('websites')
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
        Schema::dropIfExists('footers');
    }
};
