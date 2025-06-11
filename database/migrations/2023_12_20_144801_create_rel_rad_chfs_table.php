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
        Schema::create('rel_rad_chfs', function (Blueprint $table) {
            $table->id('id');
            $table->integer('Codecli')->nullable();
            $table->integer('RefAppTR')->nullable();
            $table->string('DatRel', 50)->nullable();
            $table->string('Numcal', 16)->nullable();
            $table->decimal('Nvidx', 18, 2)->nullable();
            $table->string('StatutImp', 16)->nullable();
            $table->string('DatRelFich', 50)->nullable();
            $table->string('FileName', 122)->nullable();
            $table->integer('NumImp')->nullable();
            $table->string('Erreur', 46)->nullable();
            $table->string('StatutRel', 11)->nullable();
            $table->tinyInteger('RelPrinc')->nullable();
            $table->string('DatImp', 50)->nullable();
            $table->integer('hh_imp')->nullable();
            $table->integer('mm_imp')->nullable();
            $table->tinyInteger('Ok_Site')->nullable();
            $table->decimal('Coef', 18, 2)->nullable();
            $table->decimal('AncIdx', 18, 2)->nullable();
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
        Schema::dropIfExists('rel_rad_chfs');
    }
};
