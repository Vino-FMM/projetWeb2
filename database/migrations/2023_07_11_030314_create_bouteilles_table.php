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
        Schema::create('vino__bouteille', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('nom', 200);
            $table->string('image', 200)->nullable();
            $table->string('code_saq', 50)->nullable();
            $table->string('pays', 50);
            $table->string('description', 200)->nullable();
            $table->float('prix_saq')->nullable();
            $table->string('url_saq', 200)->nullable();
            $table->string('url_img', 200)->nullable();
            $table->string('format', 20)->nullable();
            $table->unsignedBigInteger('vino__type_id');
            $table->timestamps();

            $table->primary(['id', 'vino__type_id']);
            $table->index('vino__type_id');

            $table->foreign('vino__type_id')->references('id')->on('vino__type')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bouteilles');
    }
};
