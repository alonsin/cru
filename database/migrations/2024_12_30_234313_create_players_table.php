<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id(); // id: campo autoincrementable
            $table->string('name_player'); // name_player: nombre del jugador
            $table->unsignedBigInteger('id_state'); // id_state: clave foránea a la tabla states
            $table->unsignedBigInteger('id_category_player'); // id_category_player: clave foránea a la tabla category_players
            $table->unsignedBigInteger('id_club_player'); // id_club_player: clave foránea a la tabla club_players
            $table->integer('edad')->nullable(); // edad: campo opcional que puede ser NULL

            // Definir las claves foráneas
            $table->foreign('id_state')->references('id')->on('estado')->onDelete('cascade');
            $table->foreign('id_category_player')->references('id')->on('categoryplayer')->onDelete('cascade');
            $table->foreign('id_club_player')->references('id')->on('clubplayer')->onDelete('cascade');

            $table->timestamps(); // created_at y updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
