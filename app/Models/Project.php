<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $primaryKey = 'id_proyek';
    public $timestamps = true;
    public $incrementing = false; // Tambahkan ini karena id_proyek bukan auto-increment
    protected $keyType = 'string'; // Pastikan primary key dianggap string

    protected $fillable = [
        'id_proyek',
        'kategori',
        'nama_proyek',
        'tgl_proyek',
        'lokasi',
        'luas',
        'jumlah_lantai',
        'tgl_deadline',
        'id_drafter',
    ]; 
}
