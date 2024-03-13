<?php

namespace App\Http\Controllers\backsite;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\NomorMeja;
use Illuminate\Http\Request;

class Cron extends Controller
{

    public function index()
    {
        $menu = Menu::query()->update(['stok' => 5]);
        $nomormeja = NomorMeja::query()->update(['is_available' => false]);

        if ($menu && $nomormeja) {
            return response()->json([
                'message' => 'Data Berhasil Diupdate',
            ]);
        }


    }
}
