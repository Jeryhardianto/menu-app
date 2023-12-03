<?php

namespace App\Http\Controllers\backsite;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Temporary;
use Illuminate\Support\Facades\Storage;
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

    public function createorder(Request $request)
    {
    
        $tmp_file = Temporary::where('folder', $request->buktibayar)->first();
     
        if($tmp_file){
            // create validation select payment and upload payment
        $validator = Validator::make($request->all(), [
            'metodebayar' => 'required',
            'buktibayar' => 'required|mimes:jpg,png,jpeg|max:5048',
        ],[
            'payment.required' =>  'Pilih Metode Pembayaran',
            'buktibayar.required' =>  'Upload Bukti Pembayaran',
            'buktibayar.mimes' =>  'Format File Harus JPG, PNG, JPEG',
            'buktibayar.max' =>  'Ukuran File Maksimal 5MB',
        ]);

        if ($validator->fails()) {
            redirect()->back()->withErrors($validator->errors());
        }
        // get file from storage
        $file = Storage::get('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
        // copy from storage to s3
        $result = Storage::disk('s3')->put('payment/'.$tmp_file->file, $file);
      
        // delete file from storage
        Storage::delete('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
        dd($result);


     
        }
        

    }
}
