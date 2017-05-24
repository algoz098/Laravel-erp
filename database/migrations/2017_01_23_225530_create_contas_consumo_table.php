<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContasConsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('contas', function (Blueprint $table) {
          $table->dropColumn('mes_ano');
      });
        Schema::create('contas_consumos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contas_id');
            $table->string('codigo')->nullable();
            $table->string('mes')->nullable();
            $table->string('consumo')->nullable();
            $table->string('cat')->nullable();
            $table->string('valor_anterior')->nullable();
            $table->string('valor_atual')->nullable();
            $table->string('sub_item1')->nullable();
            $table->string('sub_item2')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('contas_consumos');
        Schema::table('contas', function (Blueprint $table) {
            $table->string('mes_ano')->nullable();
        });
    }
}
