<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'keterangan', 
        'alias'
    ];

    public function getManager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }
}
