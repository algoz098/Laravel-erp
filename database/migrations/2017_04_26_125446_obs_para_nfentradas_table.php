<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ObsParaNfentradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nf_entradas', function (Blueprint $table) {
            $table->text('obs')->nullable();
            $table->string('estado')->nullable('true')->change();
            $table->string('icms_substituicao')->nullable('true')->change();
            $table->string('atualizado_por')->nullable('true')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nf_entradas', function (Blueprint $table) {
          $table->dropColumn('obs');
          $table->string('estado')->nullable('false')->change();
          $table->string('icms_substituicao')->nullable('false')->change();
          $table->string('atualizado_por')->nullable('false')->change();
        });
    }
}
