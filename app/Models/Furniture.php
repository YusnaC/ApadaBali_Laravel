<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    protected $table = 'furnitures';
    protected $fillable = [
        'id_furniture',
        'tgl_pembuatan',
        'nama_furniture',
        'jumlah_unit',
        'harga_unit',
        'lokasi',
        'tgl_selesai'
    ];

    protected $dates = [
        'tgl_pembuatan',
        'tgl_selesai'
    ];
}