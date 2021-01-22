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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body')->nullable();
            $table->bigInteger('view_count')->default(0);
            $table->string('status')->default('pending');
            $table->text('denied_reason')->nullable();
            $table->boolean('featured')->default(0);
            $table->boolean('is_update')->default(0);
            $table->boolean('is_free')->default(1);
            $table->boolean('is_published')->default(0);
            $table->string('visible_date')->nullable();
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
        Schema::dropIfExists('blog_posts');
    }
};
