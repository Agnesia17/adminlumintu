<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    protected $table = 'surat_tugas';
    protected $fillable = [
        'nama',
        'no_ktp',
        'no_surat',
        'alamat',
        'tanggal',
        'masa'
    ];
}
