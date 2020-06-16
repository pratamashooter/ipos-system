<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    // Initialize
    protected $fillable = [
        'nama_toko', 'no_telp', 'alamat',
    ];
}
