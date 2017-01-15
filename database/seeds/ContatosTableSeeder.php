<?php

use Illuminate\Database\Seeder;

class ContatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('contatos')->insert([
          'nome' => "Empresa",
          'tipo' => "0"
      ]);
      DB::table('users')->insert([
          'contatos_id' => "1",
          'email' => "empresa@exemplo.com",
          'password' => bcrypt('123mudar'),
          'ativo' => 1,
          'trabalho_id' => 1,
          'perms' => '{"admin":1}'
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9.9999-9999",
          'value' => "Cel",
          'text' => "Cel"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9.9999-9999",
          'value' => "Rec Cel",
          'text' => "Rec Cel"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9999-9999",
          'value' => "Fixo",
          'text' => "Fixo"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9999-9999",
          'value' => "Rec Fixo",
          'text' => "Rec Fixo"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9999-9999",
          'value' => "Coml",
          'text' => "Coml"
      ]);

      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "",
          'value' => "E-Mail Corp",
          'text' => "E-Mail Corp"
      ]);

      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "",
          'value' => "E-Mail Part",
          'text' => "E-Mail Part"
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
