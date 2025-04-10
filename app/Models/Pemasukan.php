<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemasukan extends Model
{
    protected $table = 'pemasukan';
    protected $primaryKey = 'id';
    use SoftDeletes;

    protected $fillable = [
        'jenis_order',
        'id_order',
        'tgl_transaksi',
        'jumlah',
        'termin',
        'keterangan'
    ];

    protected $dates = ['tgl_transaksi'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_order', 'id_order');
    }
}
