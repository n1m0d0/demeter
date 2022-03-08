<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const REGISTRADO = 1;
    const ACTIVO = 2;
    const INACTIVO = 3;
    const ENTREGADO = 4;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function way()
    {
        return $this->belongsTo(Way::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }
}
