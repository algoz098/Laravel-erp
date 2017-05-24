<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('funcionarios');
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contatos_id');
            $table->string('cargo')->nullable();
            $table->string('estado')->nullable();
            $table->string('data_adm')->nullable();
            $table->string('data_dem')->nullable();
            $table->string('cnh')->nullable();
            $table->string('cnh_cat')->nullable();
            $table->string('cnh_venc')->nullable();
            $table->string('cart_trab_num')->nullable();
            $table->string('cart_trab_serie')->nullable();
            $table->string('eleitor')->nullable();
            $table->string('eleitor_sessao')->nullable();
            $table->string('eleitor_zona')->nullable();
            $table->string('eleitor_exp')->nullable();
            $table->string('pis')->nullable();
            $table->string('pis_banco')->nullable();
            $table->string('inss')->nullable();
            $table->string('rg_exp')->nullable();
            $table->string('rg_pai')->nullable();
            $table->string('rg_mae')->nullable();
            $table->string('ajuda_custo')->nullable();
            $table->string('reservista')->nullable();
            $table->string('sal')->nullable();
            $table->string('sal_real')->nullable();
            $table->string('sal_inss')->nullable();
            $table->string('vt')->nullable();
            $table->string('vt_percentual')->nullable();
            $table->string('va')->nullable();
            $table->string('vr')->nullable();
            $table->string('peri')->nullable();
            $table->string('peri_percentual')->nullable();
            $table->string('com_fixo')->nullable();
            $table->string('com_perc')->nullable();
            $table->string('meta')->nullable();
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
        Schema::dropIfExists('funcionarios');
    }
}
