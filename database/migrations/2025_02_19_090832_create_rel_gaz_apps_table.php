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
        Schema::create('rel_gaz_apps', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli');
            $table->integer('RefAppTR');
            $table->date('DatRel')->nullable();
            $table->decimal('FraisDiv', 18, 2)->nullable();
            $table->string('Rem1')->nullable();
            $table->string('Rem2')->nullable();
            $table->decimal('PctFraisAnn', 18,2)->nullable();
            $table->integer('NbCpt')->nullable();
            $table->string('RmqOcc')->nullable();
            $table->decimal('NbFraisTR', 18,2)->nullable();
            $table->timestamps();

        


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_gaz_apps');
    }
};
