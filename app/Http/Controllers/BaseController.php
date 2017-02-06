<?php namespace App\Http\Controllers;

use View;
use App\Erp_configs as Configs;

use App\Attachments as Attachs;
//You can create a BaseController:

class BaseController extends Controller {
    #public $variable1 = "I am Data";

    public function __construct() {
      $imagem_destaque = Configs::where('field', 'img_destaque')->pluck('options')->first();
      if ($imagem_destaque!=""){
        $imagem_destaque = url('attach').'/'.$imagem_destaque;
      }
      if ($imagem_destaque==""){
        $imagem_destaque = asset('img_destaque.jpeg');
      }

      $modulo_atendimentos = Configs::where('field', 'modulo_atendimentos')->pluck('value')->first();
      $modulo_tickets = Configs::where('field', 'modulo_tickets')->pluck('value')->first();

      if($modulo_atendimentos=="" or $modulo_tickets==""){
        return redirect()->action('AdminController@configuration');
      }

      View::share ( 'imagem_destaque', $imagem_destaque );
      View::share ( 'modulo_atendimentos', $modulo_atendimentos );
      View::share ( 'modulo_tickets', $modulo_tickets );
    }

}
