<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const ACTIVO = 1;
    const INACTIVO = 2;

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    
    public function details()
    {
        return $this->hasMany(Detail::class);
    }
}
