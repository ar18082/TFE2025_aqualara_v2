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
            // Ajouter la colonne de clé étrangère
            $table->unsignedBigInteger('materiel_id')->nullable();

            // Définir la contrainte de clé étrangère
            $table->foreign('materiel_id')->references('id')->on('materiels')->onDelete('set null');
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
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['materiel_id']);

            // Supprimer la colonne
            $table->dropColumn('materiel_id');
        });
    }
};
