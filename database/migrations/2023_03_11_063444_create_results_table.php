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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade')->nullable();
            $table->string('category')->nullable();
            $table->foreignId('game')->constrained('games')->onDelete('cascade')->nullable();
            $table->text('distance')->nullable();
            $table->text('time')->nullable();
            $table->text('result')->nullable();
            $table->unique(['game', 'player_id']);
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
        Schema::dropIfExists('results');
    }
};
