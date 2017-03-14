$table->integer('contatos_id')->nullable();
$table->integer('contatos_id')->nullable();
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGruposProdutosTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
          $table->integer('produtos_tipo_id')->nullable();
          $table->integer('fabricante_id')->nullable();
          $table->string('margem')->nullable();
          $table->string('venda')->nullable();
          $table->string('qtd_minima')->nullable();
          $table->string('qtd_maxima')->nullable();
          $table->string('embalagem')->nullable();
          $table->string('estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
          $table->dropColumn('produtos_tipo_id');
          $table->dropColumn('fabricante_id');
          $table->dropColumn('margem');
          $table->dropColumn('venda');
          $table->dropColumn('qtd_minima');
          $table->dropColumn('qtd_maxima');
          $table->dropColumn('embalagem');
          $table->dropColumn('estado');
        });
    }
}
