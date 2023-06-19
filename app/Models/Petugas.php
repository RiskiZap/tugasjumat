<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_petugas', 
        'nama_petugas', 
        'bulan',
        
    ];

    public function detail()
    {
        return $this->hasMany(Detail::class, 'id_petugas', 'id_petugas');
    }

    public function getManager()
    {
        return $this->belongsTo(User::class, 'nama_petugas', 'id');
    }
}
