<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vino__utilisateur', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('nom', 200);
            $table->string('prenom', 200);
            $table->string('courriel', 200);
            $table->string('mot_de_passe', 255);
            $table->dateTime('date_naissance');
            $table->string('confirmation', 27)->nullable();
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
