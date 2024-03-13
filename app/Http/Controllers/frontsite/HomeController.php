<?php

namespace App\Http\Controllers\frontsite;

use App\Models\Menu;
use App\Models\NomorMeja;
use App\Models\Subkategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function makanan(Request $request)
    {
        $title = "Makanan";

        $subkategoris   = Subkategori::where('id_kategori', 1)->get();
        $menus = Menu::query();

        if ($request->has('subkategori')) {
            $subkategoriId = $request->input('subkategori');
            $menus->where('id_subkategori', $subkategoriId);
        }else{
            $menus->where('id_subkategori', 2);
        }

        $menus = $menus->orderBy('terjual', 'desc')->get();

        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                'sumQty' => 0,
                'data' => []
            ];
        }else{
        //    sum qty
            $sumQty = 0;
            foreach ($cart as $item) {
                $sumQty += $item['qty'];
            }

            $cart = [
                'sumQty' => $sumQty,
                'data' => $cart
            ];
        }


        $nomormeja = session()->get('nomormeja');
        // catatan
        $catatan = session()->get('catatan');
        $nomormejas = NomorMeja::all();
       

      
        return view('pages.frontsite.index', compact('title','subkategoris', 'menus', 'cart', 'nomormeja', 'catatan', 'nomormejas'));
    }

    public function minuman(Request $request)
    {
        $title = "Minuman";
        $subkategoris   = Subkategori::where('id_kategori', 2)->get();
        $menus = Menu::query();

        if ($request->has('subkategori')) {
            $subkategoriId = $request->input('subkategori');
            $menus->where('id_subkategori', $subkategoriId);
        }else{
            $menus->where('id_subkategori', 5);
        }

        $menus = $menus->orderBy('terjual', 'desc')->get();

        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                'sumQty' => 0,
                'data' => []
            ];
        }else{
        //    sum qty
            $sumQty = 0;
            foreach ($cart as $item) {
                $sumQty += $item['qty'];
            }

            $cart = [
                'sumQty' => $sumQty,
                'data' => $cart
            ];
        }


        $nomormeja = session()->get('nomormeja');
        // catatan
        $catatan = session()->get('catatan');
        $nomormejas = NomorMeja::all();

      
        return view('pages.frontsite.index', compact('title','subkategoris', 'menus', 'cart', 'nomormeja', 'catatan', 'nomormejas'));
    }
    public function getDetailMenu($id)
    {

        $menu = Menu::find($id);
        $menu->harga = Rupiah($menu->harga);
        return response()->json(
            [
                'status' => 'true',
                'data' => $menu
            ], 200);

    }

    // put session to cart
    public function addToCart(Request $request)
    {


        $cart = session()->get('cart');

        $id = $request->id_nemu;
        $qty = $request->qty;

        // cek qty apakah lebih dari 1
        if ($qty < 1) {
            Alert::error('Error', 'Qty tidak boleh kurang dari 1');
            return redirect()->back();
        }

        $menu = Menu::find($id);

        $cart[$id] = [
            "id" => $menu->id,
            "nama" => $menu->nama_menu,
            "harga" => $menu->harga,
            "qty" => $qty
        ];
        session()->put('cart', $cart);
        Alert::success('Sukses', 'Berhasil menambahkan menu ke keranjang');
        return redirect()->back();
    }

    // delete session cart by id
    public function deleteCart($id)
    {
        $cart = session()->get('cart');
        unset($cart[$id]);
        session()->put('cart', $cart);
        Alert::success('Sukses', 'Berhasil menghapus menu dari keranjang');
        return redirect()->back();
    }

    public function landingPage( Request $request )
    {
        $subkategoris   = Subkategori::all();
        $menus = Menu::query();

        if ($request->has('subkategori')) {
            $subkategoriId = $request->input('subkategori');
            $menus->where('id_subkategori', $subkategoriId);
        }

        $menus = $menus->orderBy('terjual', 'desc')->get();

        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                'sumQty' => 0,
                'data' => []
            ];
        }else{
        //    sum qty
            $sumQty = 0;
            foreach ($cart as $item) {
                $sumQty += $item['qty'];
            }

            $cart = [
                'sumQty' => $sumQty,
                'data' => $cart
            ];
        }


        $nomormeja = session()->get('nomormeja');
        // catatan
        $catatan = session()->get('catatan');
        $nomormejas = NomorMeja::all();

        return view('pages.frontsite.landingpage', compact('subkategoris', 'menus', 'cart', 'nomormeja', 'catatan', 'nomormejas'));
    }

}
