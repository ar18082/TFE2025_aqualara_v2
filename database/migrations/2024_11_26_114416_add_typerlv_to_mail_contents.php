<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mail_contents', function (Blueprint $table) {
            $table->string('typeRlv')->nullable(); // Ajoute la colonne typeRlv
        });
    }

    public function down()
    {
        Schema::table('mail_contents', function (Blueprint $table) {
            $table->dropColumn('typeRlv'); // Supprime la colonne si on rollback
        });
    }
};
