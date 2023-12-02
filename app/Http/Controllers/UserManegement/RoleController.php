<?php

namespace App\Http\Controllers\UserManegement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:post_show', ['only' => 'index']);
        $this->middleware('permission:post_create', ['only' => 'create', 'store']);
        $this->middleware('permission:post_update', ['only' => 'edit', 'update']);
        $this->middleware('permission:post_detail', ['only' => 'show']);
        $this->middleware('permission:post_delete', ['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('pages.backsite.manegementuser.role.index',[
            'roles' => Role::all()
        ]);
    }

    public function select(Request $request)
    {
        $roles = Role::select('id', 'name')->whereNot('name', 'SuperAdmin')->limit(7);
        if($request->has('q')){
            $roles->where('name', 'LIKE',"%{$request->q}%");
        }
        return response()->json($roles->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.backsite.manegementuser.role.create',[
            'authorities' => config('permission.authorities')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),[
            "name" => "required|string|max:50|unique:roles,name",
            "permissions" => "required"
       ],
       [],
        );
        if ($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

       DB::beginTransaction();
       try {
        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);
        Alert::success('Sukses','Data berhasil dibuat!');
        return redirect()->route('role.index');
       } catch (\Throwable $th) {
        DB::rollBack();
        Alert::error('Gagal','Data gagal dibuat!');
        return redirect()->back()->withInput($request->all());
       }finally{
        DB::commit();
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('pages.backsite.manegementuser.role.show',[
             'role' => $role,
             'authorities' => config('permission.authorities'),
             'rolePermissions' => $role->permissions->pluck('name')->toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('pages.backsite.manegementuser.role.edit',[
            'role' => $role,
            'authorities' => config('permission.authorities'),
            'permissionsChecked' => $role->permissions->pluck('name')->toArray()
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|string|max:50|unique:roles,name," . $role->id,
            "permissions" => "required"
       ],[]);
        if ($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        DB::beginTransaction();
        try {
         $role->name = $request->name;
         $role->syncPermissions($request->permissions);
         $role->save();
         Alert::success('Sukses','Data berhasil diubah!');
         return redirect()->route('role.index');
        } catch (\Throwable $th) {
         DB::rollBack();
         Alert::error('Gagal','Data gagal diubah!');
         return redirect()->back()->withInput($request->all());
        }finally{
         DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
         $role->revokePermissionTo($role->permissions->pluck('name')->toArray());
         $role->delete();
         Alert::success('Sukses','Data berhasil dihapus!');
        } catch (\Throwable $th) {
         DB::rollBack();
         Alert::error('Gagal','Data gagal dihapus!');
        }finally{
         DB::commit();
        }
        return redirect()->route('role.index');
    }
}
