<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // Rendre les colonnes client_id et type_event_id nullable
            $table->unsignedBigInteger('client_id')->nullable()->change();
            $table->unsignedBigInteger('type_event_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Remettre les colonnes comme elles étaient avant
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
            $table->unsignedBigInteger('type_event_id')->nullable(false)->change();
        });
    }
};
