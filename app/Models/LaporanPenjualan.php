<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPenjualan extends Model
{

    use HasFactory, Notifiable;
    protected $table = 'laporan_penjualan';
    protected $fillable = [
        'tanggal',
        'nama_pembeli',
        'nama_produk',
        'harga_jual',
        'jumlah',
        'total',
        'id_product'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
