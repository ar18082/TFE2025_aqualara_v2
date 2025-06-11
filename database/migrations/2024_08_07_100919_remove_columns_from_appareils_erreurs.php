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
            // Supprimer les contraintes de clé étrangère
            $table->dropForeign(['rel_chauf_id']);
            $table->dropForeign(['rel_eau_c_s_id']);
            $table->dropForeign(['rel_eau_f_s_id']);
            $table->dropForeign(['rel_rad_chfs_id']);
            $table->dropForeign(['rel_rad_eaus_id']);

            // Supprimer les colonnes
            $table->dropColumn(['rel_chauf_id', 'rel_eau_c_s_id', 'rel_eau_f_s_id', 'rel_rad_chfs_id', 'rel_rad_eaus_id']);
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
            // Ajouter les colonnes
            $table->unsignedBigInteger('rel_chauf_id')->nullable();
            $table->unsignedBigInteger('rel_eau_c_s_id')->nullable();
            $table->unsignedBigInteger('rel_eau_f_s_id')->nullable();
            $table->unsignedBigInteger('rel_rad_chfs_id')->nullable();
            $table->unsignedBigInteger('rel_rad_eaus_id')->nullable();

            // Ajouter les contraintes de clé étrangère
            $table->foreign('rel_chauf_id')->references('id')->on('another_table')->onDelete('cascade');
            $table->foreign('rel_eau_c_s_id')->references('id')->on('another_table')->onDelete('cascade');
            $table->foreign('rel_eau_f_s_id')->references('id')->on('another_table')->onDelete('cascade');
            $table->foreign('rel_rad_chfs_id')->references('id')->on('another_table')->onDelete('cascade');
            $table->foreign('rel_rad_eaus_id')->references('id')->on('another_table')->onDelete('cascade');
        });
    }
};
