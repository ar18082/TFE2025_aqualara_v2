<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('releves', function (Blueprint $table) {

            $table->dropForeign(['appareil_id']);
        });
    }

    public function down()
    {
        Schema::table('releves', function (Blueprint $table) {

            $table->foreign('appareil_id')->references('id')->on('appareil');
        });
    }

};
