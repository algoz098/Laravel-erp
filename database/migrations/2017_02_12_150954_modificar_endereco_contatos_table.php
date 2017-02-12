<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarEnderecoContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contatos', function (Blueprint $table) {
          $table->dropColumn("andar");
          $table->dropColumn("sala");
          $table->string('numero')->nullable();
          $table->string('complemento')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contatos', function (Blueprint $table) {
          $table->dropColumn("complemento");
          $table->dropColumn("numero");
          $table->string('andar')->nullable();
          $table->string('sala')->nullable();

        });
    }
}
