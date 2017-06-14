<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string("codigo")->nullable();
            $table->string('tipo')->nullable();
            $table->string('nome')->nullable();
            $table->string('sobrenome')->nullable();
            $table->string("nascimento")->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('cod_prefeitura')->nullable();
            $table->string('sociabilidade')->nullable();
            $table->string('active')->nullable();
            $table->text('obs')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contatos');
    }
}
