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
            $table->unsignedBigInteger('codeCli')->nullable();
            $table->unsignedBigInteger('refAppTR')->nullable();
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
            $table->dropColumn('codeCli');
            $table->dropColumn('refAppTR');
        });
    }
};
