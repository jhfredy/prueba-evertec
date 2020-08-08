<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('user.user-home');
});
Route::get('/ordenesPagar','UserController@ordenesPagar')->name('ordenes-pagar');
Route::post('/guardarOrden','OrderController@guardarOrden')->name('guardar-orden');
Route::post('/pagarOrden','OrderController@pagarOrden')->name('pagar-orden');

Route::post('/mostrarOrdenes','OrderController@mostrarOrdenes')->name('mostrar-orden');
Route::get('/aceptarOrden/{orden_id}','OrderController@aceptarOrden')->name('aceptar-orden');
Route::get('/cancelarOrden/{orden_id}','OrderController@cancelarOrden')->name('cancelar-orden');
