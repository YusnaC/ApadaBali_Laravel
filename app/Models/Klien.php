<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klien extends Model
{
    use SoftDeletes;
    protected $table = 'klien'; 
  
    protected $fillable = [
        'id_klien',
        'jenis_order',
        'id_order',
        'nama_klien',
        'alamat_klien',
        'no_whatsapp'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($klien) {
            if (!$klien->id_klien) {
                $latestKlien = static::latest()->first();
                $number = $latestKlien ? intval(substr($latestKlien->id_klien, 1)) + 1 : 1;
                $klien->id_klien = 'K' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }

            if (!$klien->id_order) {
                $prefix = $klien->jenis_order === 'Proyek Arsitektur' ? 'ASB' : 'AFB';
                $latestOrder = static::where('jenis_order', $klien->jenis_order)->latest()->first();
                $number = $latestOrder ? intval(substr($latestOrder->id_order, 3)) + 1 : 1;
                $klien->id_order = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}