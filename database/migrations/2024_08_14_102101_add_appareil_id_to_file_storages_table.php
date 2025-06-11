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
        Schema::table('file_storages', function (Blueprint $table) {
            $table->unsignedBigInteger('appareil_id')->nullable()->after('codeCli');

            // Si vous voulez ajouter une contrainte de clé étrangère :
            $table->foreign('appareil_id')->references('id')->on('appareils')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_storages', function (Blueprint $table) {
            // Supprimez la contrainte de clé étrangère si vous l'avez ajoutée
            $table->dropForeign(['appareil_id']);
            $table->dropColumn('appareil_id');
        });
    }
};
