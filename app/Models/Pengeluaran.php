<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
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