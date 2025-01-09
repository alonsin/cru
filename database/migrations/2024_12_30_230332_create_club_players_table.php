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
        Schema::create('clubPlayer', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->timestamps();
            $table->softDeletes();
        });

         DB::table('clubPlayer')->insert([
            ['id' => 1, 'name' => 'Club Recreativo Universidad (CRU)'],
            ['id' => 2, 'name' => 'Parche'],
            ['id' => 3, 'name' => 'Carambola Cafe'],
            ['id' => 4, 'name' => 'Fenicia'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubPlayer');
    }
};
