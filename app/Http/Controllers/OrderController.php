<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class OrderController extends Controller
{
    public function guardarOrden(Request $request){
        $data=(object)$request->model;
        $attributes = [
            'customer_name' => 'Nombre',
            'customer_email' => 'Dirección de correo electrónico',
            'customer_mobile' => 'Número de celular'
        ];
        $validator=Validator::make($request->model,[
            'customer_name' => 'required|max:80|string',
            'customer_email' => 'required|max:120|email',
            'customer_mobile' => 'required|digits:10|string'

        ],[],$attributes);
        if ($validator->fails()) {
            return response()->json([
                'errors' =>
                ['message' => ['Error '.$validator->errors()->first()]]], 422);
        }

        DB::beginTransaction();
        try {
            $order=new Order();
            $order->customer_name=$data->customer_name;
            $order->customer_email=$data->customer_email;
            $order->customer_mobile=$data->customer_mobile;
            $order->status="CREATED";
            $order->save();
        DB::commit();
    } catch (\Exception $e) {
        
        DB::rollback();
        return response()->json([
            'errors' =>
            ['message' => ['Error '.$e]]], 422);
        }
    }
}
