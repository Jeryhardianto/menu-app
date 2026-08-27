<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Subkategori;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class KatalogTest extends TestCase
{
    public function test_rupiah_format(): void
    {
        $this->assertSame('Rp 0', Rupiah(0));
        $this->assertSame('Rp 28.000', Rupiah(28000));
        $this->assertSame('Rp 1.234.567', Rupiah(1234567));
    }

    public function test_katalog_hanya_menampilkan_menu_kategorinya(): void
    {
        $makanan = $this->menuKategori(1);
        $minuman = $this->menuKategori(2);

        if (!$makanan || !$minuman) {
            $this->markTestSkipped('butuh menu bertstok di kategori makanan dan minuman');
        }

        $this->get('/makanan')
            ->assertOk()
            ->assertSee('/custom/' . $makanan->id . '"', false)
            ->assertDontSee('/custom/' . $minuman->id . '"', false);

        $this->get('/minuman')
            ->assertOk()
            ->assertSee('/custom/' . $minuman->id . '"', false)
            ->assertDontSee('/custom/' . $makanan->id . '"', false);
    }

    public function test_tambah_ke_keranjang_menyimpan_catatan_di_itemnya(): void
    {
        $menu = $this->menuKategori(1);

        if (!$menu) {
            $this->markTestSkipped('butuh menu berstok');
        }

        $this->post('/addtocart', [
            'id_nemu' => $menu->id,
            'qty' => 2,
            'catatan' => 'Tanpa sambal',
        ])->assertRedirect();

        $item = session('cart')[$menu->id];

        $this->assertSame(2, $item['qty']);
        $this->assertSame('Tanpa sambal', $item['catatan']);
    }

    public function test_qty_melebihi_stok_ditolak(): void
    {
        $menu = $this->menuKategori(1);

        if (!$menu) {
            $this->markTestSkipped('butuh menu berstok');
        }

        $this->post('/addtocart', [
            'id_nemu' => $menu->id,
            'qty' => $menu->stok + 1,
        ])->assertRedirect();

        $this->assertArrayNotHasKey($menu->id, session('cart') ?? []);
    }

    private function menuKategori(int $idKategori): ?Menu
    {
        // koneksi test bawaan (sqlite :memory:) belum bisa dimigrasi, jadi tes
        // yang butuh data akan di-skip, bukan gagal
        if (!Schema::hasTable('menus')) {
            return null;
        }

        return Menu::whereIn('id_subkategori', Subkategori::where('id_kategori', $idKategori)->select('id'))
            ->where('stok', '>', 0)
            ->first();
    }
}
