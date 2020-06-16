<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    // Initialize
    protected $fillable = [
        'id_user', 'user', 'nama_kegiatan', 'jumlah',
    ];
}
