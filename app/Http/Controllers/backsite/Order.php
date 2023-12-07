<?php

namespace App\Http\Controllers\backsite;

use App\Models\Pesanan;
use App\Models\Temporary;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Console\View\Components\Alert;

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

        // put nomor meja to session
        session()->put('nomormeja', $request->nomormeja);
        
        // add session catatan multiple order
        session()->put('catatan', $request->catatan);

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
        $catatan = session()->get('catatan');
        // dd($catatan);
        return view('pages.frontsite.order.payment', compact('carts','catatan'));
    }

    public function createorder(Request $request)
    {
       
        $tmp_file = Temporary::where('folder', $request->buktibayar)->first();
    
              // create validation select payment and upload payment
            $validator = Validator::make($request->all(), [
                'metodebayar' => 'not_in:0',
                'buktibayar' => 'required',
            ],[
                'metodebayar.not_in' =>  'Pilih Metode Pembayaran',
                'buktibayar.required' =>  'Upload Bukti Pembayaran',
            ]);
         
            if ($validator->fails()) {
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
            // create save to database table pesanan
            $pesanan = Pesanan::create([
                'id_user' => auth()->user()->id,
                'no_transaksi' => 'TRX-'.time(),
                'nomor_meja' => session()->get('nomormeja'),
                'tanggal' => date('Y-m-d'),
                'waktu' => date('H:i:s'),
                'id_status' => 1,
                'total' => $request->total,
                'bukti_bayar' => $result,
                'metode_pembayaran' => $request->metodebayar,
            ]);

            // create save to database detail pesanan
            if($pesanan){
                $catatan = session()->get('catatan');
               
                $j = 0;
                foreach(session()->get('cart') as $key => $cart){
                   DetailPesanan::create([
                        'id_pesanan' => $pesanan->id,
                        'id_menu' => $cart['id'],
                        'jumlah' => $cart['qty'],
                        'harga' => $cart['harga'],
                        'subtotal' => $cart['qty'] * $cart['harga'],
                        'deskripsi' => $catatan[$j]
                   ]);
                     $j++;
                }
            }

                // delete session cart
                session()->forget('cart');
                session()->forget('nomormeja');
                session()->forget('catatan');
        
                // direct to payment page with success message
                return redirect()->route('paymentsuccess');
            }

        
        

    }

    public function paymentsuccess()
    {
        return view('pages.frontsite.order.paymentsuccess');
    }
}
