<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Erp_configs as Configs;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      $modulo_atendimentos = Configs::where('field', "modulo_atendimentos")->pluck('value')->first();
      view()->share('modulo_atendimentos', $modulo_atendimentos);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
