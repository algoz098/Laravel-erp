<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNfEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nf_entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filiais_id');
            $table->integer('fornecedor_id');
            $table->string('estado')->nullable();
            $table->string('numero');
            $table->string('total');
            $table->string('frete');
            $table->string('transportadora');
            $table->string('seguro');
            $table->string('icms');
            $table->string('icms_substituicao')->nullable();
            $table->string('acrescimo');
            $table->string('desconto');
            $table->text('obs')->nullable();
            $table->integer('criado_por');
            $table->integer('atualizado_por')->nullable();
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
        Schema::dropIfExists('nf_entradas');
    }
}
