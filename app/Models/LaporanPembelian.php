<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPembelian extends Model
{
    //
    use HasFactory, Notifiable;
    protected $table = 'laporan_pembelian';
    protected $fillable = [
        'tanggal',
        'nama_supplier',
        'nama_produk',
        'harga_beli',
        'jumlah',
        'total',
        'id_product'
    ];
}
