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
                $prefixes = [
                    'Proyek Arsitektur' => 'ASB',
                    'Jasa' => 'AJB',
                    'Furniture' => 'AJB',
                    // jenis_order lain sesuai kebutuhan
                ];
            
                // Ambil prefix berdasarkan jenis_order, default 'AFB' jika tidak ada
                $prefix = $prefixes[$klien->jenis_order] ?? 'AFB';
            
                // Ambil data terbaru yang sesuai jenis_order, urutkan berdasarkan nomor di id_order
                $latestOrder = static::where('jenis_order', $klien->jenis_order)
                    ->orderByRaw("CAST(SUBSTRING(id_order, 4) AS UNSIGNED) DESC")
                    ->first();
            
                // Ambil nomor urut dari id_order terbaru
                $number = $latestOrder ? intval(substr($latestOrder->id_order, 3)) + 1 : 1;
            
                // Buat id_order baru dengan prefix + nomor urut 4 digit
                $klien->id_order = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}