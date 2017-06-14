<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contatos_id')->nullable();
            $table->integer('referente')->nullable();
            $table->integer('usuarios_id')->nullable();
            $table->integer('bancos_id')->nullable();
            $table->string('estado')->nullable();
            $table->string('tipo')->nullable();
            $table->string('nome')->nullable();
            $table->string('descricao')->nullable();
            $table->float('valor')->nullable();
            $table->string('vencimento')->nullable();
            $table->string("pagamento")->nullable();
            $table->double("desconto")->nullable();
            $table->string('dm')->nullable();
            $table->string('mes_ano')->nullable();
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
        Schema::dropIfExists('contas');
    }
}
