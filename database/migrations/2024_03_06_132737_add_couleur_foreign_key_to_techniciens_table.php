<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('techniciens', function (Blueprint $table) {
            // Ajoutez la colonne couleur_id si elle n'existe pas déjà
            if (!Schema::hasColumn('techniciens', 'couleur_id')) {
                $table->bigInteger('couleur_id')->unsigned()->nullable();
            }

            // Ajoutez la contrainte de clé étrangère
            $table->foreign('couleur_id')
                ->references('id')
                ->on('couleur_technicien')
                ->onDelete('cascade'); // Modifiez si nécessaire
        });
    }

    public function down()
    {
        Schema::table('techniciens', function (Blueprint $table) {
            // Supprimez la contrainte de clé étrangère
            $table->dropForeign(['couleur_id']);

            // Supprimez la colonne couleur_id si nécessaire
            $table->dropColumn('couleur_id');
        });
    }
};
