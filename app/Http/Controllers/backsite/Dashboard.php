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
        // count total pesanan
        $totalPesanan = Pesanan::count();
        // count total pesanan yang sudah selesai
        $totalPesananSelesai = Pesanan::where('id_status', 6)->count();
        // count total pesanan yang dibatalkan
        $totalPesananDibatalkan = Pesanan::where('id_status', 4)->count();
        // sum total pendapatan
        $totalPendapatan = Pesanan::where('id_status', 6)->sum('total');
        return view('pages.backsite.dashboard.index', compact('totalPesanan', 'totalPesananSelesai', 'totalPesananDibatalkan', 'totalPendapatan'));
    }
}
