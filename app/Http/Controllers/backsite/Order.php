<?php

namespace App\Http\Controllers\backsite;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Order extends Controller
{
    public function index()
    {
    
        return view('pages.frontsite.order.index');
    }

    public function checkout(Request $request)
    {

   
        $validator = Validator::make($request->all(), [
            'nomormeja' => 'required',


        ],[
            'nomormeja.required' =>  'Nomor Meja Wajib Diisi'
        ]);


        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()]);
        }

        // check user is login
        if(!auth()->check()){
            return response()->json(['errors'=> 'Silahkan Login Terlebih Dahulu']);
        }

        return response()->json([
            'success' => true,
        ],Response::HTTP_OK);


    }

    public function payment()
    {
        // get session cart
        $carts = session()->get('cart');
        return view('pages.frontsite.order.payment', compact('carts'));
    }
}
