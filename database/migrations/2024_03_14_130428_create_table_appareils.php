<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appareils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codeCli')->constrained('clients');
            $table->string('RefAppTR');
            $table->string('numSerie');
            $table->string('TypeReleve');
            $table->decimal('coef', 18, 5);
            $table->string('sit');
            $table->string('numero');
            $table->string('envers');
            $table->string('typeApp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appareils');
    }
};
