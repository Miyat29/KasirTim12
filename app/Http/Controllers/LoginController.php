<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class LoginController extends Controller
{
    public function index()
    {
        $setting = Setting::first(); // Ambil data setting, atau sesuaikan cara pengambilan datanya
        return view('auth.login', compact('setting')); // Kirim variabel $setting ke view
    }

    public function update(Request $request)
    {
        // Ambil setting yang akan diupdate
        $setting = Setting::first(); // Atau sesuaikan dengan cara Anda mengambil data setting
        
        // Cek apakah ada file logo yang diupload
        if ($request->hasFile('path_logo')) {
            $file = $request->file('path_logo');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            
            // Pindahkan file ke folder public/img
            $file->move(public_path('/img'), $nama);

            // Simpan path logo ke database
            $setting->path_logo = "/img/$nama";
            $setting->save(); // Simpan perubahan ke database
        }
    }
}
