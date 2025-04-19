<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    //
    protected $table = 'surat_jalan';
    protected $fillable = [
        'tanggal',
        'nama_penerima',
        'nama_produk',
        'jenis_kendaraan',
        'no_pol',
        'jumlah',
        'no_surat'
    ];
}
