<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $table = 'company';
    protected $fillable = [
        'company',
        'alamat_company',
        'no_telp',
        'owner',
        'email_company',
        'logo_company'
    ];
}
