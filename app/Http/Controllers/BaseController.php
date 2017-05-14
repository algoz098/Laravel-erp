<?php namespace App\Http\Controllers;

use View;
use Auth;
use ErpSnippets;
use Config;

use App\Erp_configs as Configs;
use App\Attachments as Attachs;

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
      $modulo_contas = Configs::where('field', 'modulo_contas')->pluck('value')->first();
      $modulo_caixas = Configs::where('field', 'modulo_caixas')->pluck('value')->first();
      $modulo_vendas = Configs::where('field', 'modulo_vendas')->pluck('value')->first();
      $modulo_estoques = Configs::where('field', 'modulo_estoques')->pluck('value')->first();
      $modulo_frotas = Configs::where('field', 'modulo_frotas')->pluck('value')->first();
      $modulo_bancos = Configs::where('field', 'modulo_bancos')->pluck('value')->first();

      View::share ( 'imagem_destaque', $imagem_destaque );
      View::share ( 'modulo_atendimentos', $modulo_atendimentos );
      View::share ( 'modulo_tickets', $modulo_tickets );
      View::share ( 'modulo_contas', $modulo_contas );
      View::share ( 'modulo_caixas', $modulo_caixas );
      View::share ( 'modulo_vendas', $modulo_vendas );
      View::share ( 'modulo_estoques', $modulo_estoques );
      View::share ( 'modulo_frotas', $modulo_frotas );
      View::share ( 'modulo_bancos', $modulo_bancos );

    }

    public function menus(){
      $resposta = [];

      $menu = [];
      $modulos = ['contatos', 'atendimentos', 'contas', 'bancos', 'tickets', 'caixas', 'vendas', 'estoques', 'frotas'];
      $niveis = ['adicao', 'edicao', 'leitura'];

      foreach ($modulos as $key => $modulo) {
        foreach ($niveis as $key2 => $nivel) {
          if (isset(Auth::user()->perms[$modulo][$nivel]) or Auth::user()->perms[$modulo][$nivel]==1){
            if($nivel='adicao'){
              $menu['Novo'][$modulo] = 'novo/'.$modulo;
            }
            if($nivel='edicao'){
              $menu[$nivel][$modulo] = 'edicao/'.$modulo;
            }
            if($nivel='leitura'){
              $menu['Lista'][$modulo] = 'lista/'.$modulo.'/';
            }
          }
        }
      }

      if (isset(Auth::user()->perms["admin"]) and Auth::user()->perms["admin"]==1){
        $menu['admin']['Controle de Úsuario'] = 'admin';
        $menu['admin']['Configurações'] = 'admin/config';
        $menu['admin']['Atualização'] = 'admin/update';
        $menu['admin']['Backup'] = 'admin/backup';
        $menu['admin']['Logs'] = 'admin/logs';

        $menu['Combobox']['Painel'] = 'admin/combobox';
        $menu['Combobox']['Tipo de telefones'] = 'novo/combobox/telefone';

      }
      $resposta['menu'] = $menu;

      $resposta['erp_nome'] =  Config::get('app.name');

      return $resposta;
    }

}
