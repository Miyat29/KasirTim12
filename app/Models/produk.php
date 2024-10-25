<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; //untuk menghubungkan ke tabel produk
    protected $primaryKey = 'id_produk';//
    protected $guarded = [];

    public function pembeliandetail()
    {
        return $this->hasMany(PembelianDetail::class, 'id_produk');
    }
    //fungsi untuk membuat relasi dengan model PembelianDetail,jika produk sudah digunakan atau tidak

    public function penjualandetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_produk');
    }
    //fungsi untuk membuat relasi dengan model PenjualanDetail,jika produk sudah digunakan atau tidak
}
