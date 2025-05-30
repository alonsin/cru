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
        Schema::create('estado', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->timestamps();
            $table->softDeletes();
        });

         // Insertar los 32 estados de México
         DB::table('estado')->insert([
            ['id' => 1, 'name' => 'Aguascalientes'],
            ['id' => 2, 'name' => 'Baja California'],
            ['id' => 3, 'name' => 'Baja California Sur'],
            ['id' => 4, 'name' => 'Campeche'],
            ['id' => 5, 'name' => 'Chiapas'],
            ['id' => 6, 'name' => 'Chihuahua'],
            ['id' => 7, 'name' => 'Ciudad de México'],
            ['id' => 8, 'name' => 'Coahuila'],
            ['id' => 9, 'name' => 'Colima'],
            ['id' => 10, 'name' => 'Durango'],
            ['id' => 11, 'name' => 'Guanajuato'],
            ['id' => 12, 'name' => 'Guerrero'],
            ['id' => 13, 'name' => 'Hidalgo'],
            ['id' => 14, 'name' => 'Jalisco'],
            ['id' => 15, 'name' => 'Estado de México'],
            ['id' => 16, 'name' => 'Michoacán'],
            ['id' => 17, 'name' => 'Morelos'],
            ['id' => 18, 'name' => 'Nayarit'],
            ['id' => 19, 'name' => 'Nuevo León'],
            ['id' => 20, 'name' => 'Oaxaca'],
            ['id' => 21, 'name' => 'Puebla'],
            ['id' => 22, 'name' => 'Querétaro'],
            ['id' => 23, 'name' => 'Quintana Roo'],
            ['id' => 24, 'name' => 'San Luis Potosí'],
            ['id' => 25, 'name' => 'Sinaloa'],
            ['id' => 26, 'name' => 'Sonora'],
            ['id' => 27, 'name' => 'Tabasco'],
            ['id' => 28, 'name' => 'Tamaulipas'],
            ['id' => 29, 'name' => 'Tlaxcala'],
            ['id' => 30, 'name' => 'Veracruz'],
            ['id' => 31, 'name' => 'Yucatán'],
            ['id' => 32, 'name' => 'Zacatecas'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado');
    }
};
