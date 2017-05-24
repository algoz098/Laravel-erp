<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campos_id')->nullable();
            $table->string('nome')->nullable();
            $table->string('barras')->nullable();
            $table->string('custo')->nullable();
            $table->string('tipo')->nullable();
            $table->string('grupo')->nullable();
            $table->string('unidade')->nullable();
            $table->text('descricao')->nullable();
            $table->integer('produtos_tipo_id')->nullable();
            $table->integer('fabricante_id')->nullable();
            $table->string('margem')->nullable();
            $table->string('venda')->nullable();
            $table->string('qtd_minima')->nullable();
            $table->string('qtd_maxima')->nullable();
            $table->string('embalagem')->nullable();
            $table->string('estado')->nullable();
            $table->string('aplicacao')->nullable();
            $table->string('peso')->nullable();
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
        Schema::dropIfExists('produtos');
    }
}
