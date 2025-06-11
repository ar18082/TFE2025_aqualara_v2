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
        Schema::create('contacts', function (Blueprint $table) {
            $table->index('codunique');
            $table->id();
            $table->string('p_g', 9)->nullable();
            $table->string('codunique', 16)->unique();
            //            $table->string('codgerant', 20)->nullable();
            //            $table->string('codproprio', 16)->nullable();
            $table->string('coduser', 60)->nullable();
            $table->boolean('inscrit')->default(false)->nullable();
            $table->boolean('desinsadm')->default(false)->nullable();
            $table->string('date_fin', 50)->nullable();
            $table->string('titre', 20)->nullable();
            $table->string('nom', 70)->nullable();
            $table->string('rue', 70)->nullable();
            $table->string('boite', 24)->nullable();
            $table->string('pays', 6)->nullable();
            $table->string('codpost', 12)->nullable();
            $table->string('tel', 30)->nullable();
            $table->string('gsm', 30)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('email1', 80)->nullable();
            $table->string('email2', 80)->nullable();
            $table->string('email3', 80)->nullable();
            $table->string('email4', 80)->nullable();
            $table->string('email5', 80)->nullable();
            $table->string('comment', 100)->nullable();
            $table->string('codlng', 8)->nullable();
            $table->string('codfichier', 20)->nullable();
            $table->string('pwd', 100)->nullable();
            $table->string('token', 100)->nullable();
            $table->string('token_date', 50)->nullable();
            $table->string('oldproprio', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
