<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //funcion que retorna a la vista de ordenes pagar del usuario
    public function ordenesPagar(){
        
        return view('user.user-ordenes-pagar');
    }
    //funcion que retorna a la vista de lista de todas las ordenes
    public function listaOrdenes(){
        return view('user.user-lista-ordenes');
    }
}
