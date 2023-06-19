<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_petugas', 
        'id_masjid', 
        'bagian',
    ];

    public function getJadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id');
    }
}
