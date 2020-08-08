<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function ordenesPagar(){
        return view('user.user-ordenes-pagar');
    }
}
