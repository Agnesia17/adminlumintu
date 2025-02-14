<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    //
    use HasFactory, Notifiable;
    protected $table = 'product';
    protected $fillable = [
        'nama_produk',
        'harga_beli',
        'harga_jual'
    ];
}
