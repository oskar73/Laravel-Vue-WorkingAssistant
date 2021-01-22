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
        Schema::create('mail_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->unsignedBigInteger('domain_id')->nullable();
            $table->string('username');
            $table->string('email');
            $table->string('name');
            $table->string('quota')->nullable();
            $table->boolean('force_password_update')->default(0);
            $table->boolean('sogo_access')->default(1);
            $table->string('status')->default('active');
            $table->timestamps();
            $table->foreign('domain_id')
                ->references('id')->on('mail_domains')
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
        Schema::dropIfExists('mail_accounts');
    }
};
