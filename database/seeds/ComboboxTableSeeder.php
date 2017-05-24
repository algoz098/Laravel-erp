<?php

use Illuminate\Database\Seeder;

class ComboboxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(XX) X XXXX-XXXX",
          'text' => "Cel Corp",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(XX) X XXXX-XXXX",
          'text' => "Cel Part",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(XX) X XXXX-XXXX",
          'text' => "Cel Rec",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(XX) XXXX-XXXX",
          'text' => "Tel Part",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(XX) XXXX-XXXX",
          'text' => "Tel Corp",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(XX) XXXX-XXXX",
          'text' => "Tel Rec",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "",
          'text' => "E-Mail Corp",
          'value' => "E-Mail"
      ]);

      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "",
          'text' => "E-Mail Part",
          'value' => "E-Mail"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas\Formas",
          'field' => "tipo",
          'value' => "Dinheiro",
          'text' => "Dinheiro"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas\Formas",
          'field' => "tipo",
          'value' => "Pagamento online",
          'text' => "Pagamento online"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas\Formas",
          'field' => "tipo",
          'value' => "Cartão de Credito",
          'text' => "Cartão de Credito"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas\Formas",
          'field' => "tipo",
          'value' => "Cartão de Debito",
          'text' => "Cartão de Debito"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas\Formas",
          'field' => "tipo",
          'value' => "Transferencia mesmo banco",
          'text' => "Transferencia mesmo banco"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas\Formas",
          'field' => "tipo",
          'value' => "Ted",
          'text' => "Ted"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas\Formas",
          'field' => "tipo",
          'value' => "Doc",
          'text' => "Doc"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Consumos",
          'field' => "tipo",
          'value' => "1001",
          'text' => "Conta de Agua"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Consumos",
          'field' => "tipo",
          'value' => "1002",
          'text' => "Conta de Energia Eletrica"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Consumos",
          'field' => "tipo",
          'value' => "1003",
          'text' => "Internet e Telefone"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Consumos",
          'field' => "tipo",
          'value' => "1004",
          'text' =>  "Gas encanado"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas",
          'field' => "tipo",
          'value' => "Prestação de serviços",
          'text' => "Prestação de serviços"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas",
          'field' => "tipo",
          'value' => "Material de Escritorio",
          'text' => "Material de Escritorio"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Contas",
          'field' => "tipo",
          'value' => "Diversos",
          'text' => "Diversos"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Relacionamento",
          'field' => "tipo",
          'value' => "Cliente",
          'text' => "Fornecedor"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Relacionamento",
          'field' => "tipo",
          'value' => "Fornecedor",
          'text' => "Cliente"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Relacionamento",
          'field' => "tipo",
          'value' => "Matriz",
          'text' => "Filial"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Relacionamento",
          'field' => "tipo",
          'value' => "Empresa",
          'text' => "Funcionario"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Relacionamento",
          'field' => "tipo",
          'value' => "Funcionario",
          'text' => "Empresa"
      ]);
    }
}
