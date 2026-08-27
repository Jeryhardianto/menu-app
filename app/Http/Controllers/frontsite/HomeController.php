<?php

namespace App\Http\Controllers\frontsite;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Subkategori;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function makanan()
    {
        return $this->katalog(1, 'Makanan');
    }

    public function minuman()
    {
        return $this->katalog(2, 'Minuman');
    }

    /**
     * Katalog satu kategori: semua subkategori ditumpuk jadi section dalam satu
     * halaman, dilompati lewat tombol Menu, bukan disaring per halaman.
     */
    private function katalog($idKategori, $title)
    {
        $subkategoris = Subkategori::where('id_kategori', $idKategori)
            ->with(['menus' => function ($q) {
                $q->orderByDesc('terjual')->orderBy('nama_menu');
            }])
            ->get()
            ->filter(function ($sk) {
                return $sk->menus->isNotEmpty();
            })
            ->values();

        return view('pages.frontsite.index', [
            'title' => $title,
            'subkategoris' => $subkategoris,
            'seringDibeli' => $this->menuPernahDipesan(),
        ]);
    }

    /**
     * Halaman custom pembelian. Kalau menunya sudah ada di keranjang, isian
     * lama dipakai sebagai nilai awal supaya halaman ini sekalian jadi edit.
     */
    public function custom($id)
    {
        $menu = Menu::findOrFail($id);
        $item = session()->get('cart')[$menu->id] ?? null;

        return view('pages.frontsite.custom', compact('menu', 'item'));
    }

    /**
     * Id menu yang pernah dipesan user ini, sumber badge "Sering dibeli lagi".
     */
    private function menuPernahDipesan()
    {
        if (!auth()->check()) {
            return [];
        }

        return DetailPesanan::whereIn('id_pesanan', Pesanan::where('id_user', auth()->id())->select('id'))
            ->distinct()
            ->pluck('id_menu')
            ->all();
    }

    public function getDetailMenu($id)
    {
        $menu = Menu::find($id);

        return response()->json([
            'status' => 'true',
            'data' => $menu,
        ], 200);
    }

    public function addToCart(Request $request)
    {
        $menu = Menu::find($request->id_nemu);
        $qty = (int) $request->qty;

        if (!$menu) {
            Alert::error('Error', 'Menu tidak ditemukan');
            return redirect()->back();
        }

        if ($qty < 1) {
            Alert::error('Error', 'Qty tidak boleh kurang dari 1');
            return redirect()->back();
        }

        if ($qty > $menu->stok) {
            Alert::error('Error', 'Stok ' . $menu->nama_menu . ' tinggal ' . $menu->stok);
            return redirect()->back();
        }

        $cart = session()->get('cart', []);

        // catatan ikut item, bukan array terpisah yang dicocokkan lewat urutan
        $cart[$menu->id] = [
            'id' => $menu->id,
            'nama' => $menu->nama_menu,
            'harga' => $menu->harga,
            'qty' => $qty,
            'catatan' => $request->input('catatan') ?: null,
        ];
        session()->put('cart', $cart);

        Alert::success('Sukses', 'Berhasil menambahkan menu ke keranjang');

        return redirect()->route(optional($menu->GetSubkategori)->id_kategori == 2 ? 'minuman' : 'makanan');
    }

    public function deleteCart($id)
    {
        $cart = session()->get('cart');
        unset($cart[$id]);
        session()->put('cart', $cart);
        Alert::success('Sukses', 'Berhasil menghapus menu dari keranjang');
        return redirect()->back();
    }
}
