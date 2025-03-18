<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Progres extends Model
{
    protected $table = 'progres';
    protected $primaryKey = 'id_progres';
    
    protected $fillable = [
        'id_proyek',
        'tgl_progres',
        'status_progres',
        'progres',
        'dokumen',
        'keterangan'
    ];

    protected $dates = ['tgl_progres'];

    public function proyek()
    {
        return $this->belongsTo(Project::class, 'id_proyek', 'id_proyek');
    }
}