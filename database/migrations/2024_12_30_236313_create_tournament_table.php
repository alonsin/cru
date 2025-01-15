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
        Schema::create('tournament', function (Blueprint $table) {
            $table->id(); // id: campo autoincrementable
            $table->string('name_tournament'); // name_player: nombre del jugador
            $table->unsignedBigInteger('id_sede'); // id_state: clave foránea a la tabla states
            $table->unsignedBigInteger('id_type'); // id_category_player: clave foránea a la tabla category_players
            $table->unsignedBigInteger('id_format'); // id_club_player: clave foránea a la tabla club_players
            $table->date('fecha_torneo');

            // Definir las claves foráneas
            $table->foreign('id_sede')->references('id')->on('sede_tournament')->onDelete('cascade');
            $table->foreign('id_type')->references('id')->on('type_tournament')->onDelete('cascade');
            $table->foreign('id_format')->references('id')->on('format_tournament')->onDelete('cascade');

            $table->timestamps(); // created_at y updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament');
    }
};
