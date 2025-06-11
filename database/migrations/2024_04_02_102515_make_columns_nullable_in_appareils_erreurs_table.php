<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appareils_erreurs', function (Blueprint $table) {
            $table->unsignedBigInteger('rel_chauf_id')->nullable()->change();
            $table->unsignedBigInteger('rel_eau_c_s_id')->nullable()->change();
            $table->unsignedBigInteger('rel_eau_f_s_id')->nullable()->change();
            $table->unsignedBigInteger('rel_rad_chfs_id')->nullable()->change();
            $table->unsignedBigInteger('rel_rad_eaus_id')->nullable()->change();
            $table->unsignedBigInteger('type_erreur_id')->nullable()->change();

        });
    }

    public function down()
    {
        Schema::table('appareils_erreurs', function (Blueprint $table) {

            $table->unsignedBigInteger('rel_chauf_id')->nullable(false)->change();
            $table->unsignedBigInteger('rel_eau_c_s_id')->nullable(false)->change();
            $table->unsignedBigInteger('rel_eau_f_s_id')->nullable(false)->change();
            $table->unsignedBigInteger('rel_rad_chfs_id')->nullable(false)->change();
            $table->unsignedBigInteger('rel_rad_eaus_id')->nullable(false)->change();
            $table->unsignedBigInteger('type_erreur_id')->nullable(false)->change();

        });
    }
};
