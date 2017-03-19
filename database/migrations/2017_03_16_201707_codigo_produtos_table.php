<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CodigoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
          $table->string('aplicacao')->nullable();
          $table->string('ncm')->nullable();
          $table->string('peso')->nullable();
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
          $table->dropColumn('aplicacao');
          $table->dropColumn('ncm');
          $table->dropColumn('peso');

        });
    }
}
