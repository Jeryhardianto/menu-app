<?php

namespace App\Http\Controllers\backsite;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'Kasir'){
            $today = date('Y-m-d');
        $userId = Auth::user()->id;
    
        $totalPesanan = Pesanan::where('kasir', $userId)
                       ->whereDate('created_at', $today)
                       ->count();
    
        $totalPesananSelesai = Pesanan::where('id_status', 6)
                                ->where('kasir', $userId)
                                ->whereDate('created_at', $today)
                                ->count();
    
        $totalPesananDibatalkan = Pesanan::where('id_status', 4)
                                ->where('kasir', $userId)
                                ->whereDate('created_at', $today)
                                ->count();
        
        $totalPendapatan = Pesanan::where('id_status', 6)
                            ->where('kasir', $userId)
                            ->whereDate('created_at', $today)
                            ->sum('total');
        }else{
            $totalPesanan = Pesanan::count();

            $totalPesananSelesai = Pesanan::where('id_status', 6)
                                ->count();

            $totalPesananDibatalkan = Pesanan::where('id_status', 4)->count();

            $totalPendapatan = Pesanan::where('id_status', 6)
                            ->sum('total');
        }
        return view('pages.backsite.dashboard.index', compact('totalPesanan', 'totalPesananSelesai', 'totalPesananDibatalkan', 'totalPendapatan'));
    }
}
