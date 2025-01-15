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
        Schema::create('type_tournament', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('type_tournament')->insert([
            ['id' => 1, 'name' => 'Abierto Mensual'],
            ['id' => 2, 'name' => 'Segundas Mensual'],
            ['id' => 3, 'name' => 'Primeras Nacional'],
            ['id' => 4, 'name' => 'Segundas Nacional'],
            ['id' => 5, 'name' => 'Primeras Nacional Con Promedios'],
            ['id' => 6, 'name' => 'Segundas Nacional Con Promedios'],
            ['id' => 7, 'name' => 'Semanal Viernes'],
            ['id' => 8, 'name' => 'Calenton'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_tournament');
    }
};
