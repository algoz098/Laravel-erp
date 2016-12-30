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
          'nome' => "Empresa"
      ]);
      DB::table('users')->insert([
          'contatos_id' => "1",
          'email' => "empresa@exemplo.com",
          'password' => bcrypt('123mudar'),
          'ativo' => 1,
          'trabalho_id' => 1,
          'perms' => '{"admin":1}'
      ]);
    }
}
