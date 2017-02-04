<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cargo');
            $table->date('admissao');
            $table->string('status');
            $table->date('demissao');
            $table->string('endereco');
            $table->string('numero');
            $table->string('re');
            $table->string('cpf');
            $table->string('carteira_trab');
            $table->string('bloco');
            $table->string('rg');
            $table->string('salario');
            $table->string('apto');
            $table->string('cnh');
            $table->string('ajuda_custo');
            $table->string('bairro');
            $table->string('cnh_categoria');
            $table->string('peric');
            $table->string('cep');
            $table->string('cnh_vencimento');
            $table->string('vlr_peric');
            $table->string('cidade');
            $table->string('uf');
            $table->string('tel1');
            $table->string('tel2');
            $table->string('cel1');
            $table->string('cel2');
            $table->string('email1');
            $table->string('email2');
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
        Schema::dropIfExists('funcionarios');
    }
}
