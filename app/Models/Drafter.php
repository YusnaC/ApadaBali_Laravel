<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drafter extends Model
{
    use SoftDeletes;
    
    protected $table = 'drafter';

    protected $fillable = [
        'id_drafter',
        'nama_drafter',
        'alamat_drafter',
        'no_whatsapp'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($drafter) {
            if (!$drafter->id_drafter) {
                $latestDrafter = static::latest()->first();
                $number = $latestDrafter ? intval(substr($latestDrafter->id_drafter, 1)) + 1 : 1;
                $drafter->id_drafter = 'D' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}