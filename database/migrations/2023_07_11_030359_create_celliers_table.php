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
        Schema::create('vino__cellier', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('nom', 200);
            $table->unsignedBigInteger('vino__utilisateur_id');

            $table->primary(['id', 'vino__utilisateur_id']);
            $table->index('vino__utilisateur_id');

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
        Schema::dropIfExists('celliers');
    }
};
