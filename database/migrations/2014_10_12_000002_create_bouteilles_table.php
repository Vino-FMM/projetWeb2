<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBouteillesTable extends Migration
{
    public function up()
    {
        Schema::create('bouteilles', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('format');
            $table->decimal('prix', 8, 2);
            $table->string('pays');
            // $table->unsignedBigInteger('pays_id');
            $table->string('code_saq');
            $table->string('url_saq');
            $table->string('url_img');
            
            // $table->date('date_achat');
            // $table->date('garde_jusqua');
            // $table->text('notes');
            // $table->integer('quantite');
            $table->integer('millesime');
            $table->string('type');
            // $table->unsignedBigInteger('cellier_id');
            // $table->foreign('cellier_id')->references('id')->on('celliers');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bouteilles');
    }
}
