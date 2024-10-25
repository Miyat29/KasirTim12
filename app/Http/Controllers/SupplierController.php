<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier.index');
    }

    public function data()
    {
        $supplier = Supplier::orderBy('id_supplier', 'desc')->get();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('supplier.update', $supplier->id_supplier) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('supplier.destroy', $supplier->id_supplier) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
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
        // Validasi input data
        $request->validate([
            // Nama supplier harus diisi, berupa string, dan maksimal 255 karakter
            'nama' => 'required|string|max:255',

            // Nomor telepon harus diisi, berupa string, dan maksimal 15 karakter
            'telepon' => 'required|string|max:15',

            // Alamat harus diisi, berupa string, dan maksimal 255 karakter
            'alamat' => 'required|string|max:255',
        ]);

            // Cek apakah ada supplier dengan nama atau telepon yang sama di dalam database
            // Menggunakan query untuk mencari supplier yang memiliki nama atau telepon yang sama
            $existingSupplier = Supplier::where('nama', $request->nama)
                           // Menggunakan orWhere untuk mengecek nomor telepon juga
                           ->orWhere('telepon', $request->telepon)
                           // Ambil hanya satu data supplier yang pertama kali ditemukan
                           ->first();

                // Jika ditemukan supplier yang sama (nama atau telepon), hentikan proses dan kirimkan pesan error
                if ($existingSupplier) {
                    // Mengembalikan respon JSON dengan pesan bahwa nama atau nomor telepon sudah ada
                    // Status HTTP 400 menunjukkan Bad Request, yaitu input yang tidak valid
                    return response()->json(['message' => 'Nama atau nomor telepon supplier sudah ada!'], 400);
                }

                // Jika tidak ada supplier yang sama, simpan supplier baru ke database
                Supplier::create($request->all());

                // Mengembalikan respon JSON dengan pesan sukses
                // Status HTTP 200 menunjukkan bahwa proses berhasil
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
        $supplier = Supplier::find($id);

        return response()->json($supplier);
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
        // Validasi input data
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        // Cek apakah ada supplier lain dengan nama atau telepon yang sama (kecuali supplier ini sendiri)
        $existingSupplier = Supplier::where(function ($query) use ($request, $id) {
            $query->where('nama', $request->nama)
                ->orWhere('telepon', $request->telepon);
        })->where('id_supplier', '!=', $id) // Mengecualikan supplier yang sedang di-update
        ->first();

        if ($existingSupplier) {
            // Mengembalikan pesan error jika nama atau telepon sudah ada
            return response()->json(['message' => 'Nama atau nomor telepon supplier sudah ada!'], 400);
        }

        // Jika tidak ada duplikat, lanjutkan proses update
        Supplier::find($id)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Delete($id)
    {
        try {
            // Mencari supplier berdasarkan ID, jika tidak ditemukan akan menghasilkan error 404 (Not Found)
            $supplier = Supplier::findOrFail($id);
    
            // Cek apakah supplier sudah digunakan di tabel pembelian dengan relasi pembelian
            // Jika supplier sudah digunakan (misalnya ada transaksi yang terkait dengan supplier ini), maka proses penghapusan dibatalkan
            if ($supplier->pembelian()->exists()) {
                // Mengembalikan respons JSON dengan pesan bahwa supplier tidak bisa dihapus
                // dan status HTTP 400 (Bad Request) karena supplier sudah digunakan
                return response()->json(['message' => 'Supplier tidak dapat dihapus karena sudah digunakan di pembelian'], 400);
            }
    
            // Jika supplier belum digunakan, lanjutkan proses penghapusan
            $supplier->delete();
    
            // Mengembalikan respons JSON dengan pesan sukses dan status HTTP 200 (OK)
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat proses (misalnya masalah koneksi database atau query error)
            // Mengembalikan respons JSON dengan pesan gagal dan status HTTP 500 (Internal Server Error)
            return response()->json(['message' => 'Tidak dapat menghapus data'], 500);
        }
    }
    
}