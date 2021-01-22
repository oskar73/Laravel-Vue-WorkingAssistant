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
        Schema::create('mail_domains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_id')->nullable();
            $table->string('domain_type')->nullable();
            $table->string('domain');
            $table->string('description')->nullable();
            $table->string('max_aliases')->nullable();
            $table->string('max_mail_boxes')->nullable();
            $table->string('default_mailbox_quota')->nullable();
            $table->string('max_quota_per_mailbox')->nullable();
            $table->string('total_quota')->nullable();
            $table->string('rate_limit')->nullable();
            $table->string('rate_limit_unit')->nullable();
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
        Schema::dropIfExists('mail_domains');
    }
};
