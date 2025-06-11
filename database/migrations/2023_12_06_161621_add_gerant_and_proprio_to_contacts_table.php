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
        Schema::table('contacts', function (Blueprint $table) {

            // Assurez-vous que ces champs n'existent pas déjà avant de les ajouter
            $table->string('codgerant', 16)->nullable()->after('codunique');
            $table->string('codproprio', 16)->nullable()->after('codunique');

            // Ajouter les clés étrangères
            //            $table->foreign('codgerant')->references('codegerant')->on('gerant_imms');
            //            $table->foreign('codproprio')->references('Propriocd')->on('app_proprios');
        });

        //        Schema::table('gerant_imms', function (Blueprint $table) {
        //            $table->dropColumn(['codegerant']);
        //            $table->foreignId('codegerant')->nullable()->constrained('contacts', 'codgerant')->onDelete('cascade');
        //        });
        //
        //        Schema::table('app_proprios', function (Blueprint $table) {
        //            $table->dropColumn(['Propriocd']);
        //            $table->foreignId('Propriocd')->nullable()->constrained('contacts', 'codproprio')->onDelete('cascade');
        //        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            //            $table->dropForeign(['codgerant']);
            //            $table->dropForeign(['codproprio']);
            $table->dropColumn(['codgerant', 'codproprio']);
            //            $table->dropColumn(['codproprio']);
        });
        //        Schema::table('gerant_imms', function (Blueprint $table) {
        //            $table->dropForeign(['codegerant']);
        //        });
        //        Schema::table('app_proprios', function (Blueprint $table) {
        //            $table->dropForeign(['Propriocd']);
        //        });
    }
};
