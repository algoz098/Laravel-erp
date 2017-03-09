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
      DB::table('contatos')->insert([
          'nome' => "CPFL Paulista",
          'tipo' => "0",
      ]);
      DB::table('telefones')->insert([
          'contatos_id' => "2",
          'tipo' => "Atend.",
          'numero' => "0800 010 10 10​"
      ]);
      DB::table('contatos')->insert([
          'nome' => "DAAE",
          'tipo' => "0",
          'cidade' => "Araraquara"
      ]);
      DB::table('telefones')->insert([
          'contatos_id' => "3",
          'tipo' => "Atend.",
          'numero' => "0800 770 1595​"
      ]);
      DB::table('contatos')->insert([
          'nome' => "Sabesp",
          'tipo' => "0",
          'cidade' => "São Paulo"
      ]);
      DB::table('telefones')->insert([
          'contatos_id' => "4",
          'tipo' => "Metrop.",
          'numero' => "0800 011 9911"
      ]);
      DB::table('telefones')->insert([
          'contatos_id' => "4",
          'tipo' => "Interior",
          'numero' => "0800 055 0195"
      ]);
      DB::table('users')->insert([
          'contatos_id' => "1",
          'email' => "empresa",
          'password' => bcrypt('123mudar'),
          'ativo' => 1,
          'trabalho_id' => 1,
          'perms' => '{"admin":"1","contatos":{"leitura":"1", "edicao":"1", "adicao":"0"},"bancos":{"leitura":"1", "edicao":"1", "adicao":"0"},"atendimentos":{"leitura":"1", "edicao":"1", "adicao":"0"},"tickets":{"leitura":"1", "edicao":"1", "adicao":"0"},"contas":{"leitura":"1", "edicao":"1", "adicao":"0"},"caixas":{"leitura":"1", "edicao":"1", "adicao":"0"},"vendas":{"leitura":"1", "edicao":"1", "adicao":"0"},"estoques":{"leitura":"1", "edicao":"1", "adicao":"0"},"frotas":{"leitura":"1", "edicao":"1", "adicao":"0"}}'
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9 9999-9999",
          'text' => "Cel Corp",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9 9999-9999",
          'text' => "Cel Part",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9 9999-9999",
          'text' => "Cel Rec",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9999-9999",
          'text' => "Tel Part",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9999-9999",
          'text' => "Tel Corp",
          'value' => "Numero"
      ]);
      DB::table('combobox_texts')->insert([
          'combobox_textable_id' => "1",
          'combobox_textable_type' => "App\Telefones",
          'field' => "(99) 9999-9999",
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
