<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('format_tournament', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('format_tournament')->insert([
            ['id' => 1, 'name' => 'Grupos de 3'],
            ['id' => 2, 'name' => 'Grupos de 3 con Horarios'],
            ['id' => 3, 'name' => 'Grupos de 4'],
            ['id' => 4, 'name' => 'Grupos de 4 con Horarios'],
            ['id' => 5, 'name' => 'Eliminacion Directa'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_tournament');
    }
};
