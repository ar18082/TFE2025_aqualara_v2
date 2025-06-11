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
        Schema::table('notes_appartements', function (Blueprint $table) {
            $table->unsignedBigInteger('appareil_id')->nullable()->after('user_id');

            // Optionnel : ajouter une clé étrangère si nécessaire
            $table->foreign('appareil_id')->references('id')->on('appareils')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes_appartements', function (Blueprint $table) {
            // Optionnel : supprimer la clé étrangère si elle a été créée
            $table->dropForeign(['appareil_id']);

            $table->dropColumn('appareil_id');
        });
    }
};
