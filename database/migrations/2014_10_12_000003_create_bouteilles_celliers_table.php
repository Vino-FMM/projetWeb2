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
        Schema::create('bouteilles_celliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('cellier_id');
            $table->foreign('cellier_id')->references('id')->on('celliers');
            $table->integer('quantite');
            $table->string('nom_bouteille');
            $table->string('format_bouteille');
            $table->decimal('prix_bouteille', 8, 2);
            $table->string('pays_bouteille');
            $table->string('code_saq_bouteille');
            $table->string('url_saq_bouteille');
            $table->string('url_img_bouteille');
            $table->integer('millesime_bouteille');
            $table->string('type_bouteille');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bouteilles_celliers');
    }
};
