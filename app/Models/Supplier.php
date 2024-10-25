<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    protected $guarded = [];

    public function pembelian()
    {
        // Mendefinisikan relasi "hasMany" antara model Supplier dan model Pembelian
        // Artinya, satu supplier dapat memiliki banyak catatan pembelian (transaksi pembelian)
        // Relasi ini menghubungkan model Supplier dengan model Pembelian berdasarkan kolom 'id_supplier'
        return $this->hasMany(Pembelian::class, 'id_supplier');
    }
    
}
