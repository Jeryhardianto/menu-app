<?php

namespace App\Http\Controllers\UserManegement;

use App\Http\Controllers\Controller;
use App\Models\Menu as ModelsMenu;
use App\Models\Temporary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class Account extends Controller
{
    public function index($id)
    {
        if ($id != auth()->user()->id) {
            Alert::error('Error', 'User tidak ditemukan');
            return redirect()->route('myaccount', auth()->user()->id);
        }
        $user = auth()->user();
        if (in_array($user->role, ['Kasir', 'Owner', 'Kitchen'])) {
            return view('pages.backsite.account.index', compact('user'));
        } else {
            return view('pages.frontsite.account.index', compact('user'));
        }

    }

    // update profile
    public function update(Request $request, $id)

    {

        $tmp_file = Temporary::where('folder', $request->fotoprofile)->first();

        // create validation select payment and upload payment
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ], [
            'nama.required' =>  'Nama Harus Diisi',
            'email.required' =>  'Email Harus Diisi',
            'alamat.required' =>  'Alamat Harus Diisi',
            'telepon.required' =>  'Telepon Harus Diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('myaccount', auth()->user()->id)->withErrors($validator);
        }


        if($tmp_file){

            // get file from storage
            $file = Storage::get('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
            // copy from storage to s3
            Storage::disk('s3')->put('users/'.$tmp_file->file, $file);

            // delete file and folder from storage
            Storage::delete('images/temp/'.$tmp_file->folder.'/'.$tmp_file->file);
            // remove directory
            Storage::deleteDirectory('images/temp/'.$tmp_file->folder);
            // create save to database table pesanan
            $user = auth()->user();
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'foto' => 'users/'.$tmp_file->file
            ]);

            if($user){
                Alert::success('Berhasil', 'Data Berhasil Diubah');
                return redirect()->route('myaccount', $user->id);
            }else{
                Alert::error('Gagal', 'Data Gagal Diubah');
                return redirect()->route('myaccount', $user->id);
            }

        }else{
            $user = auth()->user();
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);

            if($user){
                Alert::success('Berhasil', 'Data Berhasil Diubah');
                return redirect()->route('myaccount',$user->id);
            }else{
                Alert::error('Gagal', 'Data Gagal Diubah');
                return redirect()->route('myaccount',$user->id);
            }
        }
    }

    // reset password
    public function resetpassword(Request $request, $id)
    {
        if (request('passlama') == null || request('passbaru') == null || request('passulang') == null) {
            Alert::error('Gagal', 'Password Tidak Boleh Kosong');
            return redirect()->route('myaccount', auth()->user()->id);
        }

        //      cek password lama
        if (Hash::check(request('passlama'), auth()->user()->password)) {
            // cek password baru
            if (request('passbaru') == request('passulang')) {
                // update password
                auth()->user()->update([
                    'password' => Hash::make(request('passbaru'))
                ]);
                Alert::success('Berhasil', 'Password Berhasil Diubah');
                return redirect()->route('myaccount', auth()->user()->id);
            } else {
                Alert::error('Gagal', 'Password Baru Tidak Sama');
                return redirect()->route('myaccount', auth()->user()->id);
            }
        } else {
            Alert::error('Gagal', 'Password Lama Tidak Sama');
            return redirect()->route('myaccount', auth()->user()->id);
        }
    }

}
