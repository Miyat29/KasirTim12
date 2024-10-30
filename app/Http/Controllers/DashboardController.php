<?php

namespace App\Http\Controllers;

use App\Models\member;
use App\Models\produk;
use App\Models\kategori;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $kategori = kategori::count(); 
        // count() digunakan untuk menghitung total record (baris data) yang ada di tabel yang bersangkutan.
        $produk   = produk::count();
        $supplier = Supplier::count();
        $member   = member::count();

        $tanggal_awal_asli = date('Y-m-01');
        $tanggal_akhir_asli = date('Y-m-d');

        $tanggal_awal = $tanggal_awal_asli;
        $tanggal_akhir = $tanggal_akhir_asli;

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir= date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan= array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal [] =(int) substr($tanggal_awal, 8, 2) ;
                                    // substr($tanggal_awal, 8, 2) mengambil dua karakter dari posisi ke-8 di $tanggal_awal yang mewakili hari dalam format YYYY-MM-DD.
         

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan []= $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        if (auth()->user()->level==1) {
           return view('admin.dashboard', compact('kategori','produk','supplier','member','tanggal_awal_asli','tanggal_akhir_asli','data_tanggal','data_pendapatan'));
        } else {
            return view('kasir.dashboard');
        }
    }
}
