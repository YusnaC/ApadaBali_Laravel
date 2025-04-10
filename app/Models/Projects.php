<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projects extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'projects';
    protected $primaryKey = 'id_proyek';
    public $timestamps = true;

    protected $fillable = [
        'id_proyek',
        'nama_proyek',
        'kategori',
        'tgl_proyek',
        'lokasi',
        'luas',
        'jumlah_lantai',
        'tgl_deadline',
        'id_drafter',
    ];
    public function drafter()
    {
        return $this->belongsTo(Drafter::class, 'id_drafter', 'id_drafter');
    } 
}
