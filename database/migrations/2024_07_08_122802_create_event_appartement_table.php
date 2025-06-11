<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('event_appartement', function (Blueprint $table) {
            $table->id();  // Optionnel, Laravel ajoute une clé primaire auto-incrémentée
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table events
            $table->foreignId('appartement_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table appartements
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_appartement');
    }
};
