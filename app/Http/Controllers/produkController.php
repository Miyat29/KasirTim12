<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');

        return view('produk.index', compact('kategori'));
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            ->select('produk.*', 'nama_kategori')
            ->orderBy('produk.created_at', 'desc')
            ->get();
    
        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">
                ';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">'. $produk->kode_produk .'</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                // Format angka dengan pemisah ribuan
                return 'Rp .' . number_format($produk->harga_beli, 0, ',', '.');
            })
            ->addColumn('harga_jual', function ($produk) {
                // Format angka dengan pemisah ribuan
                return 'Rp .' . number_format($produk->harga_jual, 0, ',', '.');
            })
            ->addColumn('diskon', function ($produk) {
                return $produk->diskon . '%';
            })            
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok); // Gunakan helper format_uang jika sudah ada
            })
            ->addColumn('keterangan', function ($produk) {
               if ($produk->stok < 1) {
                    return '<span class="label label-danger">'. 'Stok Habis' .'</span>';
               } elseif ($produk->stok < 21) {
                 return '<span class="label label-warning">'. 'Stok Menipis' .'</span>';
               } elseif ($produk->stok < 50 ) {
               return '<span class="label label-success">'. 'Stok Cukup' .'</span>';
               }  elseif ($produk->stok > 50 ) {
                return '<span class="label label-info">'. 'Stok Banyak' .'</span>';
                }
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all', 'keterangan'])
            ->make(true);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Hilangkan titik pada harga_beli dan harga_jual sebelum disimpan
        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
          ]);
    
        $produk = Produk::latest()->first() ?? new Produk();
        $request['kode_produk'] = 'P' . tambah_nol_didepan((int)$produk->id_produk + 1, 6);
    
        $produk = Produk::create($request->all());
    
        return response()->json('Data berhasil disimpan', 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    // Hilangkan titik pada harga_beli dan harga_jual sebelum disimpan
    $request->merge([
        'harga_beli' => str_replace('.', '', $request->harga_beli),
        'harga_jual' => str_replace('.', '', $request->harga_jual),
        // 'diskon' => $request->diskon_produk ?? 0,  // Tambahkan validasi diskon default
    ]);

    $produk = Produk::find($id);
    $produk->update($request->all());

    return response()->json('Data berhasil disimpan', 200);
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $product = Product::find($id);

        $produk = Produk::findOrFail($id);

        //Kondisi untuk mengecek apakah produk sudah digunakan di penjualan dan pembelian
        //variabel terhubung dengan metode yang ada pada Model,dengan membuat method untuk merelasikan dengan objek yang ingin dicek
        if ($produk->penjualandetail()->exists() || $produk->pembeliandetail()->exists()) {
            return response()->json(['message' => 'Produk tidak dapat dihapus karena sudah digunakan di penjualan dan pembelian'], 400);
        }

        // Jika tidak digunakan di penjualan, maka dapat melanjutkan penghapusan
        $produk->delete();
        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            if ($produk->pembelian()->exists() || $produk->penjualan()->exists()) {
                return response()->json(['message' => 'Produk tidak dapat dihapus karena sudah digunakan di pembelian atau penjualan'], 400);
            }

            $produk->delete();
        }

        return response()->json('Data berhasil dihapus', 200);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = FacadePdf::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}