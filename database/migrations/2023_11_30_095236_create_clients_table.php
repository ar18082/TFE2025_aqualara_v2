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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli')->unique()->nullable();
            $table->string('reftr', 24)->nullable();
            $table->string('nom', 70)->nullable();
            $table->string('rue', 70)->nullable();
            $table->string('codepays', 6)->nullable();
            $table->string('codepost', 12)->nullable();
            $table->string('tel', 30)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('refcli', 30)->nullable();
            $table->string('respimm', 70)->nullable();
            $table->string('gerant', 70)->nullable();
            $table->string('rueger', 70)->nullable();
            $table->string('codepaysger', 6)->nullable();
            $table->string('codepostger', 12)->nullable();
            $table->string('telger', 30)->nullable();
            $table->string('faxger', 30)->nullable();
            $table->string('devise', 6)->nullable();
            $table->string('remarque', 300)->nullable();
            $table->string('datefin', 50)->nullable();
            $table->string('dernierreleve', 12)->nullable();
            $table->boolean('adk')->default(false);
            $table->string('codlngdec', 8)->nullable();
            $table->string('codfichier', 16)->nullable();
            $table->string('codegerant', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
