<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('provisions', function (Blueprint $table) {
            $table->id();
            $table->string('Codecli');
            $table->integer('RefAppTR');
            $table->decimal('montant', 10, 2);
            $table->enum('type_repartition', ['APPART', 'NBAPP', 'NBQUOT', 'CLE']);
            $table->date('date_decompte');
            $table->timestamps();

          
        });
    }

    public function down()
    {
        Schema::dropIfExists('provisions');
    }
}; 