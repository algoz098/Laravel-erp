<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
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
          'tipo' => "0",
          'active' => "0",
          'sociabilidade' => "1",
          'created_at' => Carbon::now()->format('Y-m-d H:i:s')
      ]);
      DB::table('users')->insert([
          'contatos_id' => "1",
          'email' => "empresa",
          'password' => bcrypt('123mudar'),
          'ativo' => 1,
          'trabalho_id' => 1,
          'perms' => '{"admin":"1","contatos":{"leitura":"1", "edicao":"1", "adicao":"1"},"bancos":{"leitura":"1", "edicao":"1", "adicao":"1"},"atendimentos":{"leitura":"1", "edicao":"1", "adicao":"1"},"tickets":{"leitura":"1", "edicao":"1", "adicao":"1"},"contas":{"leitura":"1", "edicao":"1", "adicao":"1"},"caixas":{"leitura":"1", "edicao":"1", "adicao":"1"},"vendas":{"leitura":"1", "edicao":"1", "adicao":"1"},"estoques":{"leitura":"1", "edicao":"1", "adicao":"1"},"frotas":{"leitura":"1", "edicao":"1", "adicao":"1"}}'
      ]);
    }
}
