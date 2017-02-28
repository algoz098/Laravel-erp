<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComptabilidadeEstoquePodutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estoque', function (Blueprint $table) {
          $table->dropColumn('nome');
          $table->dropColumn('descricao');
          $table->dropColumn('valor_custo');
          $table->dropColumn('barras');
          $table->dropColumn('tipo');
          $table->dropColumn('unidade');
          $table->integer('produtos_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estoque', function (Blueprint $table) {
          $table->string('nome')->nullable();
          $table->string('descricao')->nullable();
          $table->string('valor_custo')->nullable();
          $table->string('barras')->nullable();
          $table->string('tipo')->nullable();
          $table->string('unidade')->nullable();
          $table->dropColumn('produtos_id');
        });
    }
}
