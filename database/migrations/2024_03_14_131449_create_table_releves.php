<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('releves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appareil_id');
            $table->foreign('appareil_id')->references('id')->on('appareils');
            $table->date('DatRel');
            $table->integer('index')->nullable();
            $table->string('statutImp')->nullable();
            $table->date('DatRelFich')->nullable();
            $table->string('FileName')->nullable();
            $table->integer('NumImp')->nullable();
            $table->string('Erreur')->nullable();
            $table->string('statutRel')->nullable();
            $table->string('RelPrinc')->nullable();
            $table->date('DatImp')->nullable();
            $table->integer('hh_imp')->nullable();
            $table->integer('mm_imp')->nullable();
            $table->boolean('Ok_Site')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('releves');
    }
};
