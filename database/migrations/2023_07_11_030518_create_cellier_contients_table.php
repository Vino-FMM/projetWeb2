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
        Schema::create('vino__cellier_contient', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedBigInteger('vino__cellier_id');
            $table->unsignedBigInteger('vino__bouteille_id');
            $table->unsignedBigInteger('vino__type_id');
            $table->string('nom', 200);
            $table->string('pays', 50)->nullable();
            $table->string('description', 200)->nullable();
            $table->dateTime('date_ajout');
            $table->string('garde_jusqua', 200)->nullable();
            $table->string('notes', 200)->nullable();
            $table->float('prix')->nullable();
            $table->string('format', 20)->nullable();
            $table->unsignedBigInteger('quantite');
            $table->integer('millesime')->nullable();

            $table->primary(['id', 'vino__cellier_id', 'vino__bouteille_id', 'vino__type_id']);
            $table->index('vino__bouteille_id');
            $table->index('vino__cellier_id');
            $table->index('vino__type_id');

            $table->foreign('vino__type_id')
                ->references('id')
                ->on('vino__type')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('vino__bouteille_id')
                ->references('id')
                ->on('vino__bouteille')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('vino__cellier_id')
                ->references('id')
                ->on('vino__cellier')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cellier_contients');
    }
};
