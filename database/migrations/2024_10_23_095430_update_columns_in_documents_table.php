<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Rendre la colonne client_id nullable
            $table->unsignedBigInteger('client_id')->nullable()->change();
            // Rendre la colonne send_at nullable
            $table->timestamp('send_at')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Revert client_id to not nullable
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
            // Revert send_at to not nullable
            $table->timestamp('send_at')->nullable(false)->change();
        });
    }
};
