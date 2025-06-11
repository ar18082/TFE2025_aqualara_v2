<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appareils_erreurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rel_chauf_id');
            $table->unsignedBigInteger('rel_eau_c_s_id');
            $table->unsignedBigInteger('rel_eau_f_s_id');
            $table->unsignedBigInteger('rel_rad_chfs_id');
            $table->unsignedBigInteger('rel_rad_eaus_id');
            $table->unsignedBigInteger('type_erreur_id');


            // Définissez les clés étrangères
            $table->foreign('rel_chauf_id')->references('id')->on('rel_chaufs');
            $table->foreign('rel_eau_c_s_id')->references('id')->on('rel_eau_c_s');
            $table->foreign('rel_eau_f_s_id')->references('id')->on('rel_eau_f_s');
            $table->foreign('rel_rad_chfs_id')->references('id')->on('rel_rad_chfs');
            $table->foreign('rel_rad_eaus_id')->references('id')->on('rel_rad_eaus');
            $table->foreign('type_erreur_id')->references('id')->on('type_erreurs');
            // Ajoutez d'autres contraintes de clé étrangère selon vos besoins

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appareils_erreurs');
    }
};
