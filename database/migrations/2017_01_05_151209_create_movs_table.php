<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('caixas_id')->nullable();
            $table->double('valor')->nullable();
            $table->string('tipo')->nullable();
            $table->string('estado')->nullable();
            $table->string('nome')->nullable();
            $table->text('obs')->nullable();
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
        Schema::dropIfExists('movs');
    }
}
