<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbastecimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abastecimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('frotas_id')->nullable();
            $table->string('data')->nullable();
            $table->string('combustivel')->nullable();
            $table->string('documento')->nullable();
            $table->string('lts')->nullable();
            $table->string('preco_lts')->nullable();
            $table->integer('contas_id')->nullable();
            $table->string('km_anterior')->nullable();
            $table->string('km_atual')->nullable();
            $table->string('km_rodado')->nullable();
            $table->string('km_lts')->nullable();
            $table->string('abastecido_em')->nullable();
            $table->string('abastecido_por')->nullable();
            $table->string('estado')->nullable();
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
        Schema::dropIfExists('abastecimentos');
    }
}
