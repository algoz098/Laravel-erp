<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Erp_configs as Configs;
use View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);


        $imagem_destaque = Configs::where('field', 'img_destaque')->pluck('options')->first();
        if ($imagem_destaque!=""){
          $imagem_destaque = url('attach').'/'.$imagem_destaque;
        }
        if ($imagem_destaque==""){
          $imagem_destaque = asset('img_destaque.jpeg');
        }
        View::share ( 'imagem_destaque', $imagem_destaque );
    }

    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password, 'ativo' => '1'])) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }

}
