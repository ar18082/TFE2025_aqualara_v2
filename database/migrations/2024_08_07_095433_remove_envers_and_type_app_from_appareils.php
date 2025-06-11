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
        Schema::table('appareils', function (Blueprint $table) {
            $table->dropColumn(['envers', 'typeApp']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appareils', function (Blueprint $table) {
            $table->string('envers')->nullable(); // Modifiez le type de données si nécessaire
            $table->string('typeApp')->nullable(); // Modifiez le type de données si nécessaire
        });
    }
};
