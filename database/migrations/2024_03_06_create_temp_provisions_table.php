<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('temp_provisions', function (Blueprint $table) {
            $table->id();
            $table->string('Codecli');
            $table->integer('RefAppTR');
            $table->decimal('montant', 10, 2)->nullable();
            $table->enum('type_repartition', ['APPART', 'NBAPP', 'NBQUOT', 'CLE']);
            $table->date('date_decompte');
            $table->timestamps();
            
            // Index pour une recherche rapide
            $table->index(['Codecli', 'RefAppTR', 'date_decompte']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('temp_provisions');
    }
}; 