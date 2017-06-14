<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Cons_IntController extends Controller
{
    public function index(){
      return view("cons_int.index");
    }
}
