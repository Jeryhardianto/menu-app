<?php

namespace App\Http\Controllers\frontsite;

use App\Models\Menu;
use App\Models\Subkategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index(Request $request)
    {


        $subkategoris   = Subkategori::all();
        $menus = Menu::query();

        if ($request->has('subkategori')) {
            $subkategoriId = $request->input('subkategori');
            $menus->where('id_subkategori', $subkategoriId);
        }

        $menus = $menus->get();

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

      
        return view('pages.frontsite.index', compact('subkategoris', 'menus', 'cart', 'nomormeja', 'catatan'));
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

}
