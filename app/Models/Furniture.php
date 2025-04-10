<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Furniture extends Model
{
    use SoftDeletes;
    
    protected $table = 'furniture';
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

    public function drafter()
    {
        return $this->belongsTo(Drafter::class, 'id_drafter', 'id_drafter');
    }
}