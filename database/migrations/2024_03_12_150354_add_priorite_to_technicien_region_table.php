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
        Schema::table('technicien_region', function (Blueprint $table) {
            $table->integer('priorite')->nullable()->after('region_id');

        });
    }


    public function down()
    {
        Schema::table('technicien_region', function (Blueprint $table) {
            $table->dropColumn('priorite');
        });
    }
};
