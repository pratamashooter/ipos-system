<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
   // Initialize
    protected $fillable = [
        'kode_barang', 'nama_barang', 'jumlah', 'harga_beli', 'id_pemasok', 'pemasok',
    ];
}