<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('releves', function (Blueprint $table) {
            $table->decimal('index', 18, 5)->change();
        });
    }

    public function down()
    {
        Schema::table('releves', function (Blueprint $table) {
            $table->integer('index')->change();
        });
    }
};
