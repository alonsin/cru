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


        Schema::create('categoryPlayer', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->timestamps();
            $table->softDeletes();
        });

         DB::table('categoryPlayer')->insert([
            ['id' => 1, 'name' => 'Segundas'],
            ['id' => 2, 'name' => 'Primeras'],
            ['id' => 3, 'name' => 'Maestro'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoryPlayer');
    }
};
