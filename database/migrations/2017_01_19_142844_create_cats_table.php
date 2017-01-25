<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contatos_id');
            $table->string('hora')->nullable();
            $table->string('percurso')->nullable();
            $table->string('data')->nullable();
            $table->string('codigo')->nullable();
            $table->string('estado')->nullable();
            $table->string('obs')->nullable();
            $table->string('inicio')->nullable();
            $table->string('final')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('cats');
    }
}
