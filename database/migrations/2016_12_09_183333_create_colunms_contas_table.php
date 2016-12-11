<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColunmsContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contas', function (Blueprint $table) {
            $table->integer('contatos_id')->nullable();
            $table->integer('referente')->nullable();
            $table->string('estado')->nullable();
            $table->string('tipo')->nullable();
            $table->string('nome')->nullable();
            $table->string('descricao')->nullable();
            $table->float('valor')->nullable();
            $table->date('vencimento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contas', function (Blueprint $table) {
            $table->dropColumn('contatos_id');
            $table->dropColumn('referente');
            $table->dropColumn('estado');
            $table->dropColumn('tipo');
            $table->dropColumn('nome');
            $table->dropColumn('descricao');
            $table->dropColumn('valor');
            $table->dropColumn('vencimento');
        });
    }
}
