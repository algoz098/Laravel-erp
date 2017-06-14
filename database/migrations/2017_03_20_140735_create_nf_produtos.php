<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNfProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nf_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notas_id');
            $table->integer('produtos_id');
            $table->string('ncm');
            $table->string('quantidade');
            $table->string('valor');
            $table->string('icms');
            $table->string('ipi');
            $table->string('total');
            $table->string('total_icms');
            $table->string('total_ipi');
            $table->string('tipo')->nullable();
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
        Schema::dropIfExists('nf_produtos');
    }
}
