<?php

namespace App\Http\Controllers\backsite;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class Laporan extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->input('dari');
        $sampai = $request->input('sampai');
        $status = $request->input('status');
        if($dari && $sampai && $status){
              $orders = Pesanan::whereBetween('tanggal', [$dari, $sampai])->where('id_status', $status)->get();
        }elseif($dari && $sampai){
            $orders = Pesanan::whereBetween('tanggal', [$dari, $sampai])->get();
        
        }else{
            
            if ($status == "") {
                $orders = Pesanan::all();
            }else{
           
                $orders = Pesanan::where('id_status', $status)->get();
            }
        }
        return view('pages.backsite.laporan.index', compact('orders'));
    }
}
