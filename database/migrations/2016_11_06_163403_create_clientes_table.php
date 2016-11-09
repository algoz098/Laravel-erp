<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cpf_cnpj')->nullable();
            $table->string('ie')->nullable();
            $table->string('razao_social')->nullable();
            $table->string('nome_fantasia')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('andar')->nullable();
            $table->string('sala')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cep')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('contato1')->nullable();
            $table->string('contato2')->nullable();
            $table->string('departamento1')->nullable();
            $table->string('departament2')->nullable();
            $table->string('tel1')->nullable();
            $table->string('tel2')->nullable();
            $table->string('ramal1')->nullable();
            $table->string('ramal2')->nullable();
            $table->string('cel1')->nullable();
            $table->string('cel2')->nullable();
            $table->string('email1')->nullable();
            $table->string('email2')->nullable();
            $table->text('obs1')->nullable();
            $table->text('obs2')->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
