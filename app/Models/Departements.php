<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departements extends Model
{
    protected $fillable = ['name', 'location', 'manager_id'];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function getManager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }
}
