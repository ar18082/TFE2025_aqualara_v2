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
        Schema::create('code_postelbs', function (Blueprint $table) {
            $table->id();
            $table->string('CodePays', 6)->nullable();
            $table->string('codePost', 12)->nullable();
            $table->string('Localite', 60)->nullable();
            $table->integer('Lancod')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_postelbs');
    }
};
