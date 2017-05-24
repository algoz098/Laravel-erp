<?php

use Illuminate\Database\Seeder;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('erp_configs')->insert([
          'field' => "field_codigo",
          'value' => "0",
          'options' => "",
          'text' => "Campo 'Codigo'"
      ]);
      DB::table('erp_configs')->insert([
          'field' => "img_destaque",
          'value' => "0",
          'options' => "",
          'text' => "Imagem de destaque"
      ]);
      DB::table('erp_configs')->insert([
          'field' => "modulo_atendimentos",
          'value' => "1",
          'options' => "",
          'text' => 'Modulo "Atendimentos"'
      ]);
    }
}
