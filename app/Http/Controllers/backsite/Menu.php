<?php

namespace App\Http\Controllers\backsite;

use App\Models\Temporary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu as ModelsMenu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class Menu extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = ModelsMenu::all();
        return view('pages.backsite.menu.index', compact('menus' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subkategories = \App\Models\SubKategori::all();
        return view('pages.backsite.menu.create', compact('subkategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $tmp_file = Temporary::where('folder', $request->gambarmenu)->first();

              // create validation select payment and upload payment
            $validator = Validator::make($request->all(), [
                'namamenu' => 'required',
                'subkategori' => 'not_in:0',
                'harga' => 'required',
            ],[
                'namamenu.required' =>  'Nama Menu Harus Diisi',
                'subkategori.not_in' =>  'Pilih Ketagori',
                'harga.required' =>  'Harga Harus Diisi',
            ]);

            if ($validator->fails()) {
                return redirect()->route('menu.create')->withErrors($validator);
              }

        if($tmp_file){
            // get file from storage
            $file = Storage::get('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
            // copy from storage to s3
            Storage::disk('s3')->put('menu/'.$tmp_file->file, $file);

            // delete file and folder from storage
            Storage::delete('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
            // remove directory
            Storage::deleteDirectory('images/temp/'.$tmp_file->folder);
            // create save to database table pesanan
            $menu = ModelsMenu::create([
                'nama_menu' => $request->namamenu,
                'id_subkategori' => $request->subkategori,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'gambar' => 'menu/'.$tmp_file->file
            ]);


                if($menu){
                    Alert::success('Berhasil', 'Menu Berhasil Ditambahkan');
                    return redirect()->route('menu.index');
                }else{
                    Alert::error('Gagal', 'Menu Gagal Ditambahkan');
                    return redirect()->route('menu.create');
                }

            }else{
                $menu = ModelsMenu::create([
                    'nama_menu' => $request->namamenu,
                    'id_subkategori' => $request->subkategori,
                    'harga' => $request->harga,
                    'deskripsi' => $request->deskripsi,
                    'gambar' => 'menu/default.svg'
                ]);
                if($menu){
                    Alert::success('Berhasil', 'Menu Berhasil Ditambahkan');
                    return redirect()->route('menu.index');
                }else{
                    Alert::error('Gagal', 'Menu Gagal Ditambahkan');
                    return redirect()->route('menu.create');
                }
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $menu = ModelsMenu::find($id);
        $subkategories = \App\Models\SubKategori::all();
        return view('pages.backsite.menu.edit', compact('menu', 'subkategories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = ModelsMenu::find($id);

        $tmp_file = Temporary::where('folder', $request->gambarmenu)->first();

              // create validation select payment and upload payment
            $validator = Validator::make($request->all(), [
                'namamenu' => 'required',
                'subkategori' => 'not_in:0',
                'harga' => 'required',
            ],[
                'namamenu.required' =>  'Nama Menu Harus Diisi',
                'subkategori.not_in' =>  'Pilih Ketagori',
                'harga.required' =>  'Harga Harus Diisi',
            ]);

            if ($validator->fails()) {
                return redirect()->route('menu.edit', $menu->id)->withErrors($validator);
              }

        if($tmp_file){

             // get file from storage
             $file = Storage::get('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
             // copy from storage to s3
             Storage::disk('s3')->put('menu/'.$tmp_file->file, $file);

             // delete file and folder from storage
             Storage::delete('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
             // remove directory
             Storage::deleteDirectory('images/temp/'.$tmp_file->folder);
             // create save to database table pesanan
              $menu->update([
                    'nama_menu' => $request->namamenu,
                    'id_subkategori' => $request->subkategori,
                    'harga' => $request->harga,
                    'deskripsi' => $request->deskripsi,
                    'gambar' => 'menu/'.$tmp_file->file
                ]);


                 if($menu){
                     Alert::success('Berhasil', 'Menu Berhasil Diubah');
                     return redirect()->route('menu.index');
                 }else{
                     Alert::error('Gagal', 'Menu Gagal Diubah');
                     return redirect()->route('menu.create');
                 }
        }else{

            $menu->update([
                'nama_menu' => $request->namamenu,
                'id_subkategori' => $request->subkategori,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'gambar' => $menu->gambar
            ]);


             if($menu){
                 Alert::success('Berhasil', 'Menu Berhasil Diubah');
                 return redirect()->route('menu.index');
             }else{
                 Alert::error('Gagal', 'Menu Gagal Diubah');
                 return redirect()->route('menu.create');
             }

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = ModelsMenu::find($id);
        $menu->delete();
        Alert::success('Berhasil', 'Menu Berhasil Dihapus');
        return redirect()->route('menu.index');
    }
}
