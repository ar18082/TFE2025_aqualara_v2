<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appareils', function (Blueprint $table) {

            $table->integer('RefAppTR')->nullable()->change();
            $table->string('numSerie')->nullable()->change();
            $table->string('TypeReleve')->nullable()->change();
            $table->decimal('coef', 18,5)->nullable()->change();
            $table->string('sit')->nullable()->change();
            $table->integer('numero')->nullable()->change();
            $table->tinyInteger('envers')->nullable()->change();
            $table->string('typeApp')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appareils', function (Blueprint $table) {

            $table->integer('RefAppTR')->nullable()->change();
            $table->string('numSerie')->nullable()->change();
            $table->string('TypeReleve')->nullable()->change();
            $table->decimal('coef', 18,5)->nullable()->change();
            $table->string('sit')->nullable()->change();
            $table->integer('numero')->nullable()->change();
            $table->tinyInteger('envers')->nullable()->change();
            $table->string('typeApp')->nullable()->change();
        });
    }
};
