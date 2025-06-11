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
        Schema::create('rel_chauf_apps', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli')->nullable();
            $table->integer('RefAppTR')->nullable();
            $table->string('DatRel', 50)->nullable();
            $table->decimal('FraisDiv', 18, 2)->nullable();
            $table->string('Rem1', 120)->nullable();
            $table->string('Rem2', 120)->nullable();
            $table->integer('NbRad')->nullable();
            $table->decimal('PctFraisAnn', 18, 2)->nullable();
            $table->string('RmqOcc', 40)->nullable();
            $table->decimal('NbFraisTR', 18, 2)->nullable();
            $table->decimal('AppQuot', 18, 2)->nullable();
            $table->timestamps();
            // Clé étrangère
            $table->foreign('Codecli')->references('Codecli')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_chauf_apps');
    }
};
