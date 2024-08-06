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
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_url')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->enum('site_status', ['publish', 'closed'])->default('publish');
            $table->string('admin_paginate')->default(10);
            $table->string('posts_per_page')->default(20);
            $table->string('site_name');
            $table->string('site_slogan')->nullable();
            $table->string('site_meta_description')->nullable();
            $table->string('site_meta_keywords')->nullable();
            $table->string('close_msg')->nullable();
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
        Schema::dropIfExists('settings');
    }
};
