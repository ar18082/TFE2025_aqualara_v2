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
        Schema::create('status_techniciens', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps(); // Ajoute automatiquement les colonnes "created_at" et "updated_at"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_techniciens');
    }
};
