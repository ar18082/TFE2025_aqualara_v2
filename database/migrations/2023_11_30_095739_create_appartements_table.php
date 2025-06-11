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
        Schema::create('appartements', function (Blueprint $table) {

            //            table :[Appartement]
            //
            //Codecli	int	Checked
            //RefAppTR	int	Checked
            //DesApp	varchar(40)	Checked
            //RefAppCli	varchar(30)	Checked
            //datefin	varchar(50)	Checked
            //lancod	int	Checked
            //bloc	int	Checked
            //proprietaire	varchar(30)	Checked
            //Cellule	varchar(16)	Checked
            //
            //Checked = nullable

            $table->id();
            $table->integer('Codecli')->nullable();
            $table->integer('RefAppTR')->nullable();
            $table->string('DesApp')->nullable();
            $table->string('RefAppCli')->nullable();
            $table->string('datefin')->nullable();
            $table->integer('lancod')->nullable();
            $table->integer('bloc')->nullable();
            $table->string('proprietaire')->nullable();
            $table->string('Cellule')->nullable();
            $table->timestamps();

            $table->foreign('Codecli')->references('Codecli')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartements');
    }
};
