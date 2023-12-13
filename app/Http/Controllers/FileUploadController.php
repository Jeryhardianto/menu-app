<?php

namespace App\Http\Controllers;

use App\Models\Temporary;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function tmpUpload(Request $request): string
    {
        
        if($request->file('buktibayar')){
     
            $file = $request->file('buktibayar');
            $fileName   = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $folder     = uniqid('images', true);
            $file->storeAs('images/temp/' . $folder, $fileName);
            Temporary::create([
                'folder'    => $folder,
                'file'  => $fileName,
            ]);
            return $folder;
        }else if($request->file('gambarmenu')){
            $file = $request->file('gambarmenu');
            $fileName   = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $folder     = uniqid('images', true);
            $file->storeAs('images/temp/' . $folder, $fileName);
            Temporary::create([
                'folder'    => $folder,
                'file'  => $fileName,
            ]);
            return $folder;
        }
        return '';
    }
}
