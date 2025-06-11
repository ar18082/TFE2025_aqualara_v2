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
        Schema::table('materiels', function (Blueprint $table) {
            $table->dropColumn('temps_lecture');
            $table->dropColumn('temps_montage');
            $table->addColumn('integer', 'tps_RG')->nullable();
            $table->addColumn('integer', 'tps_plt')->nullable();
            $table->addColumn('integer', 'tps_rplt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materiels', function (Blueprint $table) {
            $table->addColumn('integer', 'temps_lecture')->nullable();
            $table->dropColumn('tps_RG');
            $table->addColumn('integer','temps_montage')->nullable();
            $table->dropColumn( 'tps_plt');
            $table->dropColumn('tps_rplt');
        });
    }
};
