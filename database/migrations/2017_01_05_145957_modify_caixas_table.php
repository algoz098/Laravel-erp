<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCaixasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caixas', function (Blueprint $table) {
            $table->dropColumn("vendas_id");
            $table->dropColumn("tipo");
            $table->dropColumn("forma");
            $table->dropColumn("pag");
            $table->string("estado")->nullable();
            $table->integer("contatos_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caixas', function (Blueprint $table) {
          $table->string("vendas_id")->nullable();
          $table->string("tipo")->nullable();
          $table->string("forma")->nullable();
          $table->string("pag")->nullable();
          $table->dropColumn("estado");
          $table->dropColumn("contatos_id");
        });
    }
}
