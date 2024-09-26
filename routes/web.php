<?php

use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\produkController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PembelianDetailController;
use App\Http\Controllers\PenjualanDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('landing');
});

Route::get('/landing', [LandingController::class, 'index'])->name('landing');
Route::get('landing', [LandingController::class, 'index'])->name('landing');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('login', [LoginController::class, 'index'])->name('login');

Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::group(['middleware' => 'level:1'], function () {

Route::get('/kategori/data', [kategoriController::class, 'data'])->name('kategori.data');
Route::delete('kategori/{id}', [KategoriController::class, 'delete'])->name('kategori.delete');
Route::resource('/kategori', kategoriController::class);

Route::get('/produk/data', [produkController::class, 'data'])->name('produk.data');
Route::post('/produk/delete-selected', [produkController::class, 'deleteSelected'])->name('produk.delete_selected');
Route::post('/produk/cetak-barcode', [produkController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
Route::resource('/produk', produkController::class);


Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
Route::resource('/member', MemberController::class);
Route::post('/member/cetak-member', [MemberController::class, 'cetakMember'])->name('member.cetak.member');

Route::get('/supplier/data', [supplierController::class, 'data'])->name('supplier.data');
Route::resource('/supplier', SupplierController::class);

Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
Route::resource('/pengeluaran', pengeluaranController::class);

Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
Route::resource('/pembelian', PembelianController::class)
->except('create');

Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadform'])->name('pembelian_detail.loadform');
Route::resource('/pembelian_detail', PembelianDetailController::class)
->except('create', 'show','edit');

Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

});

Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
Route::get('/transaksi/checkstok/{id_produk}/{jumlah}', [PenjualanDetailController::class, 'checkStok'])->name('cek_stok');
Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadform'])->name('transaksi.load_form');
Route::resource('/transaksi', PenjualanDetailController::class)
->except('show');

Route::group(['middleware' => 'level:1'], function (){

    Route::get('/laporan', [laporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
    Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('/user', UserController::class);

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
});

Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');


    });
    

