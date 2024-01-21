<?php

namespace App\Http\Controllers\backsite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogSubkategori;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\Subkategori as ModelsSubkategori;
use AWS\CRT\Log;

class Subkategori extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subkategories = \App\Models\Subkategori::all();
        $logs = LogSubkategori::all();
        return view('pages.backsite.subkategori.index', compact('subkategories', 'logs'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategories = \App\Models\Kategori::all();
        return view('pages.backsite.subkategori.create', compact('kategories') );
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subkategori' => 'required',
            'kategori' => 'not_in:0'
        ],[
            'subkategori.required' =>  'Subkategori Harus Diisi',
            'kategori.not_in' =>  'Pilih Ketagori'
        ]);
     
        if ($validator->fails()) {
            return redirect()->route('subkategori.create')->withErrors($validator);
          }

          $sub = ModelsSubkategori::create([
            'subketagori' => $request->subkategori,
            'id_kategori' => $request->kategori
        ]);

        LogSubkategori::create([
            'id_user' => auth()->user()->id,
            'before' => null,
            'after' => json_encode($sub),
            'deskripsi' => 'Menambahkan Subkategori Baru',
            'created_at' => now()
        ]);

            if($sub){
                Alert::success('Berhasil', 'Subkategori Berhasil Ditambahkan');
                return redirect()->route('subkategori.index');
            }else{
                Alert::error('Gagal', 'Subkategori Gagal Ditambahkan');
                return redirect()->route('subkategori.create');
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
        $kategories = \App\Models\Kategori::all();
        $subkategori = \App\Models\SubKategori::find($id);
        return view('pages.backsite.subkategori.edit', compact('kategories', 'subkategori'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subkategori = ModelsSubkategori::find($id);

        $validator = Validator::make($request->all(), [
            'subkategori' => 'required',
            'kategori' => 'not_in:0'
        ],[
            'subkategori.required' =>  'Subkategori Harus Diisi',
            'kategori.not_in' =>  'Pilih Ketagori'
        ]);
     
        if ($validator->fails()) {
            return redirect()->route('subkategori.edit', $subkategori->id)->withErrors($validator);
          }
          $data = [
            'subketagori' => $request->subkategori,
            'id_kategori' => $request->kategori
          ];

          LogSubkategori::create([
            'id_user' => auth()->user()->id,
            'before' => json_encode($subkategori),
            'after' => json_encode($data),
            'deskripsi' => 'Mengubah data',
            'created_at' => now()
        ]);

          $subkategori->update([
            'subketagori' => $request->subkategori,
            'id_kategori' => $request->kategori
        ]);

       
     
            if($subkategori){
                Alert::success('Berhasil', 'Subkategori Berhasil Diupdate');
                return redirect()->route('subkategori.index');
            }else{
                Alert::error('Gagal', 'Subkategori Gagal Diupdate');
                return redirect()->route('subkategori.edit');
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subkategori = ModelsSubkategori::find($id);
        $subkategori->delete();
        Alert::success('Berhasil', 'Subkategori Berhasil Dihapus');
        return redirect()->route('subkategori.index');
    }
}
