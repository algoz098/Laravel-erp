<?php namespace App\Http\Controllers;

use View;
use App\Erp_configs as Configs;
//You can create a BaseController:

class BaseController extends Controller {
    #public $variable1 = "I am Data";

    public function __construct() {

       $modulo_atendimentos = Configs::where('field', 'modulo_atendimentos')->pluck('value')->first();

       View::share ( 'modulo_atendimentos', $modulo_atendimentos );
    }

}
