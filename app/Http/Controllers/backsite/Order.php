<?php

namespace App\Http\Controllers\backsite;

use App\Models\Pesanan;
use App\Models\Temporary;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Console\View\Components\Alert;

class Order extends Controller
{
    public function index()
    {
     
        if (Auth::user()->role == 'Kasir') {
            
            $orders = Pesanan::orderBy('id', 'desc')->get();
            return view('pages.backsite.order.index', compact('orders'));
        }else if(Auth::user()->role == 'Kitchen'){
            $orders = Pesanan::where('id_status', 2)->orderBy('id', 'desc')->get();
            return view('pages.backsite.order.index', compact('orders'));
        }else{
            $orders = Pesanan::where('id_user', auth()->user()->id)->orderBy('id', 'desc')->get();
            return view('pages.frontsite.order.index', compact('orders'));
        }
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
            Storage::disk('s3')->put('payment/'.$tmp_file->file, $file);
        
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
                'bukti_bayar' => 'payment/'.$tmp_file->file,
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

    public function getDetailPesanan()
    {
        $id = request()->id;
        $detail = DetailPesanan::where('id_pesanan', $id)->get();
        
        $details = [];
        foreach($detail as $key => $value){
            $details[$key]['id'] = $value->id;
            $details[$key]['nama'] = $value->menu->nama_menu;
            $details[$key]['jumlah'] = $value->jumlah;
            $details[$key]['harga'] = $value->harga;
            $details[$key]['subtotal'] = $value->subtotal;
            $details[$key]['deskripsi'] = $value->deskripsi;
        }


        return response()->json([
            'success' => true,
            'data' => $details
        ],Response::HTTP_OK);
    }

    public function paymentsuccess()
    {
        return view('pages.frontsite.order.paymentsuccess');
    }

    // Updated status order
    public function updatestatus(Request $request)
    {
        
        $pesanan = Pesanan::find($request->id);
        $pesanan->id_status = $request->status;
        $pesanan->catatan = $request->alasan;
        $pesanan->save();

        if($pesanan){
            return response()->json([
                'success' => true,
                'message' => 'Status Pesanan Berhasil Diubah'
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Status Pesanan Gagal Diubah'
            ],Response::HTTP_OK);
        }
    }
}
