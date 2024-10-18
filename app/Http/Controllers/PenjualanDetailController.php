<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Member;
use App\Models\Setting;
use App\Models\PenjualanDetail;
use App\Models\Penjualan;
use App\Models\produk;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index() {
        $produk = produk::orderBy('nama_produk')->get();
        $member = Member::orderBy('nama')->get();
        $diskon = Setting::first()->diskon ?? 0; 

        
        // Cek apakah ada transaksi yang sedang berjalan
       if ($id_penjualan = session('id_penjualan' )) {
            $penjualan = Penjualan::find($id_penjualan);
            $memberSelected = $penjualan->member ?? new Member();
            
            return view('penjualan_detail.index', compact('produk', 'member', 'diskon', 'id_penjualan', 'memberSelected', 'penjualan')); 
       } else {    
            if (auth()->user()->level == 0) {
                return redirect()->route('transaksi.baru'); 
            } else {
                return redirect()->route('dashboard');
            }
       }
       
    }

    public function data($id)
    {
        $detail = PenjualanDetail::with('produk') // Mengambil relasi produk
            ->where('id_penjualan', $id)
            ->get();
    
        $data = array();
        $total = 0;
        $total_item = 0;
    
        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<span class="label label-success">' . $item->produk['kode_produk'] . '</span>';
            $row['nama_produk'] = $item->produk->nama_produk;
            $row['harga_jual']  = 'Rp. ' . format_uang($item->harga_jual);
            $row['stok']        = '<span class="stok">'.$item->produk->stok.'</span>';
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_penjualan_detail .'"  value="' . $item->jumlah .'">';
    
            // Logika diskon produk, pastikan nilai diskon tidak null atau kosong
            $row['diskon']      = isset($item->produk->diskon) && $item->produk->diskon > 0 
                                  ? $item->produk->diskon . '%' 
                                  : '0%';
    
            $row['subtotal']    = 'Rp. ' . format_uang($item->subtotal);
            $row['action']      = '<div class="btn-group">
                                            <button onclick="deleteForm(`'. route('transaksi.destroy', $item->id_penjualan_detail).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                       </div>';
            $data[] = $row;
    
            // Menghitung total harga setelah diskon
            //$total += $item->harga_jual * $item->jumlah;
            $total += $item->harga_jual * $item->jumlah - (($item->diskon * $item->jumlah) / 100 * $item->harga_jual);
            $total_item += $item->jumlah;
        }
    
        // Memasukkan total dan total item untuk ditampilkan
        $data[] = [
            'kode_produk' => '
                <div class="total hide">'. $total .'</div> 
                <div class="total_item hide">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_jual'  => '',
            'stok'        => '',
            'jumlah'      => '',
            'diskon'      => '',
            'subtotal'    => '',
            'action'      => '',
        ];
    
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['action', 'kode_produk', 'jumlah', 'stok'])
            ->make(true);
    }
    
    
    
    public function store(Request $request) {
        $produk = produk::where('kode_produk', $request->kode_produk)->first();
        if (! $produk) {
            return response()->json('Data gagal disimpan', 404);
        }
        if ($produk->stok < $request->jumlah) {
            return response()->json(['message' => 'Stok produk tidak mencukupi!'], 400); 
        }
        $penjualanId = $request->id_penjualan ?? session('id_penjualan');
        if (!$penjualanId) {
         return response()->json(['message' => 'ID Penjualan tidak ditemukan'], 400);
        }
    
        $detail = new PenjualanDetail();
        $detail->id_penjualan = $request->id_penjualan;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_jual = $produk->harga_jual;
        $detail->jumlah = 1; 
        $detail->diskon = $produk->diskon; // Simpan diskon produk
        $detail->subtotal = ($produk->harga_jual * $detail->jumlah) 
            - (($produk->diskon / 100) * ($produk->harga_jual * $detail->jumlah)); // Hitung subtotal setelah diskon
        $detail->save();
    
        return response()->json( 'Data berhasil disimpan', 200);
    }
    


    public function update(Request $request, $id) {
        $detail = PenjualanDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_jual * $request->jumlah 
            - (($detail->diskon * $request->jumlah) / 100 * $detail->harga_jual); // Hitung subtotal setelah diskon
        $detail->save();
    
        return response()->json('Data berhasil diupdate', 200);
    }

    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();
       
        return response(null, 204);
    }

    public function loadForm($diskon = 0, $total, $diterima) 
    {
        
        $id_penjualan = session('id_penjualan'); // Ambil ID penjualan dari session
        $detailPenjualan = PenjualanDetail::where('id_penjualan', $id_penjualan)->get();
        $totalDiskon = 0;

        foreach ($detailPenjualan as $item) {
            //Hitung diskon per item
            $diskonItem = ($item->diskon / 100) * $item->harga_jual * $item->jumlah;
            $totalDiskon += $diskonItem; //Tambahkan ke total diskon
        }

       // Menghitung diskon untuk member berdasarkan persentase diskon
            $diskonMember = $total * ($diskon / 100); 
            // $diskonMember akan bernilai hasil dari $total dikalikan dengan persentase diskon (diskon / 100)

            // Menjumlahkan total diskon
            $diskonAll = $totalDiskon + $diskonMember; 
            // $diskonAll merupakan jumlah dari $totalDiskon (diskon yang sudah ada sebelumnya) ditambah $diskonMember

            // Menghitung total yang harus dibayar setelah diskon
            $bayar = $total - ($diskon / 100 * $total); 
            // $bayar merupakan nilai $total dikurangi dengan nilai diskon (persentase diskon dikalikan dengan $total)

            // Menghitung kembalian jika uang yang diterima lebih dari nol
            $kembali = ($diterima != 0) ? $diterima - $bayar : 0; 
            // Jika $diterima tidak sama dengan nol, maka $kembali adalah $diterima dikurangi $bayar
            // Jika $diterima sama dengan nol, maka $kembali bernilai 0

            // Membuat array $data yang akan digunakan untuk menyimpan hasil perhitungan dan format yang diperlukan
            $data = [
                'diskonrp' => format_uang($diskonAll), 
                // Menyimpan total diskon dalam format uang, misalnya "Rp 10.000"
                
                'totalrp' => format_uang($total), 
                // Menyimpan total sebelum diskon dalam format uang
                
                'bayar' => $bayar, 
                // Menyimpan nilai total yang harus dibayar setelah diskon tanpa format khusus
                
                'bayarrp' => format_uang($bayar), 
                // Menyimpan nilai $bayar dalam format uang, misalnya "Rp 50.000"
                
                'terbilang' => ucwords(terbilang($bayar). ' Rupiah'), 
                // Mengubah angka $bayar menjadi kata-kata, misalnya "Lima Puluh Ribu Rupiah"
                // ucwords berfungsi untuk mengubah setiap huruf awal dari setiap kata dalam sebuah string menjadi huruf kapital(huruf besar)
                
                'kembalirp' => format_uang($kembali), 
                // Menyimpan nilai kembalian dalam format uang
                
                'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah') 
                // Mengubah angka $kembali menjadi kata-kata, misalnya "Sepuluh Ribu Rupiah"
            ];
             


        return response()->json($data);
    }

    public function checkStok($id_produk, $jumlah)
    {
        $produk = produk::find($id_produk);

        if ($produk->stok < $jumlah) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jumlah yang diminta melebihi stok yang tersedia!',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Stok tersedia!',
        ]);
    }
}