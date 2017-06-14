<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComboboxTextableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combobox_texts', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('combobox_textable_id');
          $table->string('combobox_textable_type');
          $table->string('field');
          $table->string('value');
          $table->string('text');
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
        Schema::dropIfExists('combobox_texts');
    }
}
