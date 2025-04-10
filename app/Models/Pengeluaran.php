<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    use SoftDeletes;
    protected $table = 'pengeluaran'; // default-nya Laravel akan mengira 'pengeluarans'

    
    protected $fillable = [
        'tanggal_transaksi',
        'nama_barang',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'harga_satuan' => 'decimal:2',
        'total_harga' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($pengeluaran) {
            $pengeluaran->total_harga = $pengeluaran->jumlah * $pengeluaran->harga_satuan;
        });

        static::updating(function ($pengeluaran) {
            $pengeluaran->total_harga = $pengeluaran->jumlah * $pengeluaran->harga_satuan;
        });
    }
}