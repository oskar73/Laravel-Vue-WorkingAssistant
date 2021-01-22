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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->string('domain_type')->nullable();
            $table->string('domain')->nullable();
            $table->string('name')->nullable();
            $table->string('status')->default('active');
            $table->string('status_by_owner')->default('active');
            $table->longText('css')->nullable();
            $table->longText('script')->nullable();
            $table->string('storage_limit')->default(0);
            $table->string('current_storage')->default(0);
            $table->string('module_limit')->default(0);
            $table->string('fmodule_limit')->default(0);
            $table->string('page_limit')->default(0);
            $table->text('module_url')->nullable();
            $table->unsignedBigInteger('template_id')->nullable();
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
        Schema::dropIfExists('websites');
    }
};
