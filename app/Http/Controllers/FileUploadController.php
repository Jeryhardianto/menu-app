<?php

namespace App\Http\Controllers;

use App\Models\Temporary;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function tmpUpload(Request $request): string
    {
        if ($request->file('buktibayar')) {
            return $this->uploadFile($request->file('buktibayar'));
        } else if ($request->file('gambarmenu')) {
            return $this->uploadFile($request->file('gambarmenu'));
        } else if ($request->file('fotoprofile')) {
            return $this->uploadFile($request->file('fotoprofile'));
        }

        return '';
    }

    private function uploadFile($file)
    {
        $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $folder = uniqid('images', true);
        $file->storeAs('images/temp/' . $folder, $fileName);
        Temporary::create([
            'folder' => $folder,
            'file' => $fileName,
        ]);
        return $folder;
    }
}
