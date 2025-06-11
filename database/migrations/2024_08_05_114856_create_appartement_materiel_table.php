<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appartement_materiel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appartement_id');
            $table->unsignedBigInteger('materiel_id');
            $table->string('referenceMateriel');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('appartement_id')->references('id')->on('appartements')->onDelete('cascade');
            $table->foreign('materiel_id')->references('id')->on('materiels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appartement_materiel');
    }
};
