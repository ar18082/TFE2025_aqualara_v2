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
        Schema::table('appareils_erreurs', function (Blueprint $table) {
            // Ajouter la colonne de clé étrangère
            $table->unsignedBigInteger('appareil_id')->nullable();

            // Définir la contrainte de clé étrangère
            $table->foreign('appareil_id')->references('id')->on('appareils')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appareils_erreurs', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['appareil_id']);

            // Supprimer la colonne
            $table->dropColumn('appareil_id');
        });
    }
};
