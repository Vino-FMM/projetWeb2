<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCelliersTable extends Migration
{
    public function up()
    {
        Schema::create('celliers', function (Blueprint $table) {
            $table->id('id');
            $table->string('nom_cellier');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('celliers');
    }
}
?>