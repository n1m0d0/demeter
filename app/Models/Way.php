<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Way extends Model
{
    use HasFactory;

    const ACTIVO = 1;
    const INACTIVO = 2;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
