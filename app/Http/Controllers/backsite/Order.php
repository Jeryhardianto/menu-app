<?php

namespace App\Http\Controllers\backsite;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Temporary;
use Illuminate\Console\View\Components\Alert;
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
    
              // create validation select payment and upload payment
            $validator = Validator::make($request->all(), [
                'metodebayar' => 'required|not_in:0',
            ],[
                'metodebayar.required' =>  'Pilih Metode Pembayaran',
                'metodebayar.not_in' =>  'Pilih Metode Pembayaran',
            ]);
    
            if ($validator) {
                return redirect()->route('payment')->withErrors($validator);
              }


        if($tmp_file){

            // validation file
            if($tmp_file->file == ''){
                return redirect()->route('payment')->withErrors('Upload Bukti Pembayaran');
            }



            // get file from storage
            $file = Storage::get('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
            // copy from storage to s3
            $result = Storage::disk('s3')->put('payment/'.$tmp_file->file, $file);
        
            // delete file and folder from storage
            Storage::delete('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
            // remove directory
            Storage::deleteDirectory('images/temp/'.$tmp_file->folder);
            // direct to payment page with success message
            return redirect()->route('paymentsuccess');
        }
        

    }

    public function paymentsuccess()
    {
        return view('pages.frontsite.order.paymentsuccess');
    }
}
