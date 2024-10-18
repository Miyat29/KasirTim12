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
                return number_format($produk->harga_beli, 0, ',', '.');
            })
            ->addColumn('harga_jual', function ($produk) {
                // Format angka dengan pemisah ribuan
                return number_format($produk->harga_jual, 0, ',', '.');
            })
            ->addColumn('diskon_produk', function ($produk) {
                return $produk->diskon_produk ? $produk->diskon_produk . '%' : '0%';
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
            'diskon_produk' => $request->diskon_produk ?? 0,  // Tambahkan validasi diskon default
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
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
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