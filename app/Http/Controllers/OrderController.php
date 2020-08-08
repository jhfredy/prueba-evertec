<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Dnetix\Redirection\PlacetoPay;


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
            $urlPlace=$this->placeToPay($order);
        DB::commit();
        return $urlPlace;
    } catch (\Exception $e) {
        
        DB::rollback();
        return response()->json([
            'errors' =>
            ['message' => ['Error '.$e]]], 422);
        }
    }
    
    public function placeToPay($order){
       
        $placetopay = new PlacetoPay([
            'login' => ' 6dd490faf9cb87a9862245da41170ff2',
            'tranKey' => '024h1IlD',
            'url' => 'https://dev.placetopay.com/redirection/',
            'rest' => [
                'timeout' => 45, 
                'connect_timeout' => 30, 
            ]
        ]);
       
        $reference = $order->id;
        $request = [
            'payment' => [
                'reference' => $reference,
                'description' => 'Pago',
                'amount' => [
                    'currency' => 'USD',
                    'total' => 120,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://example.com/response?reference=' . $reference,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];
        
        
        $response = $placetopay->request($request);
       
        if ($response->isSuccessful()) {
            return $response->processUrl();
        } else {
            // There was some error so check the message and log it
            return $response->status()->message();
        }
    }
}
