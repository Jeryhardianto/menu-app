<?php

namespace App\Http\Controllers\backsite;

use AWS\CRT\Log;
use App\Models\LogMenu;
use App\Models\Temporary;
use Illuminate\Http\Request;
use App\Models\Menu as ModelsMenu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class Menu extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = ModelsMenu::all();
        $logs = LogMenu::all();
        return view('pages.backsite.menu.index', compact('menus', 'logs'));
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
    $validator = Validator::make($request->all(), [
        'namamenu' => 'required',
        'subkategori' => 'not_in:0',
        'harga' => 'required',
    ], [
        'namamenu.required' => 'Nama Menu Harus Diisi',
        'subkategori.not_in' => 'Pilih Ketagori',
        'harga.required' => 'Harga Harus Diisi',
    ]);

    if ($validator->fails()) {
        return redirect()->route('menu.create')->withErrors($validator);
    }

    $menuData = [
        'nama_menu' => $request->namamenu,
        'id_subkategori' => $request->subkategori,
        'harga' => $request->harga,
        'deskripsi' => $request->deskripsi,
        'is_available' => $request->status,
    ];

    $defaultImage = 'menu/default.svg';

    if ($tmpFile = Temporary::where('folder', $request->gambarmenu)->first()) {
        $file = Storage::get('images/temp/' . $tmpFile->folder . '/' . $tmpFile->file);
        Storage::disk('s3')->put('menu/' . $tmpFile->file, $file);
        Storage::delete('images/temp/' . $tmpFile->folder . '/' . $tmpFile->file);
        Storage::deleteDirectory('images/temp/' . $tmpFile->folder);
        $menuData['gambar'] = 'menu/' . $tmpFile->file;
    } else {
        $menuData['gambar'] = $defaultImage;
    }

    $menu = ModelsMenu::create($menuData);

    LogMenu::create([
        'id_user' => auth()->user()->id,
        'before' => null,
        'after' => json_encode($menu),
        'deskripsi' => 'Menambahkan Menu Baru',
        'created_at' => now(),
    ]);

    if ($menu) {
        Alert::success('Berhasil', 'Menu Berhasil Ditambahkan');
    } else {
        Alert::error('Gagal', 'Menu Gagal Ditambahkan');
    }

    return redirect()->route($menu ? 'menu.index' : 'menu.create');
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

public function update(Request $request, string $id)
{
    $menu = ModelsMenu::find($id);

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

    $data = [
        'nama_menu' => $request->namamenu,
        'id_subkategori' => $request->subkategori,
        'harga' => $request->harga,
        'deskripsi' => $request->deskripsi,
        'is_available' => $request->status,
    ];

    if ($tmp_file = Temporary::where('folder', $request->gambarmenu)->first()) {
        $file = Storage::get('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
        Storage::disk('s3')->put('menu/'.$tmp_file->file, $file);
        Storage::delete('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
        Storage::deleteDirectory('images/temp/'.$tmp_file->folder);
        $data['gambar'] = 'menu/'.$tmp_file->file;
    } else {
        $data['gambar'] = $menu->gambar;
    }
    LogMenu::create([
        'id_user' => auth()->user()->id,
        'before' => json_encode($menu),
        'after' => json_encode($data),
        'deskripsi' => 'Mengubah data',
        'updated_at' => now(),
    ]);

    $menu->update($data);


    if($menu){
        Alert::success('Berhasil', 'Menu Berhasil Diubah');
        return redirect()->route('menu.index');
    }else{
        Alert::error('Gagal', 'Menu Gagal Diubah');
        return redirect()->route('menu.create');
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
