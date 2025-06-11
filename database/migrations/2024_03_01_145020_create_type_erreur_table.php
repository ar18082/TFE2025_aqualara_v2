<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('type_erreurs', function (Blueprint $table) {
            $table->id(); // Ajoutez cette ligne si vous souhaitez une clé primaire automatiquement incrémentée
            $table->string('appareil');
            $table->string('nom');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_erreurs');
    }
};
