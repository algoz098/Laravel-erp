<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $this->call(ContatosTableSeeder::class);
      $this->call(ComboboxTableSeeder::class);
      $this->call(ConfigsTableSeeder::class);
    }
}
