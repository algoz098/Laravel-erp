<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;

class AdminController extends Controller
{
    public function index(){
      $users = User::all();
      return view('admin.index')->with('users', $users);
      #return $users[0]->roles;
    }
}
