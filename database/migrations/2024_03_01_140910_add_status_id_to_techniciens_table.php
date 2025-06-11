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
        Schema::table('techniciens', function (Blueprint $table) {
            // Assurez-vous que la colonne n'existe pas déjà avant de l'ajouter
            if (!Schema::hasColumn('techniciens', 'status_id')) {
                $table->bigInteger('status_id')->unsigned()->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('techniciens', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
};
