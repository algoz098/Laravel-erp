<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemelhantesExternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semelhantes_externos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produtos_id');
            $table->string('codigo');
            $table->string('nome');
            $table->string('origem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semelhantes_externos');
    }
}
