<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function index()
    {
        return view('file.index');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads');

        return response()->json([
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_extension' => $file->getClientOriginalExtension(),
            'file_path' => $path,
        ]);
    }

    public function encrypt(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string',
            'key' => 'required|string|size:32',
        ]);

        $filePath = $request->file_path;
        $key = $request->key;
        $data = Storage::get($filePath);
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        $encryptedData = Crypt::encryptString($data);

        $encryptedFileName = Str::random(10);
        $encryptedFile = $encryptedFileName . '.' . $fileExtension . '.enc';
        Storage::put($encryptedFile, $encryptedData);

        return response()->json([
            'encrypted_file_path' => $encryptedFile,
        ]);
    }

    public function decrypt(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string',
            'key' => 'required|string|size:32',
        ]);

        $filePath = $request->file_path;
        $key = $request->key;
        $data = Storage::get($filePath);

        $decryptedData = Crypt::decryptString($data);

        $fileInfo = pathinfo($filePath);
        $originalExtension = explode('.', $fileInfo['filename']);
        $originalExtension = end($originalExtension);

        $decryptedFile = Str::random(10) . '_decrypted.' . $originalExtension;
        Storage::put($decryptedFile, $decryptedData);

        return response()->download(storage_path('app/' . $decryptedFile));
    }
}
