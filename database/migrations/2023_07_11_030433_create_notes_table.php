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
        Schema::create('vino__note', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedBigInteger('vino__utilisateur_id');
            $table->unsignedBigInteger('vino__bouteille_id');
            $table->integer('note');
            $table->dateTime('date_creation');

            $table->primary('id');
            $table->index('vino__utilisateur_id');
            $table->index('vino__bouteille_id');

            $table->foreign('vino__bouteille_id')
                ->references('id')
                ->on('vino__bouteille')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('vino__utilisateur_id')
                ->references('id')
                ->on('vino__utilisateur')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
